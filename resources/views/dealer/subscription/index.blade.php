<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('আমার সাবস্ক্রিপশন ও লাইসেন্স প্যাকেজ (My Subscription)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Current Plan Card -->
            <div class="bg-gradient-to-r from-emerald-800 to-teal-900 text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-emerald-700 text-emerald-100">সক্রিয় ডিলারশিপ প্ল্যান</span>
                    <h3 class="text-2xl font-black text-white mt-2">{{ $dealer?->plan?->name ?? 'বিজনেস প্রো (Professional)' }}</h3>
                    <p class="text-sm text-emerald-200 mt-1">
                        মেয়াদ উত্তীর্ণের তারিখ: <span class="font-bold text-white">{{ $dealer?->subscription_ends_at ? $dealer->subscription_ends_at->format('d F, Y') : 'সক্রিয় (Active)' }}</span>
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-white">৳ {{ number_format($dealer?->plan?->price ?? 3500) }}</span>
                    <span class="text-xs text-emerald-200">/ মাসিক</span>
                </div>
            </div>

            <!-- Available Plans to Upgrade -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-bold text-gray-900 text-lg">অন্যান্য সাবস্ক্রিপশন প্ল্যানসমূহ</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($plans as $plan)
                        <div class="border rounded-2xl p-5 flex flex-col justify-between {{ ($dealer?->subscription_plan_id == $plan->id) ? 'border-emerald-500 bg-emerald-50/20 ring-2 ring-emerald-500' : 'border-gray-200' }}">
                            <div>
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-gray-900 text-base">{{ $plan->name }}</h4>
                                    @if($dealer?->subscription_plan_id == $plan->id)
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">বর্তমান</span>
                                    @endif
                                </div>
                                <div class="text-2xl font-black text-gray-900 mt-3">৳ {{ number_format($plan->price) }} <span class="text-xs font-normal text-gray-500">/ {{ $plan->billing_cycle }}</span></div>
                                <ul class="text-xs text-gray-600 mt-4 space-y-2">
                                    <li>✓ আউটলেট সীমা: {{ $plan->max_outlets }} টি</li>
                                    <li>✓ স্টাফ আইডি: {{ $plan->max_staff }} জন</li>
                                    @if(is_array($plan->features))
                                        @foreach($plan->features as $f)
                                            <li>✓ {{ $f }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
