<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('ডিলারশিপ কর্মী ও বিক্রয় প্রতিনিধি (Staff Management)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">আউটলেট ও গোডাউন কর্মী তালিকা</h3>
                        <p class="text-xs text-gray-400">বিক্রয় চালান ও ডেলিভারি পরিচালনার একাউন্ট</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">কর্মীর নাম</th>
                                <th class="px-5 py-3.5">ইমেইল</th>
                                <th class="px-5 py-3.5">পদবী / ভূমিকা</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($staffMembers as $s)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $s->name }}</td>
                                    <td class="px-5 py-4 text-xs">{{ $s->email }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            {{ $s->roles->pluck('name')->implode(', ') ?: 'Staff / Salesman' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4"><span class="px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">Active</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
