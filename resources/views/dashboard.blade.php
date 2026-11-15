<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    @if($role === 'super-admin')
                        {{ __('প্ল্যাটফর্ম সুপার অ্যাডমিন ড্যাশবোর্ড (Super Admin)') }}
                    @else
                        {{ $dealer->company_name ?? __('ডিলারশিপ ড্যাশবোর্ড (Dealer Portal)') }}
                    @endif
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if($role === 'super-admin')
                        বাংলাদেশ ফার্টিলাইজার ডিলার SaaS প্ল্যাটফর্ম ওভারভিউ ও ডিলার ব্যবস্থাপনা
                    @else
                        {{ $dealer->address ?? 'শেরপুর, বগুড়া' }} | লাইসেন্স নং: {{ $dealer->trade_license ?? 'TL-2026-001' }}
                    @endif
                </p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $role === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                    <span class="w-2 h-2 me-1.5 rounded-full {{ $role === 'super-admin' ? 'bg-purple-500' : 'bg-green-500' }}"></span>
                    {{ $role === 'super-admin' ? 'Platform Super Admin' : 'Verified Fertilizer Dealer' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- ========================================================================= --}}
            {{-- 1. SUPER ADMIN DASHBOARD                                                  --}}
            {{-- ========================================================================= --}}
            @if($role === 'super-admin')

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মোট নিবন্ধিত ডিলার</div>
                            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_dealers'] }} জন</div>
                            <div class="text-xs text-green-600 mt-1">সক্রিয়: {{ $stats['active_dealers'] }} | পেন্ডিং: {{ $stats['pending_dealers'] }}</div>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মাসিক আনুমানিক MRR</div>
                            <div class="text-2xl font-bold text-green-600 mt-1">৳ {{ number_format($stats['estimated_mrr']) }}</div>
                            <div class="text-xs text-gray-400 mt-1">প্যাকেজ সাবস্ক্রিপশন বাবদ</div>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">সক্রিয় প্ল্যানসমূহ</div>
                            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_plans'] }} টি</div>
                            <div class="text-xs text-blue-600 mt-1">Starter, Pro, Enterprise</div>
                        </div>
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">সাপোর্ট টিকিট ওপেন</div>
                            <div class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['open_tickets'] }} টি</div>
                            <div class="text-xs text-gray-400 mt-1">প্রয়োজনীয় সহায়তা অপেক্ষমান</div>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Quick Action Bar -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.dealers.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        নতুন ডিলার যুক্ত করুন
                    </a>
                    <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        সাবস্ক্রিপশন প্ল্যান ম্যানেজ করুন
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        নতুন নোটিশ জারি করুন
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        অডিট লগ দেখুন
                    </a>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Recent Dealers -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 text-base">সাম্প্রতিক নিবন্ধিত ডিলারগণ</h3>
                            <a href="{{ route('admin.dealers.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">সবগুলো দেখুন &rarr;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                                    <tr>
                                        <th class="px-5 py-3">কোম্পানি / প্রতিষ্ঠান</th>
                                        <th class="px-5 py-3">স্বত্বাধিকারী</th>
                                        <th class="px-5 py-3">জেলা</th>
                                        <th class="px-5 py-3">প্ল্যান</th>
                                        <th class="px-5 py-3">স্ট্যাটাস</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentDealers as $d)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-5 py-3.5 font-semibold text-gray-800">{{ $d->company_name }}</td>
                                            <td class="px-5 py-3.5">{{ $d->contact_person }}<br><span class="text-xs text-gray-400">{{ $d->phone }}</span></td>
                                            <td class="px-5 py-3.5">{{ $d->district }}</td>
                                            <td class="px-5 py-3.5"><span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $d->plan->name ?? 'Basic' }}</span></td>
                                            <td class="px-5 py-3.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $d->status === 'active' ? 'bg-green-100 text-green-800' : ($d->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($d->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-5 py-4 text-center text-gray-400">কোনো ডিলার পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right: Open Tickets & Announcements -->
                    <div class="space-y-6">
                        <!-- Support Tickets Widget -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-gray-800 text-base">সাম্প্রতিক সাপোর্ট টিকিট</h3>
                                <a href="{{ route('admin.tickets.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">ম্যানেজ করুন</a>
                            </div>
                            <div class="space-y-3">
                                @forelse($recentTickets as $ticket)
                                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-indigo-600">{{ $ticket->ticket_number }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded font-medium {{ $ticket->status === 'Open' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">{{ $ticket->status }}</span>
                                        </div>
                                        <div class="font-medium text-xs text-gray-800 mt-1">{{ $ticket->subject }}</div>
                                        <div class="text-[11px] text-gray-400 mt-1">{{ $ticket->created_at->diffForHumans() }}</div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 text-center py-2">কোনো ওপেন টিকিট নেই</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Platform Announcements -->
                        <div class="bg-gradient-to-br from-indigo-900 to-purple-900 text-white rounded-xl p-5 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs uppercase font-bold text-indigo-300">সিস্টেম নোটিশ / বিজ্ঞপ্তি</span>
                                <a href="{{ route('admin.announcements.index') }}" class="text-xs text-indigo-200 underline">সব নোটিশ</a>
                            </div>
                            @forelse($announcements as $ann)
                                <div class="mb-3 last:mb-0 pb-3 last:pb-0 border-b border-indigo-800 last:border-0">
                                    <div class="font-bold text-sm text-white">{{ $ann->title }}</div>
                                    <p class="text-xs text-indigo-200 mt-1 line-clamp-2">{{ $ann->content }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-indigo-200">কোনো নোটিশ নেই</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            {{-- ========================================================================= --}}
            {{-- 2. TENANT / FERTILIZER DEALER DASHBOARD                                   --}}
            {{-- ========================================================================= --}}
            @else

                <!-- Fertilizer Dealer KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">আজকের মোট বিক্রয়</div>
                            <div class="text-2xl font-bold text-green-600 mt-1">৳ {{ number_format($stats['today_sales']) }}</div>
                            <div class="text-xs text-gray-400 mt-1">সর্বমোট বিক্রয়: ৳ {{ number_format($stats['total_sales']) }}</div>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">গুদামে মোট সার মজুত</div>
                            <div class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats['total_stock_bags']) }} বস্তা/প্যাক</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $fertilizerStocks->count() }} টি বিভিন্ন সার ও বালাইনাশক</div>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">কৃষক / পাইকারি মোট বাকি</div>
                            <div class="text-2xl font-bold text-red-600 mt-1">৳ {{ number_format($stats['total_due']) }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $stats['total_customers'] }} জন নিবন্ধিত কাস্টমার</div>
                        </div>
                        <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">কম স্টকের সর্তকতা</div>
                            <div class="text-2xl font-bold {{ $stats['low_stock_count'] > 0 ? 'text-amber-600' : 'text-gray-800' }} mt-1">{{ $stats['low_stock_count'] }} টি আইটেম</div>
                            <div class="text-xs text-amber-600 mt-1">দ্রুত নতুন বরাদ্দ প্রয়োজন</div>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Dealership Quick Actions -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dealer.sales.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        নতুন বিক্রয় (New Sale / POS)
                    </a>
                    <a href="{{ route('dealer.purchases.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        সার ক্রয় / স্টক ইন (Stock In)
                    </a>
                    <a href="{{ route('dealer.customers.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        কাস্টমার / কৃষক তালিকা
                    </a>
                    <a href="{{ route('dealer.dues.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        বাকির খাতা ও কালেকশন
                    </a>
                    <a href="{{ route('dealer.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 shadow-sm transition">
                        সরকারি কোটা ও এআই পূর্বাভাস রিপোর্ট
                    </a>
                </div>

                <!-- Fertilizer Stock Status (Urea, DAP, TSP, MOP) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">সরকারি ও বেসরকারি সার স্টক স্থিতি (Fertilizer Inventory)</h3>
                            <p class="text-xs text-gray-400">বিসিআইসি ও বিএডিসি সার বরাদ্দ এবং বর্তমান গুদাম মজুদ</p>
                        </div>
                        <a href="{{ route('dealer.products.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800">সকল স্টক ম্যানেজ করুন &rarr;</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($fertilizerStocks->take(4) as $prod)
                            <div class="p-4 rounded-xl border {{ $prod->isLowStock() ? 'border-amber-200 bg-amber-50/40' : 'border-gray-100 bg-gray-50/50' }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-500 uppercase">{{ $prod->brand ?? 'BADC/BCIC' }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded font-medium {{ $prod->isLowStock() ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $prod->isLowStock() ? 'মজুত কম' : 'পর্যাপ্ত' }}
                                    </span>
                                </div>
                                <div class="font-bold text-base text-gray-800 mt-2">{{ $prod->bangla_name ?? $prod->name }}</div>
                                <div class="flex items-baseline justify-between mt-3">
                                    <span class="text-2xl font-black text-gray-900">{{ number_format($prod->stock_quantity) }} <span class="text-xs font-normal text-gray-500">{{ $prod->unit }}</span></span>
                                    <span class="text-xs text-gray-500">বিক্রয়: ৳ {{ number_format($prod->sell_price) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-3">
                                    <div class="h-1.5 rounded-full {{ $prod->isLowStock() ? 'bg-amber-500' : 'bg-emerald-500' }}" style="width: {{ min(100, ($prod->stock_quantity / max(1, $prod->alert_quantity * 3)) * 100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Sales & Invoices -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 text-base">সাম্প্রতিক বিক্রয় চালান (Recent Invoices)</h3>
                            <a href="{{ route('dealer.sales.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800">সব চালান &rarr;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                                    <tr>
                                        <th class="px-5 py-3">চালান নং</th>
                                        <th class="px-5 py-3">ক্রেতা / কৃষক</th>
                                        <th class="px-5 py-3">মোট টাকা</th>
                                        <th class="px-5 py-3">পরিশোধ</th>
                                        <th class="px-5 py-3">বাকি</th>
                                        <th class="px-5 py-3">স্ট্যাটাস</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentSales as $sale)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-5 py-3.5 font-bold text-gray-800">{{ $sale->invoice_no }}</td>
                                            <td class="px-5 py-3.5">{{ $sale->customer_name }}</td>
                                            <td class="px-5 py-3.5 font-semibold text-gray-900">৳ {{ number_format($sale->total_amount) }}</td>
                                            <td class="px-5 py-3.5 text-green-600 font-medium">৳ {{ number_format($sale->paid_amount) }}</td>
                                            <td class="px-5 py-3.5 text-red-600 font-medium">৳ {{ number_format($sale->due_amount) }}</td>
                                            <td class="px-5 py-3.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $sale->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : ($sale->payment_status === 'Partial' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $sale->payment_status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-5 py-4 text-center text-gray-400">কোনো সাম্প্রতিক বিক্রয় পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Low Stock Warnings & Notice -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="font-bold text-gray-800 text-base mb-3">জরুরি রিস্টক সতর্কবার্তা</h3>
                            <div class="space-y-3">
                                @forelse($lowStockProducts as $low)
                                    <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 flex items-center justify-between">
                                        <div>
                                            <div class="font-bold text-xs text-gray-800">{{ $low->bangla_name ?? $low->name }}</div>
                                            <div class="text-[11px] text-amber-700 mt-0.5">মজুত: {{ $low->stock_quantity }} {{ $low->unit }} (সীমা: {{ $low->alert_quantity }})</div>
                                        </div>
                                        <a href="{{ route('dealer.purchases.index') }}" class="text-xs bg-amber-600 hover:bg-amber-700 text-white px-2.5 py-1 rounded">ক্রয় করুন</a>
                                    </div>
                                @empty
                                    <div class="text-xs text-green-700 bg-green-50 p-3 rounded-lg border border-green-200">
                                        সব সারের মজুদ পর্যাপ্ত রয়েছে! কোনো সতর্কবার্তা নেই।
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Notice from Super Admin -->
                        @if($announcements->count() > 0)
                            <div class="bg-gradient-to-br from-emerald-800 to-teal-900 text-white rounded-xl p-5 shadow-sm">
                                <div class="text-xs uppercase font-bold text-emerald-200 mb-2">কৃষি মন্ত্রণালয় ও প্ল্যাটফর্ম নোটিশ</div>
                                <div class="font-bold text-sm text-white">{{ $announcements->first()->title }}</div>
                                <p class="text-xs text-emerald-100 mt-1 line-clamp-3">{{ $announcements->first()->content }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>
