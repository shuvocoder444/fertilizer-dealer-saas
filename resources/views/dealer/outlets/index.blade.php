<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('ডিলারশিপ আউটলেট ও শাখা গোডাউন (Dealership Outlets)') }}
            </h2>
            <button onclick="document.getElementById('newOutletModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন আউটলেট যুক্ত করুন
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($outlets as $outlet)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-400">{{ $outlet->code ?? 'OUTLET' }}</span>
                            @if($outlet->is_main)
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">প্রধান ডিপো (Main)</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-700">সাব-আউটলেট</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $outlet->name }}</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div>ইনচার্জ: <span class="font-medium text-gray-800">{{ $outlet->incharge_name ?? 'নির্ধারিত নয়' }}</span></div>
                            <div>ফোন: <span class="font-medium text-indigo-600">{{ $outlet->phone ?? 'N/A' }}</span></div>
                            <div class="text-xs text-gray-400 mt-2">{{ $outlet->address ?? 'বগুড়া' }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-8 text-center text-gray-400 rounded-xl border border-gray-100">কোনো আউটলেট যোগ করা হয়নি।</div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- New Outlet Modal -->
    <div id="newOutletModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন আউটলেট এন্ট্রি</h3>
                <button onclick="document.getElementById('newOutletModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.outlets.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">আউটলেটের নাম *</label>
                    <input type="text" name="name" required placeholder="উদাঃ শেরপুর বাজার শোরুম" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">আউটলেট কোড</label>
                        <input type="text" name="code" placeholder="OUT-03" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">মোবাইল</label>
                        <input type="text" name="phone" placeholder="017xxxxxxxx" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">দায়িত্বপ্রাপ্ত ইনচার্জের নাম</label>
                    <input type="text" name="incharge_name" placeholder="কর্মকর্তার নাম" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">আউটলেটের ঠিকানা</label>
                    <input type="text" name="address" placeholder="বাজার মোড়, শেরপুর" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newOutletModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
