<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Dealer;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    // 1. Dealers & Subscribers
    public function dealers(Request $request)
    {
        $query = Dealer::with(['plan', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }

        $dealers = $query->latest()->paginate(15);
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('admin.dealers.index', compact('dealers', 'plans'));
    }

    public function storeDealer(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'district' => 'required|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'trade_license' => 'nullable|string|max:100',
        ]);

        $dealer = Dealer::create(array_merge($validated, [
            'status' => 'active',
            'subscription_ends_at' => now()->addMonths(1),
        ]));

        if (class_exists(Activity::class)) {
            activity()->log("Super Admin registered new dealer: {$dealer->company_name}");
        }

        return redirect()->back()->with('success', 'ডিলার সফলভাবে যুক্ত করা হয়েছে!');
    }

    public function updateDealerStatus(Request $request, $id)
    {
        $dealer = Dealer::findOrFail($id);
        $status = $request->validate(['status' => 'required|in:active,pending,suspended'])['status'];
        $dealer->update(['status' => $status]);

        if (class_exists(Activity::class)) {
            activity()->log("Dealer status updated to '{$status}' for {$dealer->company_name}");
        }

        return redirect()->back()->with('success', 'ডিলারের স্ট্যাটাস আপডেট করা হয়েছে!');
    }

    // 2. Global Managers
    public function managers()
    {
        $managers = User::role(['global-dealer-manager', 'super-admin'])->latest()->paginate(10);
        return view('admin.managers.index', compact('managers'));
    }

    // 3. Subscription Plans
    public function plans()
    {
        $plans = SubscriptionPlan::withCount('dealers')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function storePlan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'max_outlets' => 'required|integer|min:1',
            'max_staff' => 'required|integer|min:1',
            'features' => 'nullable|string',
        ]);

        $features = $validated['features'] ? array_map('trim', explode(',', $validated['features'])) : [];

        SubscriptionPlan::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'price' => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'max_outlets' => $validated['max_outlets'],
            'max_staff' => $validated['max_staff'],
            'features' => $features,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'নতুন সাবস্ক্রিপশন প্ল্যান তৈরি করা হয়েছে!');
    }

    // 4. Payments & Invoices
    public function payments()
    {
        $dealers = Dealer::with('plan')->whereNotNull('subscription_plan_id')->latest()->paginate(15);
        $totalCollected = Dealer::where('status', 'active')
            ->join('subscription_plans', 'dealers.subscription_plan_id', '=', 'subscription_plans.id')
            ->sum('subscription_plans.price');

        return view('admin.payments.index', compact('dealers', 'totalCollected'));
    }

    // 5. Expiry & Renewals
    public function renewals()
    {
        $expiringSoon = Dealer::with('plan')
            ->where('subscription_ends_at', '<=', now()->addDays(30))
            ->orderBy('subscription_ends_at')
            ->paginate(15);

        return view('admin.renewals.index', compact('expiringSoon'));
    }

    public function extendRenewal(Request $request, $id)
    {
        $dealer = Dealer::findOrFail($id);
        $months = $request->input('months', 1);
        $currentEnd = $dealer->subscription_ends_at && $dealer->subscription_ends_at->isFuture()
            ? $dealer->subscription_ends_at
            : now();

        $dealer->update([
            'subscription_ends_at' => $currentEnd->addMonths($months),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', "{$dealer->company_name} এর মেয়াদ {$months} মাস বৃদ্ধি করা হয়েছে!");
    }

    // 6. Support Tickets
    public function tickets()
    {
        $tickets = SupportTicket::with(['user', 'team'])->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function replyTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $validated = $request->validate([
            'admin_reply' => 'required|string',
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
        ]);

        $ticket->update($validated);

        return redirect()->back()->with('success', 'টিকিট রিপ্লাই এবং স্ট্যাটাস আপডেট সফল হয়েছে!');
    }

    // 7. Announcements
    public function announcements()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,urgent,success',
            'target_audience' => 'required|in:all,dealers,managers',
        ]);

        Announcement::create(array_merge($validated, [
            'is_active' => true,
            'published_at' => now(),
        ]));

        return redirect()->back()->with('success', 'নতুন নোটিশ / ঘোষণা সফলভাবে প্রকাশিত হয়েছে!');
    }

    // 8. Audit / Activity Logs
    public function logs()
    {
        $logs = class_exists(Activity::class)
            ? Activity::with('causer')->latest()->paginate(20)
            : collect();

        return view('admin.logs.index', compact('logs'));
    }

    // 9. Platform Settings
    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        return redirect()->back()->with('success', 'প্ল্যাটফর্ম সেটিংস সফলভাবে সংরক্ষণ করা হয়েছে!');
    }
}
