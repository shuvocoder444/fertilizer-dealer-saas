<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>{{ __('আউটলেট ও গোডাউন কর্মী তালিকা (Staff & Payroll)') }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">কর্মচারী ও ম্যানেজারদের প্রোফাইল, দায়িত্ব, মাসিক বেতন খতিয়ান ও সফটওয়্যার অ্যাক্সেস</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="document.getElementById('newStaffModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ নতুন কর্মী / ম্যানেজার যুক্ত করুন</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                </div>
            @endif

            <!-- 4 Summary KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মোট কর্মী সংখ্যা</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">{{ number_format($totalStaff) }} জন</div>
                        <div class="text-xs text-gray-400 mt-1">সব আউটলেট মিলিয়ে</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                        👥
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">সক্রিয় কর্মী</div>
                        <div class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($activeStaff) }} জন</div>
                        <div class="text-xs text-emerald-600 mt-1">কর্মরত আছেন</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                        ✅
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মাসিক মূল পে-রোল</div>
                        <div class="text-2xl font-black text-indigo-700 mt-1">৳ {{ number_format($totalMonthlyPayroll) }}</div>
                        <div class="text-xs text-gray-400 mt-1">প্রতি মাসে নির্ধারিত বেতন</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl">
                        💼
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">চলতি মাসে পরিশোধিত</div>
                        <div class="text-2xl font-black text-amber-600 mt-1">৳ {{ number_format($paidThisMonth) }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }} এ প্রদান</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xl">
                        💵
                    </div>
                </div>
            </div>

            <!-- Staff List Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">সকল কর্মী ও ম্যানেজারের তালিকা</h3>
                        <p class="text-xs text-gray-400 mt-0.5">প্রোফাইল দেখতে ও প্রতি মাসের বেতন এন্ট্রি করতে 'প্রোফাইল ও বেতন খতিয়ান' বাটনে ক্লিক করুন</p>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('dealer.staff.index') }}" class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, মোবাইল বা পদবী খুঁজুন..." class="text-xs rounded-lg border-gray-300 pl-8 pr-3 py-2 w-56 focus:ring-emerald-500 focus:border-emerald-500">
                            <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <select name="role_type" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">সকল ভূমিকা</option>
                            <option value="manager" {{ request('role_type') == 'manager' ? 'selected' : '' }}>ম্যানেজার (Manager)</option>
                            <option value="cashier" {{ request('role_type') == 'cashier' ? 'selected' : '' }}>ক্যাশিয়ার (Cashier)</option>
                            <option value="salesman" {{ request('role_type') == 'salesman' ? 'selected' : '' }}>বিক্রয় প্রতিনিধি (Salesman)</option>
                            <option value="incharge" {{ request('role_type') == 'incharge' ? 'selected' : '' }}>গোডাউন ইনচার্জ (In-charge)</option>
                            <option value="delivery" {{ request('role_type') == 'delivery' ? 'selected' : '' }}>ডেলিভারিম্যান / ড্রাইভার</option>
                            <option value="staff" {{ request('role_type') == 'staff' ? 'selected' : '' }}>অন্যান্য কর্মী (General Staff)</option>
                        </select>
                        @if(request('search') || request('role_type'))
                            <a href="{{ route('dealer.staff.index') }}" class="text-xs text-red-500 hover:underline">রিসেট</a>
                        @endif
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5">কর্মী / ম্যানেজার</th>
                                <th class="px-5 py-3.5">পদবী ও শাখা</th>
                                <th class="px-5 py-3.5">ভূমিকা (Role)</th>
                                <th class="px-5 py-3.5">মাসিক বেতন</th>
                                <th class="px-5 py-3.5">সিস্টেম অ্যাক্সেস</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($staffMembers as $s)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 font-black text-sm flex items-center justify-center shrink-0">
                                                {{ mb_substr($s->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('dealer.staff.show', $s->id) }}" class="font-bold text-gray-900 hover:text-emerald-600 transition block">
                                                    {{ $s->name }}
                                                </a>
                                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                                    <span>📞 {{ $s->phone }}</span>
                                                    @if($s->nid)
                                                        <span class="text-gray-300">|</span>
                                                        <span class="text-[11px] text-gray-400">NID: {{ $s->nid }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-800">{{ $s->designation }}</div>
                                        <div class="text-xs text-gray-400">
                                            🏢 {{ $s->outlet?->name ?? 'প্রধান গোডাউন / ডিপো' }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($s->role_type === 'manager')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                                ম্যানেজার
                                            </span>
                                        @elseif($s->role_type === 'cashier')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                ক্যাশিয়ার
                                            </span>
                                        @elseif($s->role_type === 'salesman')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                বিক্রয় কর্মী
                                            </span>
                                        @elseif($s->role_type === 'incharge')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                গোডাউন ইনচার্জ
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                                {{ ucfirst($s->role_type) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        ৳ {{ number_format($s->monthly_salary) }}
                                        <span class="text-[11px] font-normal text-gray-400 block">প্রতি মাসে</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($s->has_login_access)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                লগইন অ্যাক্সেস আছে
                                            </span>
                                            <span class="block text-[10px] text-gray-400 mt-0.5">{{ $s->email }}</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-normal bg-gray-100 text-gray-500">
                                                অফলাইন কর্মী
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($s->status === 'active')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('dealer.staff.show', $s->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-lg transition border border-emerald-200">
                                            <span>প্রোফাইল ও বেতন খতিয়ান</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('dealer.staff.destroy', $s->id) }}" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই কর্মীর রেকর্ড ও বেতন খতিয়ান মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition" title="মুছে ফেলুন">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                        <div class="max-w-sm mx-auto space-y-3">
                                            <div class="text-4xl">👨‍💼</div>
                                            <div class="font-bold text-gray-600">কোনো কর্মী তালিকাভুক্ত করা হয়নি</div>
                                            <p class="text-xs text-gray-400">আপনার গোডাউনের ইনচার্জ, বিক্রয় প্রতিনিধি, ক্যাশিয়ার বা ম্যানেজারদের যুক্ত করে তাদের বেতন ও কার্যক্রম ট্র্যাক করুন।</p>
                                            <button onclick="document.getElementById('newStaffModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm">
                                                + প্রথম কর্মী যুক্ত করুন
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <!-- New Staff Registration Modal -->
    <div id="newStaffModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 my-8 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="font-black text-xl text-gray-900">নতুন কর্মী / ম্যানেজার নিবন্ধন</h3>
                    <p class="text-xs text-gray-400 mt-0.5">আউটলেট ও গোডাউনের কর্মচারীর সম্পূর্ণ প্রোফাইল ও বেতন নির্ধারণ</p>
                </div>
                <button onclick="document.getElementById('newStaffModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 text-xl font-bold flex items-center justify-center transition">&times;</button>
            </div>

            <form method="POST" action="{{ route('dealer.staff.store') }}" class="space-y-4" x-data="{ giveAccess: false }">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">কর্মীর নাম *</label>
                        <input type="text" name="name" required placeholder="উদাঃ মো: শফিকুল ইসলাম" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">মোবাইল নম্বর *</label>
                        <input type="text" name="phone" required placeholder="০১৭১২-৩৪৫৬৭৮" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">পদবী / Designation *</label>
                        <input type="text" name="designation" required placeholder="উদাঃ প্রধান গোডাউন ম্যানেজার / বিক্রয় কর্মী" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">ভূমিকা / Role Type *</label>
                        <select name="role_type" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="manager">ম্যানেজার (Manager)</option>
                            <option value="cashier">ক্যাশিয়ার (Cashier)</option>
                            <option value="salesman" selected>বিক্রয় কর্মী / সেলসম্যান (Salesman)</option>
                            <option value="incharge">গোডাউন ইনচার্জ (In-charge)</option>
                            <option value="delivery">ডেলিভারিম্যান / ড্রাইভার</option>
                            <option value="staff">সাধারণ কর্মী (Staff)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">নির্ধারিত আউটলেট / গোডাউন</label>
                        <select name="outlet_id" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">প্রধান ডিপো / কেন্দ্রীয় গোডাউন</option>
                            @foreach($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">মাসিক মূল বেতন (৳) *</label>
                        <input type="number" name="monthly_salary" value="12000" min="0" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">জাতীয় পরিচয়পত্র (NID) নম্বর</label>
                        <input type="text" name="nid" placeholder="উদাঃ 1990123456789" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">যোগদানের তারিখ</label>
                        <input type="date" name="joining_date" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">বর্তমান ঠিকানা</label>
                        <textarea name="present_address" rows="2" placeholder="গ্রাম/রোড, উপজেলা, জেলা" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">স্থায়ী ঠিকানা</label>
                        <textarea name="permanent_address" rows="2" placeholder="স্থায়ী ঠিকানার বিবরণ" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">জরুরি যোগাযোগের নম্বর / অভিভাবকের ফোন</label>
                    <input type="text" name="emergency_contact" placeholder="০১৭১০-০০০০০০" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Software Login Access Section -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="has_login_access" name="has_login_access" value="1" x-model="giveAccess" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        <label for="has_login_access" class="text-xs font-bold text-gray-800 cursor-pointer">
                            এই কর্মীকে সফটওয়্যার লগইন অ্যাক্সেস দিন (ম্যানেজার / বিক্রয় প্রতিনিধি হিসেবে)
                        </label>
                    </div>

                    <div x-show="giveAccess" class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-200" style="display: none;">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 mb-1">লগইন ইমেইল এড্রেস *</label>
                            <input type="email" name="email" placeholder="staff@example.com" class="w-full text-xs rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 mb-1">লগইন পাসওয়ার্ড (ডিফল্ট: password123)</label>
                            <input type="password" name="login_password" placeholder="কমপক্ষে ৬ অক্ষর" class="w-full text-xs rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('newStaffModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                        বাতিল
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black shadow-md transition">
                        সংরক্ষণ ও প্রোফাইল তৈরি করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
