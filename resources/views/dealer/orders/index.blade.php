<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('কৃষক ও সাব-ডিলার অগ্রিম বুকিং ও অর্ডার (Order Requests)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">মৌসুমি অগ্রিম সার বুকিং তালিকা</h3>
                        <p class="text-xs text-gray-400">রবি ও খরিপ মৌসুমের জন্য কৃষকদের ইউরিয়া, ডিএপি ও টিএসপি চাহিদা বুকিং</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">অর্ডার কোড</th>
                                <th class="px-5 py-3.5">কৃষক / পাইকার</th>
                                <th class="px-5 py-3.5">চাহিদা সার ও পরিমাণ</th>
                                <th class="px-5 py-3.5">প্রত্যাশিত ডেলিভারি তারিখ</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-5 py-4 font-bold text-indigo-600">ORD-9912</td>
                                <td class="px-5 py-4 font-semibold text-gray-900">মোঃ রফিকুল ইসলাম (শেরপুর)</td>
                                <td class="px-5 py-4">ইউরিয়া সার - ২০ বস্তা, ডিএপি - ১০ বস্তা</td>
                                <td class="px-5 py-4 text-xs font-medium text-gray-700">২০ নভেম্বর, ২০২৬</td>
                                <td class="px-5 py-4"><span class="px-2 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800">পেন্ডিং বুকিং</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-5 py-4 font-bold text-indigo-600">ORD-9913</td>
                                <td class="px-5 py-4 font-semibold text-gray-900">মোতালেব ট্রেডার্স (ভবানীপুর)</td>
                                <td class="px-5 py-4">এমওপি পটাশ - ৫০ বস্তা</td>
                                <td class="px-5 py-4 text-xs font-medium text-gray-700">২৫ নভেম্বর, ২০২৬</td>
                                <td class="px-5 py-4"><span class="px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800">অনুমোদিত (Approved)</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
