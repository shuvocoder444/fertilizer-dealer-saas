<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('প্ল্যাটফর্ম অডিট ও অ্যাক্টিভিটি লগ (Audit / Activity Logs)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">সিস্টেম অ্যাকশন লগ রেকর্ডস</h3>
                    <p class="text-xs text-gray-400">নিরাপত্তা ও অপারেশনাল নজরদারির জন্য সংরক্ষিত স্বয়ংক্রিয় রেকর্ড</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">লগ বিভাগ</th>
                                <th class="px-5 py-3.5">বিবরণ (Action Description)</th>
                                <th class="px-5 py-3.5">সম্পাদনকারী (Causer)</th>
                                <th class="px-5 py-3.5">সময়</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $log->log_name ?? 'system' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-medium text-gray-900">{{ $log->description }}</td>
                                    <td class="px-5 py-4 text-xs text-indigo-600 font-semibold">{{ $log->causer?->name ?? 'System' }}</td>
                                    <td class="px-5 py-4 text-xs text-gray-400">{{ $log->created_at->diffForHumans() }} ({{ $log->created_at->format('d/m/Y H:i') }})</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">কোনো লগ রেকর্ড পাওয়া যায়নি।</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
