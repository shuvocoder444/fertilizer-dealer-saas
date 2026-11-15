<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('সকল ডিলার এবং গ্রাহক ব্যবস্থাপনা (Dealers & Subscribers)') }}
            </h2>
            <button onclick="document.getElementById('newDealerModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন ডিলার নিবন্ধন করুন
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

            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-4 items-center justify-between">
                <form method="GET" action="{{ route('admin.dealers.index') }}" class="flex flex-wrap gap-3 items-center w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="কোম্পানির নাম, ডিলার, ফোন বা জেলা দিয়ে খুঁজুন..." class="text-sm rounded-lg border-gray-300 w-72 focus:ring-indigo-500 focus:border-indigo-500">
                    <select name="status" class="text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">সকল স্ট্যাটাস</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>সক্রিয় (Active)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>সাময়িক স্থগিত (Suspended)</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg">খুঁজুন</button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.dealers.index') }}" class="text-sm text-gray-500 hover:text-gray-700">রিসেট</a>
                    @endif
                </form>
            </div>

            <!-- Dealers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">ডিলার প্রতিষ্ঠান</th>
                                <th class="px-5 py-3.5">স্বত্বাধিকারী ও ফোন</th>
                                <th class="px-5 py-3.5">ঠিকানা ও জেলা</th>
                                <th class="px-5 py-3.5">প্যাকেজ / প্ল্যান</th>
                                <th class="px-5 py-3.5">মেয়াদ উত্তীর্ণ</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($dealers as $dealer)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900">{{ $dealer->company_name }}</div>
                                        <div class="text-xs text-gray-400">লাইসেন্স: {{ $dealer->trade_license ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-gray-800">{{ $dealer->contact_person }}</div>
                                        <div class="text-xs text-indigo-600">{{ $dealer->phone }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div>{{ $dealer->district }}</div>
                                        <div class="text-xs text-gray-400">{{ $dealer->upazila ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex px-2 py-1 rounded text-xs font-semibold bg-indigo-50 text-indigo-700">
                                            {{ $dealer->plan->name ?? 'স্ট্যান্ডার্ড' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs">
                                        @if($dealer->subscription_ends_at)
                                            <span class="{{ $dealer->subscription_ends_at->isPast() ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                                {{ $dealer->subscription_ends_at->format('d M, Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">অনির্দিষ্ট</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <form method="POST" action="{{ route('admin.dealers.status', $dealer->id) }}" class="inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-gray-200 py-1 font-semibold {{ $dealer->status === 'active' ? 'bg-green-50 text-green-700' : ($dealer->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                                <option value="active" {{ $dealer->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="pending" {{ $dealer->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="suspended" {{ $dealer->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="text-xs text-gray-400">নিবন্ধিত: {{ $dealer->created_at->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-8 text-center text-gray-400">কোনো ডিলার পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($dealers->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $dealers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- New Dealer Modal -->
    <div id="newDealerModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন ডিলার নিবন্ধন ফর্ম</h3>
                <button onclick="document.getElementById('newDealerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.dealers.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">কোম্পানি / দোকানের নাম *</label>
                    <input type="text" name="company_name" required placeholder="উদাঃ মেসার্স জননী এগ্রো" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">স্বত্বাধিকারীর নাম *</label>
                        <input type="text" name="contact_person" required placeholder="মোঃ করিম উল্লাহ" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">মোবাইল নম্বর *</label>
                        <input type="text" name="phone" required placeholder="017xxxxxxxx" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">জেলা *</label>
                        <input type="text" name="district" required placeholder="বগুড়া" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">উপজেলা</label>
                        <input type="text" name="upazila" placeholder="শেরপুর" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ট্রেড লাইসেন্স নং</label>
                        <input type="text" name="trade_license" placeholder="TL-XXXX" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">সাবস্ক্রিপশন প্ল্যান</label>
                        <select name="subscription_plan_id" class="w-full text-sm rounded-lg border-gray-300">
                            @foreach($plans as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (৳{{ number_format($p->price) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newDealerModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
