<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('সার ও বালাইনাশক পণ্য এবং মজুদ (Products & Stock)') }}
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">গুদামে বর্তমান স্টক: {{ number_format($totalStockBags) }} বস্তা/প্যাক | কম স্টক সতর্কতা: {{ $lowStockCount }} টি</p>
            </div>
            <button onclick="document.getElementById('newProductModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন সার / পণ্য যোগ করুন
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

            <!-- Search and Filter -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-4 items-center justify-between">
                <form method="GET" action="{{ route('dealer.products.index') }}" class="flex flex-wrap gap-3 items-center w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="সারের নাম বা ব্র্যান্ড দিয়ে খুঁজুন..." class="text-sm rounded-lg border-gray-300 w-64 focus:ring-emerald-500 focus:border-emerald-500">
                    <select name="category" class="text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">সকল ক্যাটাগরি</option>
                        <option value="Chemical Fertilizer" {{ request('category') === 'Chemical Fertilizer' ? 'selected' : '' }}>রাসায়নিক সার (Chemical)</option>
                        <option value="Organic Fertilizer" {{ request('category') === 'Organic Fertilizer' ? 'selected' : '' }}>জৈব সার (Organic)</option>
                        <option value="Micronutrient" {{ request('category') === 'Micronutrient' ? 'selected' : '' }}>অনুখাদ্য (Micronutrient)</option>
                        <option value="Pesticide" {{ request('category') === 'Pesticide' ? 'selected' : '' }}>কীটনাশক (Pesticide)</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg">ফিল্টার করুন</button>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('dealer.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">রিসেট</a>
                    @endif
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">সারের নাম ও ব্র্যান্ড</th>
                                <th class="px-5 py-3.5">ক্যাটাগরি</th>
                                <th class="px-5 py-3.5">প্যাক সাইজ / ইউনিট</th>
                                <th class="px-5 py-3.5">ক্রয় মূল্য</th>
                                <th class="px-5 py-3.5">বিক্রয় মূল্য</th>
                                <th class="px-5 py-3.5">বর্তমান মজুদ</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5 text-right">স্টক আপডেট</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900">{{ $product->bangla_name ?? $product->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $product->name }} | ব্র্যান্ড: {{ $product->brand ?? 'BADC/BCIC' }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-xs font-semibold text-gray-700">{{ $product->category }}</td>
                                    <td class="px-5 py-4 text-xs font-medium text-gray-600">{{ $product->unit }}</td>
                                    <td class="px-5 py-4 text-xs">৳ {{ number_format($product->buy_price) }}</td>
                                    <td class="px-5 py-4 font-semibold text-gray-900">৳ {{ number_format($product->sell_price) }}</td>
                                    <td class="px-5 py-4 font-black {{ $product->isLowStock() ? 'text-amber-600' : 'text-emerald-700' }}">
                                        {{ number_format($product->stock_quantity) }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold {{ $product->isLowStock() ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $product->isLowStock() ? 'মজুত কম' : 'পর্যাপ্ত' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <form method="POST" action="{{ route('dealer.products.stock', $product->id) }}" class="inline-flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" class="w-20 text-xs rounded border-gray-300 py-1 px-2 font-bold text-center">
                                            <button type="submit" class="px-2.5 py-1 bg-gray-800 hover:bg-gray-900 text-white rounded text-xs font-semibold">হালনাগাদ</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-gray-400">কোনো সার বা পণ্য পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- New Product Modal -->
    <div id="newProductModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন সার / পণ্য এন্ট্রি</h3>
                <button onclick="document.getElementById('newProductModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.products.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">বাংলা নাম *</label>
                        <input type="text" name="bangla_name" required placeholder="উদাঃ ইউরিয়া সার (৫০ কেজি)" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ইংরেজি নাম *</label>
                        <input type="text" name="name" required placeholder="Urea 50kg Bag" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ক্যাটাগরি *</label>
                        <select name="category" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="Chemical Fertilizer">রাসায়নিক সার (Chemical)</option>
                            <option value="Organic Fertilizer">জৈব সার (Organic)</option>
                            <option value="Micronutrient">অনুখাদ্য (Micronutrient)</option>
                            <option value="Pesticide">কীটনাশক (Pesticide)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">কোম্পানি / ব্র্যান্ড</label>
                        <input type="text" name="brand" placeholder="BCIC / BADC / ACI" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">প্যাক ইউনিট *</label>
                        <input type="text" name="unit" value="50kg Bag" required class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ক্রয় মূল্য (৳) *</label>
                        <input type="number" step="0.01" name="buy_price" required placeholder="1250" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">বিক্রয় মূল্য (৳) *</label>
                        <input type="number" step="0.01" name="sell_price" required placeholder="1350" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">বর্তমান প্রারম্ভিক স্টক *</label>
                        <input type="number" name="stock_quantity" required placeholder="100" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">কম স্টক সতর্কতা সীমা</label>
                        <input type="number" name="alert_quantity" value="20" class="w-full text-sm rounded-lg border-gray-300">
                    </div>
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newProductModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
