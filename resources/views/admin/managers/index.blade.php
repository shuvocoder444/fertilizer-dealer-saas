<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('গ্লোবাল ও বিভাগীয় ম্যানেজারসমূহ (Global Managers)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">ম্যানেজার তালিকা ও রোলস</h3>
                    <p class="text-xs text-gray-400">প্ল্যাটফর্ম মনিটরিং ও বিভাগীয় ডিলারশিপ তদারকি টিম</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">নাম ও ইমেইল</th>
                                <th class="px-5 py-3.5">রোল (Role)</th>
                                <th class="px-5 py-3.5">যোগদানের তারিখ</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($managers as $manager)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900">{{ $manager->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $manager->email }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $manager->roles->pluck('name')->implode(', ') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs">{{ $manager->created_at->format('d M, Y') }}</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-4 text-center text-gray-400">কোনো ম্যানেজার পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
