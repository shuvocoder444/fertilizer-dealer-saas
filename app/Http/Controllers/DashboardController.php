<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Super Admin Dashboard
        if ($user->hasRole('super-admin')) {
            $stats = [
                'total_dealers' => Dealer::count(),
                'active_dealers' => Dealer::where('status', 'active')->count(),
                'pending_dealers' => Dealer::where('status', 'pending')->count(),
                'total_plans' => SubscriptionPlan::where('is_active', true)->count(),
                'open_tickets' => SupportTicket::whereIn('status', ['Open', 'In Progress'])->count(),
                'estimated_mrr' => Dealer::where('status', 'active')
                    ->join('subscription_plans', 'dealers.subscription_plan_id', '=', 'subscription_plans.id')
                    ->sum('subscription_plans.price'),
            ];

            $recentDealers = Dealer::with('plan')->latest()->take(5)->get();
            $recentTickets = SupportTicket::with('user')->latest()->take(5)->get();
            $recentActivities = class_exists(Activity::class)
                ? Activity::latest()->take(6)->get()
                : collect();
            $announcements = Announcement::where('is_active', true)->latest()->take(3)->get();

            return view('dashboard', [
                'role' => 'super-admin',
                'stats' => $stats,
                'recentDealers' => $recentDealers,
                'recentTickets' => $recentTickets,
                'recentActivities' => $recentActivities,
                'announcements' => $announcements,
            ]);
        }

        // 2. Tenant / Dealer Dashboard
        $team = $user->currentTeam ?? $user->personalTeam();
        $teamId = $team ? $team->id : null;

        $dealer = Dealer::where('user_id', $user->id)
            ->orWhere('team_id', $teamId)
            ->first();

        $stats = [
            'today_sales' => Sale::where('team_id', $teamId)->whereDate('sale_date', today())->sum('total_amount'),
            'total_sales' => Sale::where('team_id', $teamId)->sum('total_amount'),
            'total_due' => Customer::where('team_id', $teamId)->sum('current_due'),
            'total_stock_bags' => Product::where('team_id', $teamId)->sum('stock_quantity'),
            'low_stock_count' => Product::where('team_id', $teamId)->whereColumn('stock_quantity', '<=', 'alert_quantity')->count(),
            'total_customers' => Customer::where('team_id', $teamId)->count(),
        ];

        $fertilizerStocks = Product::where('team_id', $teamId)->get();
        $recentSales = Sale::where('team_id', $teamId)->with('customer')->latest()->take(5)->get();
        $lowStockProducts = Product::where('team_id', $teamId)
            ->whereColumn('stock_quantity', '<=', 'alert_quantity')
            ->get();
        $announcements = Announcement::where('is_active', true)
            ->whereIn('target_audience', ['all', 'dealers'])
            ->latest()->take(3)->get();

        return view('dashboard', [
            'role' => 'dealer',
            'dealer' => $dealer,
            'team' => $team,
            'stats' => $stats,
            'fertilizerStocks' => $fertilizerStocks,
            'recentSales' => $recentSales,
            'lowStockProducts' => $lowStockProducts,
            'announcements' => $announcements,
        ]);
    }
}
