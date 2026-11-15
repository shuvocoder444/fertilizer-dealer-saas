<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('কৃষক ও পাইকারি ক্রেতা তালিকা (Customers / Farmers)') }}
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">মোট কৃষক ও খুচরা বিক্রেতা বাকি: ৳ {{ number_format($totalDue) }}</p>
            </div>
            <button onclick="document.getElementById('newCustomerModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন কাস্টমার / কৃষক নিবন্ধন
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

            <!-- Search -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <form method="GET" action="{{ route('dealer.customers.index') }}" class="flex gap-3 items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, মোবাইল বা গ্রাম দিয়ে খুঁজুন..." class="text-sm rounded-lg border-gray-300 w-72 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg">খুঁজুন</button>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">কৃষক / ক্রেতার নাম</th>
                                <th class="px-5 py-3.5">মোবাইল নং</th>
                                <th class="px-5 py-3.5">ধরণ</th>
                                <th class="px-5 py-3.5">গ্রাম / ঠিকানা</th>
                                <th class="px-5 py-3.5">মোট ক্রয় (৳)</th>
                                <th class="px-5 py-3.5">বর্তমান বাকি (৳)</th>
                                <th class="px-5 py-3.5">ক্রেডিট লিমিট</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন / প্রোফাইল</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($customers as $c)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('dealer.customers.show', $c->id) }}" class="hover:text-emerald-600 transition">
                                            {{ $c->name }}
                                        </a>
                                        <br><span class="text-xs text-gray-400 font-normal">NID: {{ $c->nid ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-indigo-600 whitespace-nowrap">{{ $c->phone }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $c->customer_type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs whitespace-nowrap text-gray-700">{{ $c->village ?? $c->address ?? 'N/A' }}</td>
                                    <td class="px-5 py-4 font-semibold text-gray-900 whitespace-nowrap">৳ {{ number_format($c->total_purchased) }}</td>
                                    <td class="px-5 py-4 font-black whitespace-nowrap {{ $c->current_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                        ৳ {{ number_format($c->current_due) }}
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500 whitespace-nowrap">৳ {{ number_format($c->credit_limit) }}</td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('dealer.customers.show', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg border border-emerald-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span>প্রোফাইল ও খতিয়ান</span>
                                            </a>
                                            <form method="POST" action="{{ route('dealer.customers.destroy', $c->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই কৃষক/কাস্টমারকে মুছে ফেলতে চান?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="মুছে ফেলুন">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-gray-400">কোনো কৃষক বা ক্রেতা নিবন্ধিত নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- New Customer Modal -->
    <div id="newCustomerModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন কৃষক / কাস্টমার নিবন্ধন</h3>
                <button onclick="document.getElementById('newCustomerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.customers.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">নাম *</label>
                    <input type="text" name="name" required placeholder="মোঃ রফিকুল ইসলাম" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">মোবাইল নম্বর *</label>
                        <input type="text" name="phone" required placeholder="017xxxxxxxx" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">এনআইডি নম্বর</label>
                        <input type="text" name="nid" placeholder="জাতীয় পরিচয়পত্র নং" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">কাস্টমার ধরণ *</label>
                        <select name="customer_type" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="Farmer">কৃষক (Farmer)</option>
                            <option value="Sub-Dealer">সাব-ডিলার (Sub-Dealer)</option>
                            <option value="Retailer">খুচরা বিক্রেতা (Retailer)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ক্রেডিট লিমিট (৳)</label>
                        <input type="number" name="credit_limit" value="50000" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">গ্রাম / এলাকা</label>
                    <input type="text" name="village" placeholder="মির্জাপুর, শেরপুর" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newCustomerModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
