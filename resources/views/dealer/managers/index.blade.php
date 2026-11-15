<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('ডিলার ম্যানেজারসমূহ (Dealer Managers)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">ডিলারশিপের দায়িত্বপ্রাপ্ত টিম মেম্বার ও ম্যানেজারগণ</h3>
                <div class="divide-y divide-gray-100">
                    @forelse($members as $m)
                        <div class="py-4 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-gray-900">{{ $m->name }}</div>
                                <div class="text-xs text-gray-400">{{ $m->email }}</div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                {{ $m->roles->pluck('name')->implode(', ') ?: 'Manager / Staff' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">কোনো ম্যানেজার নেই।</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
