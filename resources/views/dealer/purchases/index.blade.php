<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('সার ক্রয় ও গুদাম স্টক ইন (Purchases & Stock In)') }}
            </h2>
            <button onclick="document.getElementById('newPurchaseModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন ক্রয় চালান / স্টক ইন
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">সরকারি (বিসিআইসি/বিএডিসি) ও বেসরকারি সার ক্রয় মেমো</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">মেমো / চালান নং</th>
                                <th class="px-5 py-3.5">তারিখ</th>
                                <th class="px-5 py-3.5">সরবরাহকারী / কোম্পানি</th>
                                <th class="px-5 py-3.5">মোট মূল্য</th>
                                <th class="px-5 py-3.5">পরিশোধ</th>
                                <th class="px-5 py-3.5">বাকি</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($purchases as $p)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $p->memo_no }}</td>
                                    <td class="px-5 py-4 text-xs">{{ $p->purchase_date ? $p->purchase_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="px-5 py-4 font-medium text-gray-800">{{ $p->supplier_name }}</td>
                                    <td class="px-5 py-4 font-bold text-gray-900">৳ {{ number_format($p->total_amount) }}</td>
                                    <td class="px-5 py-4 text-emerald-600 font-semibold">৳ {{ number_format($p->paid_amount) }}</td>
                                    <td class="px-5 py-4 text-red-600 font-semibold">৳ {{ number_format($p->due_amount) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-gray-400">কোনো ক্রয় চালান নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- New Purchase Modal -->
    <div id="newPurchaseModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন সার ক্রয় ও স্টক ইন ফর্ম</h3>
                <button onclick="document.getElementById('newPurchaseModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.purchases.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">সরবরাহকারী / কোম্পানি *</label>
                        <input type="text" name="supplier_name" required placeholder="BCIC / BADC বাফার গোডাউন" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">মেমো / ডিও নং</label>
                        <input type="text" name="memo_no" placeholder="DO-2026-99" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">ক্রয় তারিখ *</label>
                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">সারের নাম নির্বাচন করুন *</label>
                    <select name="product_id" required class="w-full text-sm rounded-lg border-gray-300">
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->bangla_name ?? $prod->name }} (বর্তমান স্টক: {{ $prod->stock_quantity }} {{ $prod->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">পরিমাণ (বস্তা / প্যাক) *</label>
                        <input type="number" name="quantity" required placeholder="50" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">প্রতি বস্তা ক্রয় দর (৳) *</label>
                        <input type="number" step="0.01" name="unit_price" required placeholder="1250" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">পরিশোধকৃত টাকা (৳) *</label>
                    <input type="number" step="0.01" name="paid_amount" required placeholder="50000" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newPurchaseModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold">স্টক ইন করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
