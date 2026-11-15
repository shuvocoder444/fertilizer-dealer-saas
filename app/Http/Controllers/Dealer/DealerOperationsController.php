<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\DueCollection;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StaffMember;
use App\Models\StaffSalary;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DealerOperationsController extends Controller
{
    protected function getTeamId()
    {
        $user = Auth::user();
        $team = $user->currentTeam ?? $user->personalTeam();
        return $team ? $team->id : null;
    }

    protected function getDealer()
    {
        $user = Auth::user();
        $teamId = $this->getTeamId();
        return Dealer::where('user_id', $user->id)
            ->orWhere('team_id', $teamId)
            ->first();
    }

    // 1. Dealership Outlets
    public function outlets()
    {
        $teamId = $this->getTeamId();
        $dealer = $this->getDealer();
        $outlets = Outlet::where('team_id', $teamId)->latest()->get();

        return view('dealer.outlets.index', compact('outlets', 'dealer'));
    }

    public function storeOutlet(Request $request)
    {
        $teamId = $this->getTeamId();
        $dealer = $this->getDealer();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'incharge_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Outlet::create(array_merge($validated, [
            'dealer_id' => $dealer?->id,
            'team_id' => $teamId,
            'is_main' => Outlet::where('team_id', $teamId)->count() === 0,
        ]));

        return redirect()->back()->with('success', 'নতুন আউটলেট/গোডাউন সফলভাবে যুক্ত হয়েছে!');
    }

    public function updateOutlet(Request $request, $id)
    {
        $teamId = $this->getTeamId();
        $outlet = Outlet::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $outlet->where('team_id', $teamId);
        }
        $outlet = $outlet->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'incharge_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'is_main' => 'nullable',
        ]);

        $isMain = $request->boolean('is_main');
        if ($isMain) {
            Outlet::where('team_id', $outlet->team_id)->where('id', '!=', $outlet->id)->update(['is_main' => false]);
        }

        $outlet->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? $outlet->code,
            'incharge_name' => $validated['incharge_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_main' => $isMain,
        ]);

        return redirect()->back()->with('success', "গোডাউন/আউটলেট '{$outlet->name}' এর তথ্য সফলভাবে আপডেট করা হয়েছে!");
    }

    public function setMainOutlet($id)
    {
        $teamId = $this->getTeamId();
        $outlet = Outlet::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $outlet->where('team_id', $teamId);
        }
        $outlet = $outlet->firstOrFail();

        Outlet::where('team_id', $outlet->team_id)->update(['is_main' => false]);
        $outlet->update(['is_main' => true]);

        return redirect()->back()->with('success', "'{$outlet->name}' কে প্রধান ডিপো (Main Godown) হিসেবে নির্ধারণ করা হয়েছে!");
    }

    public function destroyOutlet($id)
    {
        $teamId = $this->getTeamId();
        $outlet = Outlet::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $outlet->where('team_id', $teamId);
        }
        $outlet = $outlet->firstOrFail();
        $name = $outlet->name;

        // Unlink any staff from this outlet
        StaffMember::where('outlet_id', $outlet->id)->update(['outlet_id' => null]);

        $outlet->delete();

        return redirect()->back()->with('success', "গোডাউন/আউটলেট '{$name}' সফলভাবে মুছে ফেলা হয়েছে!");
    }

    // 2. Dealer Managers
    public function managers()
    {
        $teamId = $this->getTeamId();
        $user = Auth::user();
        $team = $user->currentTeam ?? $user->personalTeam();
        $members = $team ? $team->allUsers() : collect([$user]);
        $managerStaff = StaffMember::where('team_id', $teamId)
            ->where(function ($q) {
                $q->where('role_type', 'manager')->orWhere('has_login_access', true);
            })
            ->with(['outlet', 'user'])
            ->get();

        return view('dealer.managers.index', compact('members', 'managerStaff'));
    }

    // 3. Products & Stock
    public function products(Request $request)
    {
        $teamId = $this->getTeamId();
        $query = Product::where('team_id', $teamId);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('bangla_name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->paginate(15);
        $totalStockBags = Product::where('team_id', $teamId)->sum('stock_quantity');
        $lowStockCount = Product::where('team_id', $teamId)->whereColumn('stock_quantity', '<=', 'alert_quantity')->count();

        return view('dealer.products.index', compact('products', 'totalStockBags', 'lowStockCount'));
    }

    public function storeProduct(Request $request)
    {
        $teamId = $this->getTeamId();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bangla_name' => 'nullable|string|max:255',
            'category' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'unit' => 'required|string',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'alert_quantity' => 'nullable|numeric|min:0',
        ]);

        Product::create(array_merge($validated, [
            'team_id' => $teamId,
            'alert_quantity' => $validated['alert_quantity'] ?? 10,
            'is_active' => true,
        ]));

        return redirect()->back()->with('success', 'নতুন সার/পণ্য তালিকায় যুক্ত হয়েছে!');
    }

    public function updateStock(Request $request, $id)
    {
        $teamId = $this->getTeamId();
        $product = Product::where('team_id', $teamId)->findOrFail($id);

        $validated = $request->validate([
            'stock_quantity' => 'required|numeric|min:0',
            'buy_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', "{$product->bangla_name} এর স্টক আপডেট সম্পন্ন হয়েছে!");
    }

    // 4. Purchases (Stock In)
    public function purchases()
    {
        $teamId = $this->getTeamId();
        $purchases = Purchase::where('team_id', $teamId)->with('items.product')->latest()->paginate(15);
        $products = Product::where('team_id', $teamId)->get();

        return view('dealer.purchases.index', compact('purchases', 'products'));
    }

    public function storePurchase(Request $request)
    {
        $teamId = $this->getTeamId();

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'memo_no' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $teamId) {
            $totalAmount = $validated['quantity'] * $validated['unit_price'];
            $dueAmount = max(0, $totalAmount - $validated['paid_amount']);

            $purchase = Purchase::create([
                'team_id' => $teamId,
                'supplier_name' => $validated['supplier_name'],
                'memo_no' => $validated['memo_no'] ?? ('MEMO-' . rand(10000, 99999)),
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => $totalAmount,
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $dueAmount,
                'notes' => $validated['notes'],
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'unit_price' => $validated['unit_price'],
                'total_price' => $totalAmount,
            ]);

            // Increment product stock
            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock_quantity', $validated['quantity']);
        });

        return redirect()->back()->with('success', 'ক্রয় চালান সফলভাবে সংরক্ষণ ও স্টক বৃদ্ধি করা হয়েছে!');
    }

    // 5. Sales & Invoices
    public function sales(Request $request)
    {
        $teamId = $this->getTeamId();
        $query = Sale::where('team_id', $teamId)->with(['customer', 'items.product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $sales = $query->latest()->paginate(15);
        $customers = Customer::where('team_id', $teamId)->get();
        $products = Product::where('team_id', $teamId)->where('stock_quantity', '>', 0)->get();

        return view('dealer.sales.index', compact('sales', 'customers', 'products'));
    }

    public function storeSale(Request $request)
    {
        $teamId = $this->getTeamId();

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required_without:customer_id|nullable|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $teamId) {
            $product = Product::findOrFail($validated['product_id']);
            $qty = $validated['quantity'];
            $unitPrice = $validated['unit_price'];
            $subtotal = $qty * $unitPrice;
            $discount = $validated['discount'] ?? 0;
            $totalAmount = max(0, $subtotal - $discount);
            $paidAmount = min($totalAmount, $validated['paid_amount']);
            $dueAmount = max(0, $totalAmount - $paidAmount);

            $customer = null;
            if (!empty($validated['customer_id'])) {
                $customer = Customer::findOrFail($validated['customer_id']);
                $customerName = $customer->name;
            } else {
                $customerName = $validated['customer_name'] ?? 'ওয়াক-ইন কাস্টমার';
            }

            $paymentStatus = $dueAmount == 0 ? 'Paid' : ($paidAmount > 0 ? 'Partial' : 'Due');

            $sale = Sale::create([
                'team_id' => $teamId,
                'customer_id' => $customer?->id,
                'customer_name' => $customerName,
                'invoice_no' => 'INV-' . strtoupper(Str::random(8)),
                'sale_date' => now()->toDateString(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'notes' => $validated['notes'] ?? null,
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total_price' => $subtotal,
            ]);

            // Deduct stock
            $product->decrement('stock_quantity', $qty);

            // Update customer total purchased and due
            if ($customer) {
                $customer->increment('total_purchased', $totalAmount);
                if ($dueAmount > 0) {
                    $customer->increment('current_due', $dueAmount);
                }
            }
        });

        return redirect()->back()->with('success', 'বিক্রয় সম্পন্ন এবং ইনভয়েস তৈরি হয়েছে!');
    }

    // 6. Customers (Farmers & Retailers)
    public function customers(Request $request)
    {
        $teamId = $this->getTeamId();
        $query = Customer::where('team_id', $teamId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('village', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(15);
        $totalDue = Customer::where('team_id', $teamId)->sum('current_due');

        return view('dealer.customers.index', compact('customers', 'totalDue'));
    }

    public function storeCustomer(Request $request)
    {
        $teamId = $this->getTeamId();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'nid' => 'nullable|string|max:30',
            'customer_type' => 'required|in:Farmer,Sub-Dealer,Retailer',
            'village' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        Customer::create(array_merge($validated, [
            'team_id' => $teamId,
            'credit_limit' => $validated['credit_limit'] ?? 50000,
        ]));

        return redirect()->back()->with('success', 'নতুন কৃষক / কাস্টমার সফলভাবে নিবন্ধিত হয়েছে!');
    }

    public function showCustomer($id)
    {
        $teamId = $this->getTeamId();
        $user = Auth::user();
        $customer = Customer::with(['sales.items.product', 'dueCollections'])->findOrFail($id);

        if ($user && !$user->hasRole('super-admin') && $teamId && $customer->team_id && $customer->team_id != $teamId) {
            abort(403, 'এই কৃষকের প্রোফাইল দেখার অনুমতি আপনার নেই।');
        }

        $sales = $customer->sales()->latest()->paginate(15);
        $collections = $customer->dueCollections()->latest()->get();
        $totalPaid = $customer->sales()->sum('paid_amount') + $customer->dueCollections()->sum('amount');

        return view('dealer.customers.show', compact('customer', 'sales', 'collections', 'totalPaid'));
    }

    public function destroyCustomer($id)
    {
        $teamId = $this->getTeamId();
        $query = Customer::query();
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        $customer = $query->findOrFail($id);

        $customerName = $customer->name;
        $customer->delete();

        return redirect()->route('dealer.customers.index')->with('success', "কৃষক/কাস্টমার '{$customerName}' সফলভাবে মুছে ফেলা হয়েছে!");
    }

    // 7. Due / Credit Ledger
    public function dues()
    {
        $teamId = $this->getTeamId();
        $customersWithDue = Customer::where('team_id', $teamId)
            ->where('current_due', '>', 0)
            ->orderByDesc('current_due')
            ->paginate(15);

        $recentCollections = DueCollection::where('team_id', $teamId)->with('customer')->latest()->take(10)->get();
        $totalDue = Customer::where('team_id', $teamId)->sum('current_due');

        return view('dealer.dues.index', compact('customersWithDue', 'recentCollections', 'totalDue'));
    }

    public function collectDue(Request $request)
    {
        $teamId = $this->getTeamId();

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $teamId) {
            $customer = Customer::findOrFail($validated['customer_id']);
            $collectedAmount = min($customer->current_due, $validated['amount']);

            DueCollection::create([
                'team_id' => $teamId,
                'customer_id' => $customer->id,
                'amount' => $collectedAmount,
                'payment_method' => $validated['payment_method'],
                'collection_date' => now()->toDateString(),
                'receipt_no' => 'REC-' . rand(10000, 99999),
                'notes' => $validated['notes'],
            ]);

            $customer->decrement('current_due', $collectedAmount);
        });

        return redirect()->back()->with('success', 'বাকি টাকা সফলভাবে আদায় ও খতিয়ানে জমা করা হয়েছে!');
    }

    // 8. Order Requests
    public function orders()
    {
        $teamId = $this->getTeamId();
        $products = Product::where('team_id', $teamId)->get();
        $customers = Customer::where('team_id', $teamId)->get();

        return view('dealer.orders.index', compact('products', 'customers'));
    }

    // 9. Reports & AI Forecast
    public function reports()
    {
        $teamId = $this->getTeamId();
        $products = Product::where('team_id', $teamId)->get();
        $totalSalesAmount = Sale::where('team_id', $teamId)->sum('total_amount');
        $totalDue = Customer::where('team_id', $teamId)->sum('current_due');
        $salesByMonth = Sale::where('team_id', $teamId)
            ->selectRaw("strftime('%Y-%m', sale_date) as month, sum(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        return view('dealer.reports.index', compact('products', 'totalSalesAmount', 'totalDue', 'salesByMonth'));
    }

    // 10. Staff Management
    public function staff(Request $request)
    {
        $teamId = $this->getTeamId();
        $query = StaffMember::with(['outlet', 'user'])
            ->where('team_id', $teamId);

        if ($request->filled('role_type')) {
            $query->where('role_type', $request->role_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $staffMembers = $query->latest()->get();
        $outlets = Outlet::where('team_id', $teamId)->get();

        $totalStaff = StaffMember::where('team_id', $teamId)->count();
        $activeStaff = StaffMember::where('team_id', $teamId)->where('status', 'active')->count();
        $totalMonthlyPayroll = StaffMember::where('team_id', $teamId)->where('status', 'active')->sum('monthly_salary');
        $paidThisMonth = StaffSalary::where('team_id', $teamId)
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');

        return view('dealer.staff.index', compact('staffMembers', 'outlets', 'totalStaff', 'activeStaff', 'totalMonthlyPayroll', 'paidThisMonth'));
    }

    public function storeStaff(Request $request)
    {
        $teamId = $this->getTeamId();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'designation' => 'required|string|max:255',
            'role_type' => 'required|string', // manager, staff, cashier, incharge, delivery
            'outlet_id' => 'nullable|exists:outlets,id',
            'nid' => 'nullable|string|max:50',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'monthly_salary' => 'nullable|numeric|min:0',
            'emergency_contact' => 'nullable|string|max:50',
            'has_login_access' => 'nullable',
            'login_password' => 'nullable|string|min:6',
        ]);

        $userId = null;
        $hasAccess = $request->boolean('has_login_access');

        if ($hasAccess && !empty($validated['email'])) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $password = $request->input('login_password') ?: 'password123';
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => bcrypt($password),
                    'current_team_id' => $teamId,
                ]);

                $roleToAssign = ($validated['role_type'] === 'manager') ? 'dealer-manager' : 'salesman';
                try {
                    $user->assignRole($roleToAssign);
                } catch (\Throwable $e) {}

                $team = Auth::user()?->currentTeam;
                if ($team && !$team->hasUser($user)) {
                    $team->users()->attach($user, ['role' => ($validated['role_type'] === 'manager' ? 'admin' : 'editor')]);
                }
            }
            $userId = $user->id;
        }

        $staff = StaffMember::create([
            'team_id' => $teamId,
            'user_id' => $userId,
            'outlet_id' => $validated['outlet_id'] ?? null,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'designation' => $validated['designation'],
            'role_type' => $validated['role_type'],
            'nid' => $validated['nid'] ?? null,
            'present_address' => $validated['present_address'] ?? null,
            'permanent_address' => $validated['permanent_address'] ?? null,
            'joining_date' => $validated['joining_date'] ?? now()->toDateString(),
            'monthly_salary' => $validated['monthly_salary'] ?? 0,
            'status' => 'active',
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'has_login_access' => $hasAccess,
        ]);

        return redirect()->route('dealer.staff.show', $staff->id)
            ->with('success', "কর্মী/ম্যানেজার '{$staff->name}' সফলভাবে নিবন্ধিত হয়েছে!");
    }

    public function showStaff($id)
    {
        $teamId = $this->getTeamId();
        $staff = StaffMember::with(['outlet', 'user', 'salaries.recorder'])
            ->where('id', $id);

        if (!Auth::user()->hasRole('super-admin')) {
            $staff->where('team_id', $teamId);
        }

        $staff = $staff->firstOrFail();

        $salaries = $staff->salaries()->orderBy('payment_date', 'desc')->get();
        $totalPaid = $staff->totalPaid();
        $totalThisYear = $staff->totalThisYear();
        $totalThisMonth = $staff->totalThisMonth();
        $advancePaid = $staff->salaries()->where('payment_type', 'advance')->sum('amount');
        $outlets = Outlet::where('team_id', $staff->team_id)->get();

        return view('dealer.staff.show', compact('staff', 'salaries', 'totalPaid', 'totalThisYear', 'totalThisMonth', 'advancePaid', 'outlets'));
    }

    public function storeStaffSalary(Request $request, $id)
    {
        $teamId = $this->getTeamId();
        $staff = StaffMember::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $staff->where('team_id', $teamId);
        }
        $staff = $staff->firstOrFail();

        $validated = $request->validate([
            'month_year' => 'required|string|max:50',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|string', // salary, advance, bonus, allowance
            'payment_method' => 'required|string', // cash, bkash, nagad, bank
            'note' => 'nullable|string|max:500',
        ]);

        StaffSalary::create([
            'team_id' => $staff->team_id,
            'staff_member_id' => $staff->id,
            'month_year' => $validated['month_year'],
            'payment_date' => $validated['payment_date'],
            'amount' => $validated['amount'],
            'payment_type' => $validated['payment_type'],
            'payment_method' => $validated['payment_method'],
            'note' => $validated['note'] ?? null,
            'recorded_by' => Auth::id(),
        ]);

        return back()->with('success', "৳ " . number_format($validated['amount']) . " টাকা বেতন/পরিশোধের এন্ট্রি সফলভাবে সম্পন্ন হয়েছে!");
    }

    public function destroyStaffSalary($id)
    {
        $teamId = $this->getTeamId();
        $salary = StaffSalary::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $salary->where('team_id', $teamId);
        }
        $salary = $salary->firstOrFail();
        $salary->delete();

        return back()->with('success', 'বেতনের এন্ট্রিটি সফলভাবে মুছে ফেলা হয়েছে।');
    }

    public function destroyStaff($id)
    {
        $teamId = $this->getTeamId();
        $staff = StaffMember::where('id', $id);
        if (!Auth::user()->hasRole('super-admin')) {
            $staff->where('team_id', $teamId);
        }
        $staff = $staff->firstOrFail();
        $staffName = $staff->name;
        $staff->delete();

        return redirect()->route('dealer.staff.index')->with('success', "কর্মী '{$staffName}' এর প্রোফাইল ও রেকর্ড সফলভাবে মুছে ফেলা হয়েছে।");
    }

    // 11. My Subscription
    public function subscription()
    {
        $dealer = $this->getDealer();
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('dealer.subscription.index', compact('dealer', 'plans'));
    }
}
