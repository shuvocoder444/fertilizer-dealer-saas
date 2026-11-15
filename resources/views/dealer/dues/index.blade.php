<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('বাকির খাতা ও কালেকশন (Due / Credit Ledger)') }}
                </h2>
                <p class="text-xs text-red-600 font-bold mt-0.5">মোট অপরিশোধিত বাকি: ৳ {{ number_format($totalDue) }}</p>
            </div>
            <button onclick="document.getElementById('collectDueModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + বাকি টাকা জমা গ্রহণ (Collect Due)
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Customers with Due -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800">বাকি থাকা কৃষক ও বিক্রেতাদের খতিয়ান</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                                <tr>
                                    <th class="px-5 py-3.5">কৃষকের নাম</th>
                                    <th class="px-5 py-3.5">গ্রাম / ঠিকানা</th>
                                    <th class="px-5 py-3.5">ফোন</th>
                                    <th class="px-5 py-3.5">বর্তমান বাকি (৳)</th>
                                    <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($customersWithDue as $c)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">
                                            <a href="{{ route('dealer.customers.show', $c->id) }}" class="hover:text-emerald-600 transition">
                                                {{ $c->name }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 text-xs whitespace-nowrap text-gray-700">{{ $c->village ?? 'N/A' }}</td>
                                        <td class="px-5 py-4 text-xs whitespace-nowrap text-indigo-600 font-semibold">{{ $c->phone }}</td>
                                        <td class="px-5 py-4 font-black whitespace-nowrap text-red-600">৳ {{ number_format($c->current_due) }}</td>
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            <a href="{{ route('dealer.customers.show', $c->id) }}" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded me-2 transition">
                                                খতিয়ান
                                            </a>
                                            <button onclick="openCollectModal('{{ $c->id }}', '{{ $c->name }}', '{{ $c->current_due }}')" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded transition shadow-sm">
                                                জমা নিন
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">কোনো গ্রাহকের বাকি নেই।</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Recent Collections -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                    <h3 class="font-bold text-gray-800 text-base">সাম্প্রতিক বাকি আদায় (Collections)</h3>
                    <div class="space-y-3">
                        @forelse($recentCollections as $col)
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sm text-gray-900">{{ $col->customer->name ?? 'গ্রাহক' }}</span>
                                    <span class="text-xs font-bold text-emerald-600">+৳ {{ number_format($col->amount) }}</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1 flex justify-between">
                                    <span>রসিদ: {{ $col->receipt_no ?? 'N/A' }}</span>
                                    <span>{{ $col->collection_date ? $col->collection_date->format('d/m/Y') : '' }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">কোনো সাম্প্রতিক কালেকশন নেই।</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Collect Due Modal -->
    <div id="collectDueModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">বাকি টাকা আদায় রসিদ</h3>
                <button onclick="document.getElementById('collectDueModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.dues.collect') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">কৃষক / কাস্টমার নির্বাচন করুন *</label>
                    <select id="modal_customer_id" name="customer_id" required class="w-full text-sm rounded-lg border-gray-300">
                        @foreach($customersWithDue as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} (বাকি: ৳{{ number_format($c->current_due) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">জমার পরিমাণ (৳) *</label>
                    <input type="number" id="modal_amount" step="0.01" name="amount" required placeholder="5000" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">মাধ্যম</label>
                    <select name="payment_method" class="w-full text-sm rounded-lg border-gray-300">
                        <option value="Cash">নগদ (Cash)</option>
                        <option value="bKash">বিকাশ (bKash)</option>
                        <option value="Nagad">নগদ (Nagad)</option>
                        <option value="Bank">ব্যাংক</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">মন্তব্য</label>
                    <input type="text" name="notes" placeholder="যেকোনো নোট..." class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('collectDueModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">জমা নিশ্চিত করুন</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCollectModal(id, name, due) {
            document.getElementById('modal_customer_id').value = id;
            document.getElementById('modal_amount').value = due;
            document.getElementById('collectDueModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
