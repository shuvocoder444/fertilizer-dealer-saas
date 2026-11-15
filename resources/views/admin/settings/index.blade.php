<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('প্ল্যাটফর্ম সাধারণ সেটিংস (Platform Settings)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">প্ল্যাটফর্মের নাম</label>
                        <input type="text" name="app_name" value="Fertilizer Dealer SaaS Bangladesh" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">মুদ্রা প্রতীক (Currency Symbol)</label>
                            <input type="text" name="currency" value="৳ (BDT)" class="w-full text-sm rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">অফিসিয়াল সাপোর্ট ইমেইল</label>
                            <input type="email" name="support_email" value="support@fertilizerdealer.com.bd" class="w-full text-sm rounded-lg border-gray-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">এসএমএস গেটওয়ে প্রোভাইডার</label>
                        <select name="sms_gateway" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="greenweb">Greenweb SMS (Bangladesh)</option>
                            <option value="bulksmsbd">BulkSMSBD</option>
                            <option value="mimsms">MiMSMS</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">সেটিংস সেভ করুন</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
