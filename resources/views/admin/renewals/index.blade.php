<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('সাবস্ক্রিপশন মেয়াদ ও রিনিউয়াল ব্যবস্থাপনা (Expiry & Renewals)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800">আসন্ন ৩০ দিনে মেয়াদ শেষ হওয়া ডিলার তালিকা</h3>
                        <p class="text-xs text-gray-400">মেয়াদ বৃদ্ধির জন্য 'মেয়াদ বাড়ান' বাটনে ক্লিক করুন</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">ডিলার ও প্রতিষ্ঠান</th>
                                <th class="px-5 py-3.5">বর্তমান প্ল্যান</th>
                                <th class="px-5 py-3.5">মেয়াদ উত্তীর্ণের তারিখ</th>
                                <th class="px-5 py-3.5">বাকি দিন</th>
                                <th class="px-5 py-3.5 text-right">রিনিউয়াল অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($expiringSoon as $d)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $d->company_name }}<br><span class="text-xs font-normal text-indigo-600">{{ $d->phone }}</span></td>
                                    <td class="px-5 py-4">{{ $d->plan->name ?? 'Basic' }}</td>
                                    <td class="px-5 py-4 text-xs font-semibold text-gray-800">{{ $d->subscription_ends_at ? $d->subscription_ends_at->format('d M, Y') : 'N/A' }}</td>
                                    <td class="px-5 py-4">
                                        @if($d->subscription_ends_at && $d->subscription_ends_at->isPast())
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800">মেয়াদ শেষ হয়েছে</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">
                                                {{ now()->diffInDays($d->subscription_ends_at) }} দিন বাকি
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <form method="POST" action="{{ route('admin.renewals.extend', $d->id) }}" class="inline-flex gap-2 items-center">
                                            @csrf
                                            <select name="months" class="text-xs rounded border-gray-300 py-1">
                                                <option value="1">১ মাস</option>
                                                <option value="3">৩ মাস</option>
                                                <option value="6">৬ মাস</option>
                                                <option value="12">১ বছর</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-semibold">মেয়াদ বাড়ান</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">আপাতত কোনো ডিলারের মেয়াদ শেষ হওয়ার কাছাকাছি নেই।</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
