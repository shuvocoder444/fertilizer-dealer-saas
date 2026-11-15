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

        return redirect()->back()->with('success', 'নতুন আউটলেট সফলভাবে যুক্ত হয়েছে!');
    }

    // 2. Dealer Managers
    public function managers()
    {
        $teamId = $this->getTeamId();
        $user = Auth::user();
        $team = $user->currentTeam ?? $user->personalTeam();
        $members = $team ? $team->allUsers() : collect([$user]);

        return view('dealer.managers.index', compact('members'));
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
        $query = Customer::with(['sales.items.product', 'dueCollections']);
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        $customer = $query->findOrFail($id);

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
    public function staff()
    {
        $teamId = $this->getTeamId();
        $user = Auth::user();
        $team = $user->currentTeam ?? $user->personalTeam();
        $staffMembers = $team ? $team->allUsers() : collect([$user]);

        return view('dealer.staff.index', compact('staffMembers'));
    }

    // 11. My Subscription
    public function subscription()
    {
        $dealer = $this->getDealer();
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('dealer.subscription.index', compact('dealer', 'plans'));
    }
}
