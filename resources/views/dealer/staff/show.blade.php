<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('dealer.staff.index') }}" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="কর্মী তালিকায় ফিরে যান">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                        <span>{{ $staff->name }}</span>
                        @if($staff->role_type === 'manager')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">ম্যানেজার</span>
                        @elseif($staff->role_type === 'cashier')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">ক্যাশিয়ার</span>
                        @elseif($staff->role_type === 'salesman')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">বিক্রয় কর্মী</span>
                        @elseif($staff->role_type === 'incharge')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">গোডাউন ইনচার্জ</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">{{ ucfirst($staff->role_type) }}</span>
                        @endif
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $staff->designation }} | 🏢 {{ $staff->outlet?->name ?? 'প্রধান গোডাউন / ডিপো' }}</p>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex items-center gap-2 print:hidden">
                <button onclick="document.getElementById('newSalaryModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ বেতন / অগ্রিম প্রদান এন্ট্রি</span>
                </button>

                <button onclick="window.print()" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 shadow-sm transition">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>প্রিন্ট খতিয়ান</span>
                </button>

                <form method="POST" action="{{ route('dealer.staff.destroy', $staff->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই কর্মীর সম্পূর্ণ রেকর্ড মুছে ফেলতে চান?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="কর্মী মুছুন">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between print:hidden">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                </div>
            @endif

            <!-- 4 Financial Summary KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মাসিক মূল বেতন</div>
                    <div class="text-2xl font-black text-gray-900 mt-1">৳ {{ number_format($staff->monthly_salary) }}</div>
                    <div class="text-xs text-gray-400 mt-1">নির্ধারিত মাসিক চুক্তি</div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">চলতি মাসে প্রদান</div>
                    <div class="text-2xl font-black text-emerald-600 mt-1">৳ {{ number_format($totalThisMonth) }}</div>
                    <div class="text-xs text-emerald-600 mt-1">{{ now()->format('F Y') }} এর পরিশোধ</div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">চলতি বছর পরিশোধিত</div>
                    <div class="text-2xl font-black text-indigo-700 mt-1">৳ {{ number_format($totalThisYear) }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ now()->year }} সালের মোট বেতন ও ভাতা</div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">মোট অগ্রিম গ্রহণ</div>
                    <div class="text-2xl font-black text-amber-600 mt-1">৳ {{ number_format($advancePaid) }}</div>
                    <div class="text-xs text-amber-600 mt-1">সর্বমোট অগ্রিম বাবদ দেওয়া</div>
                </div>
            </div>

            <!-- Profile Overview & Personal Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>কর্মীর ব্যক্তিগত ও চাকরির প্রোফাইল</span>
                    </h3>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $staff->status === 'active' ? 'সক্রিয় কর্মী (Active)' : 'নিষ্ক্রিয় (Inactive)' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <!-- Col 1: Basic & Contact -->
                    <div class="space-y-3">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">যোগাযোগের তথ্য</div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs text-gray-400 block">মোবাইল নম্বর:</span>
                                <a href="tel:{{ $staff->phone }}" class="font-bold text-emerald-600 hover:underline">{{ $staff->phone }}</a>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">ইমেইল:</span>
                                <span class="font-medium text-gray-800">{{ $staff->email ?: 'দেওয়া হয়নি' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">জরুরি যোগাযোগ / অভিভাবকের ফোন:</span>
                                <span class="font-medium text-gray-800">{{ $staff->emergency_contact ?: 'দেওয়া হয়নি' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Col 2: Identity & Job Info -->
                    <div class="space-y-3">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">চাকরি ও জাতীয় পরিচয়</div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs text-gray-400 block">জাতীয় পরিচয়পত্র (NID) নম্বর:</span>
                                <span class="font-bold text-gray-900 font-mono">{{ $staff->nid ?: 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">যোগদানের তারিখ:</span>
                                <span class="font-medium text-gray-800">{{ $staff->joining_date ? $staff->joining_date->format('d M, Y') : 'দেওয়া হয়নি' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">নির্ধারিত আউটলেট / শাখা:</span>
                                <span class="font-bold text-gray-800">🏢 {{ $staff->outlet?->name ?? 'প্রধান গোডাউন / ডিপো' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Col 3: Software Access & Address -->
                    <div class="space-y-3">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">সফটওয়্যার অ্যাক্সেস ও ঠিকানা</div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs text-gray-400 block">সফটওয়্যার লগইন অ্যাক্সেস:</span>
                                @if($staff->has_login_access)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        হ্যাঁ, লগইন করার অনুমতি আছে ({{ $staff->email }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs text-gray-500 bg-gray-100">
                                        অফলাইন কর্মী (লগইন প্রয়োজন নেই)
                                    </span>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">বর্তমান ঠিকানা:</span>
                                <span class="text-xs text-gray-700 leading-relaxed block">{{ $staff->present_address ?: 'দেওয়া হয়নি' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">স্থায়ী ঠিকানা:</span>
                                <span class="text-xs text-gray-700 leading-relaxed block">{{ $staff->permanent_address ?: 'দেওয়া হয়নি' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month-by-month Salary Ledger Table (কোন মাসে কত দিলাম সব কিছু) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-black text-gray-900 text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>মাসিক বেতন ও পরিশোধ খতিয়ান (Salary & Payment History)</span>
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">কোন মাসে কত টাকা বেতন, অগ্রিম বা বোনাস পরিশোধ করা হয়েছে তার সম্পূর্ণ হিসাব</p>
                    </div>

                    <div class="text-sm font-bold text-gray-800 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                        সর্বমোট পরিশোধ: <span class="text-emerald-700 font-black">৳ {{ number_format($totalPaid) }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5">তারিখ</th>
                                <th class="px-5 py-3.5">বেতন মাস / বছর</th>
                                <th class="px-5 py-3.5">পরিশোধের ধরন</th>
                                <th class="px-5 py-3.5">মাধ্যম</th>
                                <th class="px-5 py-3.5">পরিমাণ</th>
                                <th class="px-5 py-3.5">ভাউচার নোট / মন্তব্য</th>
                                <th class="px-5 py-3.5">এন্ট্রি করেছেন</th>
                                <th class="px-5 py-3.5 text-right print:hidden">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($salaries as $sal)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-5 py-3.5 whitespace-nowrap font-medium text-gray-900">
                                        {{ $sal->payment_date ? $sal->payment_date->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap font-bold text-indigo-700">
                                        📅 {{ $sal->month_year }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @if($sal->payment_type === 'salary')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                মূল বেতন
                                            </span>
                                        @elseif($sal->payment_type === 'advance')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                অগ্রিম (Advance)
                                            </span>
                                        @elseif($sal->payment_type === 'bonus')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                                উৎসব বোনাস
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                ভাতা / অন্যান্য
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700 uppercase">
                                            {{ $sal->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap font-black text-emerald-700 text-base">
                                        ৳ {{ number_format($sal->amount) }}
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-gray-500 max-w-xs">
                                        {{ $sal->note ?: 'নিয়মিত বেতন পরিশোধ' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-gray-400 whitespace-nowrap">
                                        {{ $sal->recorder?->name ?? 'অ্যাডমিন' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-right whitespace-nowrap print:hidden">
                                        <form method="POST" action="{{ route('dealer.staff.salary.destroy', $sal->id) }}" onsubmit="return confirm('আপনি কি এই বেতনের এন্ট্রিটি মুছে ফেলতে চান?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition" title="এন্ট্রি মুছুন">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-gray-400">
                                        এখনও কোনো বেতন বা অগ্রিম লেনদেন এন্ট্রি করা হয়নি। উপরের '+ বেতন / অগ্রিম প্রদান এন্ট্রি' বাটনে চাপ দিয়ে বেতন এন্ট্রি করুন।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <!-- Salary Payment Entry Modal -->
    <div id="newSalaryModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="font-black text-xl text-gray-900">বেতন / অগ্রিম পরিশোধ এন্ট্রি</h3>
                    <p class="text-xs text-gray-400 mt-0.5">কর্মী: <span class="font-bold text-gray-800">{{ $staff->name }}</span> (মাসিক বেতন: ৳{{ number_format($staff->monthly_salary) }})</p>
                </div>
                <button onclick="document.getElementById('newSalaryModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 text-xl font-bold flex items-center justify-center transition">&times;</button>
            </div>

            <form method="POST" action="{{ route('dealer.staff.salary.store', $staff->id) }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">বেতন মাস ও বছর *</label>
                        <select name="month_year" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                            @php
                                $months = [
                                    'নভেম্বর ২০২৬', 'অক্টোবর ২০২৬', 'সেপ্টেম্বর ২০২৬', 'আগস্ট ২০২৬', 
                                    'জুলাই ২০২৬', 'জুন ২০২৬', 'মে ২০২৬', 'এপ্রিল ২০২৬', 
                                    'মার্চ ২০২৬', 'ফেব্রুয়ারি ২০২৬', 'জানুয়ারি ২০২৬', 'ডিসেম্বর ২০২৬'
                                ];
                            @endphp
                            @foreach($months as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">পরিশোধের তারিখ *</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">টাকার পরিমাণ (৳) *</label>
                        <input type="number" name="amount" value="{{ $staff->monthly_salary ?: 10000 }}" min="1" step="0.01" required class="w-full text-sm rounded-lg border-gray-300 font-bold focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">পরিশোধের ধরন *</label>
                        <select name="payment_type" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="salary">মাসিক মূল বেতন</option>
                            <option value="advance">অগ্রিম (Advance)</option>
                            <option value="bonus">উৎসব বোনাস (Bonus)</option>
                            <option value="allowance">যাতায়াত / টিএ-ডিএ ভাতা</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">পরিশোধের মাধ্যম *</label>
                    <select name="payment_method" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="cash">নগদ ক্যাশ (Cash)</option>
                        <option value="bkash">বিকাশ (bKash)</option>
                        <option value="nagad">নগদ (Nagad)</option>
                        <option value="bank">ব্যাংক একাউন্ট ট্রান্সফার</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">ভাউচার নোট / মন্তব্য</label>
                    <textarea name="note" rows="2" placeholder="উদাঃ নভেম্বর মাসের নিয়মিত বেতন পরিশোধ" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('newSalaryModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                        বাতিল
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black shadow-md transition">
                        পরিশোধ নিশ্চিত করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
