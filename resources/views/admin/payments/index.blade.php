<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('পেমেন্ট ও ইনভয়েস ইতিহাস (Payments & Invoices)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase">মোট আদায়কৃত সাবস্ক্রিপশন</div>
                    <div class="text-2xl font-bold text-green-600 mt-1">৳ {{ number_format($totalCollected) }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">ডিলার সাবস্ক্রিপশন বিলিং হিস্ট্রি</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">ডিলার প্রতিষ্ঠান</th>
                                <th class="px-5 py-3.5">সাবস্ক্রিপশন প্ল্যান</th>
                                <th class="px-5 py-3.5">মূল্য</th>
                                <th class="px-5 py-3.5">মেয়াদ উত্তীর্ণের তারিখ</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($dealers as $d)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $d->company_name }}<br><span class="text-xs font-normal text-gray-400">{{ $d->phone }}</span></td>
                                    <td class="px-5 py-4">{{ $d->plan->name ?? 'Standard' }}</td>
                                    <td class="px-5 py-4 font-semibold text-green-600">৳ {{ number_format($d->plan->price ?? 0) }}</td>
                                    <td class="px-5 py-4 text-xs">{{ $d->subscription_ends_at ? $d->subscription_ends_at->format('d M, Y') : 'N/A' }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">Paid / Active</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-4 text-center text-gray-400">কোনো বিলিং তথ্য নেই।</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
