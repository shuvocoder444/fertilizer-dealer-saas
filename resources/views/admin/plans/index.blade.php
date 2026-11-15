<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('সাবস্ক্রিপশন প্ল্যান ও প্যাকেজ মূল্য তালিকা (Subscription Plans)') }}
            </h2>
            <button onclick="document.getElementById('newPlanModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন প্ল্যান তৈরি করুন
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">{{ $plan->billing_cycle }}</span>
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">সক্রিয়</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-black text-gray-900">৳ {{ number_format($plan->price) }}</span>
                                <span class="text-xs text-gray-400 ms-1">/ {{ $plan->billing_cycle === 'monthly' ? 'মাস' : 'বছর' }}</span>
                            </div>
                            <p class="text-xs text-indigo-600 font-semibold mt-2">{{ $plan->dealers_count }} জন সক্রিয় ডিলার এই প্ল্যানে আছেন</p>

                            <div class="mt-6 border-t border-gray-100 pt-4 space-y-2.5">
                                <div class="text-xs text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-emerald-500 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    সর্বোচ্চ আউটলেট: {{ $plan->max_outlets }} টি
                                </div>
                                <div class="text-xs text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-emerald-500 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    স্টাফ একাউন্ট: {{ $plan->max_staff }} জন
                                </div>
                                @if(is_array($plan->features))
                                    @foreach($plan->features as $feat)
                                        <div class="text-xs text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 text-emerald-500 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            {{ $feat }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- New Plan Modal -->
    <div id="newPlanModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন সাবস্ক্রিপশন প্ল্যান তৈরি</h3>
                <button onclick="document.getElementById('newPlanModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.plans.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">প্ল্যানের নাম *</label>
                    <input type="text" name="name" required placeholder="উদাঃ প্রফেশনাল প্লাস" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">মূল্য (৳) *</label>
                        <input type="number" name="price" step="0.01" required placeholder="2500" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">বিলিং চক্র *</label>
                        <select name="billing_cycle" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="monthly">Monthly (মাসিক)</option>
                            <option value="yearly">Yearly (বাৎসরিক)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">সর্বোচ্চ আউটলেট</label>
                        <input type="number" name="max_outlets" value="2" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">সর্বোচ্চ স্টাফ</label>
                        <input type="number" name="max_staff" value="5" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">ফিচারসমূহ (কমা দিয়ে লিখুন)</label>
                    <textarea name="features" rows="2" placeholder="স্টক ট্র্যাকিং, এসএমএস ইনভয়েস, কোটা রিপোর্ট" class="w-full text-sm rounded-lg border-gray-300"></textarea>
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newPlanModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">প্ল্যান সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
