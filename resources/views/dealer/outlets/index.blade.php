<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v12a2 2 0 01-2 2z"/></svg>
                    <span>{{ __('ডিলারশিপ আউটলেট ও শাখা গোডাউন (Outlets & Godowns)') }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">প্রধান ডিপো, সাব-আউটলেট ও গোডাউন ম্যানেজমেন্ট এবং স্থানান্তর</p>
            </div>
            <button onclick="document.getElementById('newOutletModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ নতুন আউটলেট / গোডাউন যুক্ত করুন</span>
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                </div>
            @endif

            <!-- Guidance Alert: গোডাউন পরিবর্তন করলে কী করবেন? -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-sm text-blue-900 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="space-y-1">
                    <div class="font-bold text-blue-950">💡 গোডাউন বা দোকান পরিবর্তন / স্থানান্তর করলে করণীয়:</div>
                    <div class="text-xs text-blue-800 leading-relaxed space-y-1">
                        <div>১. <strong>ঠিকানা বা ইনচার্জ পরিবর্তন:</strong> গোডাউন কার্ডের <em>"এডিট / পরিবর্তন"</em> বাটনে চাপ দিয়ে নতুন ঠিকানা, নতুন ইনচার্জ বা নতুন ফোন নম্বর লিখে সেভ করুন।</div>
                        <div>২. <strong>প্রধান ডিপো অদলবদল:</strong> কোনো সাব-আউটলেটকে প্রধান ডিপো করতে চাইলে <em>"প্রধান ডিপো করুন"</em> বাটনে ক্লিক করুন।</div>
                        <div>৩. <strong>গোডাউন ছেড়ে দিলে বা বন্ধ করলে:</strong> গোডাউন কার্ডের লাল <em>"মুছে ফেলুন"</em> বাটনে ক্লিক করে গোডাউন ডিলিট করতে পারবেন (এতে পূর্বের বিক্রয় মেমোর কোনো ক্ষতি হবে না)।</div>
                    </div>
                </div>
            </div>

            <!-- Outlets Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($outlets as $outlet)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                        <div class="space-y-4">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-gray-100 text-gray-600 font-mono">
                                    {{ $outlet->code ?? 'OUTLET-' . $outlet->id }}
                                </span>
                                @if($outlet->is_main)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        প্রধান ডিপো (Main)
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        সাব-আউটলেট
                                    </span>
                                @endif
                            </div>

                            <!-- Name & Address -->
                            <div>
                                <h3 class="font-black text-lg text-gray-900">{{ $outlet->name }}</h3>
                                <p class="text-xs text-gray-500 mt-1 flex items-start gap-1">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $outlet->address ?: 'ঠিকানা নির্ধারিত হয়নি' }}</span>
                                </p>
                            </div>

                            <!-- Incharge & Staff Info -->
                            <div class="p-3 rounded-lg bg-gray-50 border border-gray-100 space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">গোডাউন ইনচার্জ:</span>
                                    <span class="font-bold text-gray-800">{{ $outlet->incharge_name ?: 'নির্ধারিত নয়' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">যোগাযোগ ফোন:</span>
                                    @if($outlet->phone)
                                        <a href="tel:{{ $outlet->phone }}" class="font-bold text-emerald-600 hover:underline">{{ $outlet->phone }}</a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between pt-1 border-t border-gray-200/60">
                                    <span class="text-gray-400">নিযুক্ত কর্মী:</span>
                                    <a href="{{ route('dealer.staff.index') }}" class="font-bold text-indigo-600 hover:underline">
                                        👥 {{ $outlet->staffMembers()->count() }} জন কর্মী
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-5 mt-5 border-t border-gray-100 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditOutletModal({{ json_encode($outlet) }})" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-emerald-50 hover:text-emerald-700 text-gray-700 text-xs font-bold rounded-lg transition border border-gray-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>এডিট / পরিবর্তন</span>
                                </button>

                                @if(!$outlet->is_main)
                                    <form method="POST" action="{{ route('dealer.outlets.make-main', $outlet->id) }}" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 text-xs text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-semibold" title="প্রধান ডিপো হিসেবে সেট করুন">
                                            প্রধান ডিপো করুন
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('dealer.outlets.destroy', $outlet->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই গোডাউন/আউটলেটটি মুছে ফেলতে চান?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition" title="গোডাউন মুছে ফেলুন">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 text-center text-gray-400 rounded-xl border border-gray-100 space-y-3">
                        <div class="text-4xl">🏢</div>
                        <div class="font-bold text-gray-600">কোনো গোডাউন বা আউটলেট যোগ করা হয়নি।</div>
                        <button onclick="document.getElementById('newOutletModal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-lg">
                            + নতুন আউটলেট যুক্ত করুন
                        </button>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- New Outlet Modal -->
    <div id="newOutletModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-black text-lg text-gray-900">নতুন আউটলেট / গোডাউন এন্ট্রি</h3>
                    <p class="text-xs text-gray-400">নতুন শাখা দোকান বা গোডাউনের বিবরণ দিন</p>
                </div>
                <button onclick="document.getElementById('newOutletModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('dealer.outlets.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">আউটলেট / গোডাউনের নাম *</label>
                    <input type="text" name="name" required placeholder="উদাঃ শেরপুর প্রধান ডিপো ও শোরুম" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">গোডাউন কোড (ঐচ্ছিক)</label>
                    <input type="text" name="code" placeholder="উদাঃ GDN-01" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">ইনচার্জের নাম</label>
                    <input type="text" name="incharge_name" placeholder="উদাঃ মো: শফিকুল ইসলাম" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">মোবাইল ফোন নম্বর</label>
                    <input type="text" name="phone" placeholder="০১৭১২-৩৪৫৬৭৮" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">গোডাউনের পূর্ণ ঠিকানা</label>
                    <textarea name="address" rows="2" placeholder="রোড, বাজার, উপজেলা, জেলা" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>
                <div class="pt-3 flex items-center justify-end gap-2 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('newOutletModal').classList.add('hidden')" class="px-4 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg">বাতিল</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Outlet Modal -->
    <div id="editOutletModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-black text-lg text-gray-900">গোডাউন / আউটলেটের তথ্য পরিবর্তন</h3>
                    <p class="text-xs text-gray-400">স্থানান্তর বা ইনচার্জ পরিবর্তনের তথ্য আপডেট করুন</p>
                </div>
                <button onclick="document.getElementById('editOutletModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form id="editOutletForm" method="POST" action="" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">আউটলেট / গোডাউনের নাম *</label>
                    <input type="text" id="edit_name" name="name" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">গোডাউন কোড</label>
                    <input type="text" id="edit_code" name="code" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">নতুন ইনচার্জের নাম</label>
                    <input type="text" id="edit_incharge_name" name="incharge_name" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">মোবাইল ফোন নম্বর</label>
                    <input type="text" id="edit_phone" name="phone" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">নতুন ঠিকানা / অবস্থান</label>
                    <textarea id="edit_address" name="address" rows="2" class="w-full text-sm rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="edit_is_main" name="is_main" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                    <label for="edit_is_main" class="text-xs font-bold text-gray-700 cursor-pointer">
                        এই গোডাউনটিকে 'প্রধান ডিপো (Main Godown)' হিসেবে নির্ধারণ করুন
                    </label>
                </div>
                <div class="pt-3 flex items-center justify-end gap-2 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('editOutletModal').classList.add('hidden')" class="px-4 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg">বাতিল</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm">পরিবর্তন সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditOutletModal(outlet) {
            const form = document.getElementById('editOutletForm');
            form.action = `/dealer/outlets/${outlet.id}`;
            document.getElementById('edit_name').value = outlet.name || '';
            document.getElementById('edit_code').value = outlet.code || '';
            document.getElementById('edit_incharge_name').value = outlet.incharge_name || '';
            document.getElementById('edit_phone').value = outlet.phone || '';
            document.getElementById('edit_address').value = outlet.address || '';
            document.getElementById('edit_is_main').checked = Boolean(outlet.is_main);
            document.getElementById('editOutletModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
