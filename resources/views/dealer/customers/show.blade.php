<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('dealer.customers.index') }}" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="গ্রাহক তালিকায় ফিরে যান">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                            {{ $customer->name }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $customer->customer_type === 'Farmer' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $customer->customer_type === 'Farmer' ? 'কৃষক' : $customer->customer_type }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        মোবাইল: <span class="font-semibold text-gray-800">{{ $customer->phone }}</span> | গ্রাম: <span class="font-semibold text-gray-800">{{ $customer->village ?? $customer->address ?? 'N/A' }}</span> | NID: <span class="text-gray-600">{{ $customer->nid ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>খতিয়ান প্রিন্ট করুন</span>
                </button>

                @if($customer->current_due > 0)
                    <button onclick="document.getElementById('collectDueModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm flex items-center gap-1.5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>বাকি টাকা জমা নিন</span>
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Customer Financial Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">সর্বমোট ক্রয়</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">৳ {{ number_format($customer->total_purchased) }}</div>
                        <div class="text-[11px] text-gray-400 mt-1">মোট {{ $sales->total() }} টি চালানে সার ক্রয়</div>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">মোট পরিশোধ / জমা</div>
                        <div class="text-2xl font-black text-emerald-600 mt-1">৳ {{ number_format($totalPaid) }}</div>
                        <div class="text-[11px] text-gray-400 mt-1">নগদ ও আদায়কৃত অর্থ</div>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">বর্তমান বাকি (বকেয়া)</div>
                        <div class="text-2xl font-black {{ $customer->current_due > 0 ? 'text-red-600' : 'text-emerald-600' }} mt-1">
                            ৳ {{ number_format($customer->current_due) }}
                        </div>
                        <div class="text-[11px] text-gray-400 mt-1">
                            {{ $customer->current_due > 0 ? 'দোকানে বকেয়া রয়েছে' : 'কোনো বাকি নেই' }}
                        </div>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">ক্রেডিট লিমিট</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">৳ {{ number_format($customer->credit_limit) }}</div>
                        <div class="text-[11px] text-gray-400 mt-1">বাকি নেওয়ার সর্বোচ্চ সীমা</div>
                    </div>
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Customer Personal Information Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200/80">
                <h3 class="font-bold text-gray-900 text-base mb-4 border-b border-gray-100 pb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>কৃষক / গ্রাহকের ব্যক্তিগত তথ্য (Personal Details)</span>
                    </span>
                    <form method="POST" action="{{ route('dealer.customers.destroy', $customer->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই কৃষক/কাস্টমারের প্রোফাইল মুছে ফেলতে চান?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 hover:underline">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>প্রোফাইল মুছুন (Delete)</span>
                        </button>
                    </form>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block">পূর্ণ নাম:</span>
                        <span class="font-bold text-gray-900 text-base">{{ $customer->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block">মোবাইল নম্বর:</span>
                        <a href="tel:{{ $customer->phone }}" class="font-bold text-emerald-600 text-base hover:underline">{{ $customer->phone }}</a>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block">জাতীয় পরিচয়পত্র (NID):</span>
                        <span class="font-semibold text-gray-800">{{ $customer->nid ?? 'সংরক্ষিত নেই' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block">গ্রাম ও পূর্ণ ঠিকানা:</span>
                        <span class="font-semibold text-gray-800">{{ $customer->village ?? $customer->address ?? 'গ্রাম নির্ধারিত নেই' }}</span>
                    </div>
                </div>
            </div>

            <!-- Ledger Table 1: All Fertilizer Sales & Invoices History -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">১. সার বিক্রয় ও চালান খতিয়ান (Invoices History)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">এই কৃষকের সকল ক্যাশ ও বাকি সার ক্রয়ের পূর্ণাঙ্গ তালিকা</p>
                    </div>
                    <span class="text-xs font-bold text-gray-600 bg-gray-200/70 px-3 py-1 rounded-full">মোট {{ $sales->total() }} টি মেমো</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5">চালান নং</th>
                                <th class="px-5 py-3.5">তারিখ</th>
                                <th class="px-5 py-3.5">ক্রয়কৃত সার ও পরিমাণ</th>
                                <th class="px-5 py-3.5">মোট মূল্য (৳)</th>
                                <th class="px-5 py-3.5">নগদ পরিশোধ (৳)</th>
                                <th class="px-5 py-3.5">বাকি টাকা (৳)</th>
                                <th class="px-5 py-3.5">পেমেন্ট মেথড</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sales as $sale)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $sale->invoice_no }}</td>
                                    <td class="px-5 py-4 text-xs whitespace-nowrap">{{ $sale->sale_date ? $sale->sale_date->format('d M, Y') : $sale->created_at->format('d M, Y') }}</td>
                                    <td class="px-5 py-4 text-xs">
                                        @if($sale->items && $sale->items->count() > 0)
                                            <ul class="space-y-1">
                                                @foreach($sale->items as $item)
                                                    <li class="font-medium text-gray-800">
                                                        • {{ $item->product->bangla_name ?? $item->product->name ?? 'সার' }} ({{ $item->quantity }} {{ $item->product->unit ?? 'বস্তা' }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400">সারের চালান</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">৳ {{ number_format($sale->total_amount) }}</td>
                                    <td class="px-5 py-4 font-semibold text-emerald-600 whitespace-nowrap">৳ {{ number_format($sale->paid_amount) }}</td>
                                    <td class="px-5 py-4 font-black text-red-600 whitespace-nowrap">
                                        @if($sale->due_amount > 0)
                                            ৳ {{ number_format($sale->due_amount) }}
                                        @else
                                            <span class="text-xs font-semibold text-emerald-600">পরিশোধিত</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $sale->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : ($sale->payment_status === 'Partial' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $sale->payment_status === 'Paid' ? 'পরিশোধিত' : ($sale->payment_status === 'Partial' ? 'আংশিক পরিশোধ' : 'সম্পূর্ণ বাকি') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-gray-400">এই কৃষকের কোনো বিক্রয় রেকর্ড পাওয়া যায়নি।</td>
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

            <!-- Ledger Table 2: Due Payments & Collection Receipts -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">২. বাকি টাকা পরিশোধ ও জমার রশিদ (Due Payments History)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">কৃষক কবে কত টাকা বাকি পরিশোধ করেছেন তার বিস্তারিত খতিয়ান</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">মোট {{ $collections->count() }} বার জমা</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5">রশিদ নং</th>
                                <th class="px-5 py-3.5">তারিখ</th>
                                <th class="px-5 py-3.5">আদায়কৃত টাকা (৳)</th>
                                <th class="px-5 py-3.5">পেমেন্ট মেথড</th>
                                <th class="px-5 py-3.5">নোট / মন্তব্য</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($collections as $col)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $col->receipt_no }}</td>
                                    <td class="px-5 py-4 text-xs whitespace-nowrap">{{ $col->collection_date ? \Carbon\Carbon::parse($col->collection_date)->format('d M, Y') : $col->created_at->format('d M, Y') }}</td>
                                    <td class="px-5 py-4 font-black text-emerald-600 text-base whitespace-nowrap">৳ {{ number_format($col->amount) }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $col->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500">{{ $col->notes ?? 'বাকি আদায়' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-gray-400">এই কৃষকের কোনো বাকি আদায়ের রেকর্ড নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Collect Due Modal (Direct from Customer Profile) -->
    <div id="collectDueModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">বাকি টাকা আদায় ও জমা</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $customer->name }} এর বকেয়া খাতা</p>
                </div>
                <button onclick="document.getElementById('collectDueModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('dealer.dues.collect') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <div class="p-3.5 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between">
                    <span class="text-xs text-red-700 font-semibold">বর্তমান মোট বাকি:</span>
                    <span class="text-lg font-black text-red-600">৳ {{ number_format($customer->current_due) }}</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">আদায়কৃত টাকার পরিমাণ (৳) *</label>
                    <input type="number" step="0.01" name="amount" max="{{ $customer->current_due }}" required placeholder="টাকার পরিমাণ লিখুন" class="w-full text-base font-bold rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">পরিশোধের মাধ্যম *</label>
                    <select name="payment_method" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="Cash">ক্যাশ / নগদ টাকা</option>
                        <option value="bKash">বিকাশ (bKash)</option>
                        <option value="Nagad">নগদ (Nagad)</option>
                        <option value="Rocket">রকেট (Rocket)</option>
                        <option value="Bank">ব্যাংক ট্রান্সফার</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">নোট / মন্তব্য</label>
                    <textarea name="notes" rows="2" placeholder="যেমন: বোরো ধানের সার বাবদ কিস্তি পরিশোধ" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('collectDueModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg">বাতিল</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm">টাকা জমা নিশ্চিত করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
