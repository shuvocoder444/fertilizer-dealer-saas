<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('বিক্রয় ও চালান ব্যবস্থাপনা (Sales & Invoices)') }}
            </h2>
            <button onclick="document.getElementById('newSaleModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন বিক্রয় চালান (POS Sale)
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <form method="GET" action="{{ route('dealer.sales.index') }}" class="flex gap-3 items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ইনভয়েস নং বা ক্রেতার নাম দিয়ে খুঁজুন..." class="text-sm rounded-lg border-gray-300 w-72 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg">সার্চ</button>
                    @if(request('search'))
                        <a href="{{ route('dealer.sales.index') }}" class="text-sm text-gray-500 hover:text-gray-700">রিসেট</a>
                    @endif
                </form>
            </div>

            <!-- Invoices Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">চালান নং</th>
                                <th class="px-5 py-3.5">তারিখ</th>
                                <th class="px-5 py-3.5">ক্রেতা / কৃষক</th>
                                <th class="px-5 py-3.5">আইটেম সংখ্যা</th>
                                <th class="px-5 py-3.5">মোট মূল্য</th>
                                <th class="px-5 py-3.5">পরিশোধ</th>
                                <th class="px-5 py-3.5">বাকি (Due)</th>
                                <th class="px-5 py-3.5">পেমেন্ট মেথড</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sales as $sale)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $sale->invoice_no }}</td>
                                    <td class="px-5 py-4 text-xs">{{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-800">{{ $sale->customer_name }}</div>
                                        @if($sale->customer)
                                            <div class="text-xs text-gray-400">{{ $sale->customer->phone }} | {{ $sale->customer->village }}</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-xs font-medium">{{ $sale->items->count() }} টি সার আইটেম</td>
                                    <td class="px-5 py-4 font-bold text-gray-900">৳ {{ number_format($sale->total_amount) }}</td>
                                    <td class="px-5 py-4 font-semibold text-emerald-600">৳ {{ number_format($sale->paid_amount) }}</td>
                                    <td class="px-5 py-4 font-semibold {{ $sale->due_amount > 0 ? 'text-red-600' : 'text-gray-400' }}">৳ {{ number_format($sale->due_amount) }}</td>
                                    <td class="px-5 py-4 text-xs">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">{{ $sale->payment_method }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold {{ $sale->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : ($sale->payment_status === 'Partial' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $sale->payment_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-5 py-8 text-center text-gray-400">কোনো বিক্রয় রেকর্ড পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($sales->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $sales->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- New Sale Modal (Quick POS) -->
    <div id="newSaleModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন সার বিক্রয় এন্ট্রি (POS Entry)</h3>
                <button onclick="document.getElementById('newSaleModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.sales.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">নিবন্ধিত ক্রেতা / কৃষক নির্বাচন করুন</label>
                    <select name="customer_id" class="w-full text-sm rounded-lg border-gray-300">
                        <option value="">-- সাধারণ কাস্টমার (Walk-in) --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }}) - বর্তমান বাকি: ৳{{ number_format($c->current_due) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">অথবা নতুন ক্রেতার নাম</label>
                    <input type="text" name="customer_name" placeholder="মোঃ আনসার আলী" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">সারের নাম নির্বাচন করুন *</label>
                    <select name="product_id" required class="w-full text-sm rounded-lg border-gray-300" onchange="updateProductPrice(this)">
                        <option value="">-- সার নির্বাচন করুন --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" data-price="{{ $p->sell_price }}" data-stock="{{ $p->stock_quantity }}">
                                {{ $p->bangla_name ?? $p->name }} (মজুদ: {{ $p->stock_quantity }} {{ $p->unit }} | মূল্য: ৳{{ $p->sell_price }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">পরিমাণ (বস্তা / প্যাক) *</label>
                        <input type="number" id="sale_quantity" name="quantity" value="1" min="1" required class="w-full text-sm rounded-lg border-gray-300" oninput="calculateTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">প্রতি বস্তা বিক্রয় মূল্য (৳) *</label>
                        <input type="number" id="sale_unit_price" name="unit_price" step="0.01" required class="w-full text-sm rounded-lg border-gray-300" oninput="calculateTotal()">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ছাড় / ডিসকাউন্ট (৳)</label>
                        <input type="number" id="sale_discount" name="discount" value="0" class="w-full text-sm rounded-lg border-gray-300" oninput="calculateTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">পরিশোধকৃত টাকা (৳) *</label>
                        <input type="number" id="sale_paid" name="paid_amount" step="0.01" required class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">পেমেন্ট মেথড</label>
                        <select name="payment_method" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="Cash">নগদ (Cash)</option>
                            <option value="bKash">বিকাশ (bKash)</option>
                            <option value="Nagad">নগদ (Nagad)</option>
                            <option value="Bank">ব্যাংক ট্রান্সফার</option>
                            <option value="Due">সম্পূর্ণ বাকি (Due)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">নোট / মন্তব্য</label>
                        <input type="text" name="notes" placeholder="যেকোনো মন্তব্য..." class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newSaleModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">চালান সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateProductPrice(select) {
            const option = select.options[select.selectedIndex];
            const price = option.getAttribute('data-price') || 0;
            document.getElementById('sale_unit_price').value = price;
            calculateTotal();
        }
        function calculateTotal() {
            const qty = parseFloat(document.getElementById('sale_quantity').value) || 0;
            const price = parseFloat(document.getElementById('sale_unit_price').value) || 0;
            const disc = parseFloat(document.getElementById('sale_discount').value) || 0;
            const total = Math.max(0, (qty * price) - disc);
            document.getElementById('sale_paid').value = total;
        }
    </script>
</x-app-layout>
