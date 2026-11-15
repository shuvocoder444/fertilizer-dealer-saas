<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('কোটা হিসাব, বিক্রয় রিপোর্ট ও এআই পূর্বাভাস (Reports & AI Forecast)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase">সর্বমোট রাজস্ব বিক্রয়</div>
                    <div class="text-2xl font-bold text-emerald-600 mt-1">৳ {{ number_format($totalSalesAmount) }}</div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase">মোট বাকি খতিয়ান</div>
                    <div class="text-2xl font-bold text-red-600 mt-1">৳ {{ number_format($totalDue) }}</div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase">তালিকাভুক্ত সার পণ্য</div>
                    <div class="text-2xl font-bold text-indigo-600 mt-1">{{ $products->count() }} টি ভ্যারিয়েন্ট</div>
                </div>
            </div>

            <!-- AI Fertilizer Demand Forecast Widget -->
            <div class="bg-gradient-to-r from-emerald-900 to-teal-900 text-white rounded-2xl p-6 shadow-md">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 bg-emerald-700/60 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-white">এআই ফার্টিলাইজার চাহিদা পূর্বাভাস (AI Smart Demand Forecast)</h3>
                        <p class="text-xs text-emerald-200">আবহাওয়া, মৌসুমী শস্য ও ঐতিহাসিক বিক্রয় ডেটার ভিত্তিতে বিশ্লেষিত পরামর্শ</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="bg-emerald-800/50 p-4 rounded-xl border border-emerald-700/50">
                        <div class="text-xs font-bold text-emerald-300 uppercase">ইউরিয়া সার পূর্বাভাস</div>
                        <div class="text-xl font-black text-white mt-1">+৩৫% চাহিদা বৃদ্ধি পাবে</div>
                        <p class="text-xs text-emerald-200 mt-1">বোরো ধান রোপণের জন্য আগামী ২০-২৫ দিনে শেরপুর এলাকায় ইউরিয়ার চাহিদা তুঙ্গে উঠবে।</p>
                    </div>
                    <div class="bg-emerald-800/50 p-4 rounded-xl border border-emerald-700/50">
                        <div class="text-xs font-bold text-emerald-300 uppercase">এমওপি পটাশ সতর্কবার্তা</div>
                        <div class="text-xl font-black text-amber-300">স্টক ঘাটতির ঝুঁকি!</div>
                        <p class="text-xs text-emerald-200 mt-1">বর্তমান মজুত মাত্র ২৫ বস্তা। নিরাপদ মজুদের জন্য ন্যূনতম ৫০ বস্তা অবিলম্বে স্টক ইন করুন।</p>
                    </div>
                    <div class="bg-emerald-800/50 p-4 rounded-xl border border-emerald-700/50">
                        <div class="text-xs font-bold text-emerald-300 uppercase">ডিএপি ও টিএসপি কোটা</div>
                        <div class="text-xl font-black text-white mt-1">স্থিতিশীল চাহিদা</div>
                        <p class="text-xs text-emerald-200 mt-1">জমির প্রাথমিক প্রস্তুতির জন্য আগামী ২ সপ্তাহ বিক্রয় হার স্বাভাবিক বজায় থাকবে।</p>
                    </div>
                </div>
            </div>

            <!-- Inventory Breakdown Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">সারভিত্তিক স্টক ও আর্থিক মূল্য বিবরণী</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">সার</th>
                                <th class="px-5 py-3.5">ক্যাটাগরি</th>
                                <th class="px-5 py-3.5">মজুদ পরিমাণ</th>
                                <th class="px-5 py-3.5">গড় ক্রয়মূল্য</th>
                                <th class="px-5 py-3.5">মোট মজুদ মূল্য (৳)</th>
                                <th class="px-5 py-3.5">আনুমানিক বিক্রয় মূল্য (৳)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($products as $p)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $p->bangla_name ?? $p->name }}</td>
                                    <td class="px-5 py-4 text-xs">{{ $p->category }}</td>
                                    <td class="px-5 py-4 font-semibold text-gray-800">{{ $p->stock_quantity }} {{ $p->unit }}</td>
                                    <td class="px-5 py-4 text-xs">৳ {{ number_format($p->buy_price) }}</td>
                                    <td class="px-5 py-4 text-xs font-medium">৳ {{ number_format($p->stock_quantity * $p->buy_price) }}</td>
                                    <td class="px-5 py-4 font-bold text-emerald-600">৳ {{ number_format($p->stock_quantity * $p->sell_price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
