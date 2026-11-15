<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('ডিলার ম্যানেজারসমূহ (Dealer Managers)') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">ডিলারশিপ পরিচালনা ও হিসাব তদারকির জন্য ম্যানেজার অ্যাক্সেস তালিকা</p>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()?->currentTeam)
                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg border border-gray-300 shadow-sm transition">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>টিম ইনভাইটেশন সেটিংস</span>
                    </a>
                @endif
                <a href="{{ route('dealer.staff.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ নতুন ম্যানেজার / কর্মী প্রোফাইল যোগ করুন</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Information Card -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 text-sm text-emerald-900 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="space-y-1">
                    <div class="font-bold">কীভাবে ম্যানেজারকে অ্যাক্সেস দিবেন?</div>
                    <div class="text-xs text-emerald-800 leading-relaxed">
                        আপনি দুটি উপায়ে ম্যানেজার যুক্ত করতে পারেন:
                        <br>১. <strong>কর্মী প্রোফাইল তৈরি করে:</strong> কর্মী তালিকা থেকে ম্যানেজারের প্রোফাইল খুলুন এবং <em>"সফটওয়্যার লগইন অ্যাক্সেস দিন"</em> অপশন অন করে ইমেইল ও পাসওয়ার্ড দিন।
                        <br>২. <strong>টিম ইনভাইটেশনের মাধ্যমে:</strong> <em>"টিম ইনভাইটেশন সেটিংস"</em> বাটনে ক্লিক করে ম্যানেজারের ইমেইলে ইনভাইট পাঠাতে পারেন।
                    </div>
                </div>
            </div>

            <!-- Manager Profiles from Staff System -->
            @if(isset($managerStaff) && $managerStaff->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-bold text-gray-800 text-lg">নিবন্ধিত ম্যানেজার প্রোফাইলসমূহ (Staff Profiles)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($managerStaff as $ms)
                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-900">{{ $ms->name }}</div>
                                    <div class="text-xs text-gray-500">📞 {{ $ms->phone }} | 🏢 {{ $ms->outlet?->name ?? 'প্রধান গোডাউন' }}</div>
                                    <div class="text-xs text-emerald-700 font-semibold mt-1">
                                        মাসিক বেতন: ৳{{ number_format($ms->monthly_salary) }}
                                        @if($ms->has_login_access)
                                            <span class="ms-2 px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-800">লগইন অ্যাক্সেস সক্রিয়</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('dealer.staff.show', $ms->id) }}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition">
                                    প্রোফাইল ও বেতন খতিয়ান
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Team Members & Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">ডিলারশিপের দায়িত্বপ্রাপ্ত সফটওয়্যার ইউজারগণ</h3>
                <div class="divide-y divide-gray-100">
                    @forelse($members as $m)
                        <div class="py-4 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-gray-900">{{ $m->name }}</div>
                                <div class="text-xs text-gray-400">{{ $m->email }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $m->roles->pluck('name')->implode(', ') ?: 'Manager / Admin' }}
                                </span>
                                @if($m->id === Auth::id())
                                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-gray-100 text-gray-600">আপনি (মালিক)</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">কোনো ম্যানেজার নেই।</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
