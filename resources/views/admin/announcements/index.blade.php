<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('প্ল্যাটফর্ম নোটিশ ও সার্কুলার (Announcements)') }}
            </h2>
            <button onclick="document.getElementById('newNoticeModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                + নতুন নোটিশ জারি করুন
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

            <div class="space-y-4">
                @forelse($announcements as $ann)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase {{ $ann->type === 'urgent' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $ann->type }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $ann->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $ann->title }}</h3>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $ann->content }}</p>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center text-gray-400 rounded-xl border border-gray-100">কোনো নোটিশ নেই।</div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- New Notice Modal -->
    <div id="newNoticeModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">নতুন নোটিশ তৈরি</h3>
                <button onclick="document.getElementById('newNoticeModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">শিরোনাম *</label>
                    <input type="text" name="title" required placeholder="উদাঃ রবি মৌসুমের ইউরিয়া সার সংক্রান্ত বিজ্ঞপ্তি" class="w-full text-sm rounded-lg border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ধরণ</label>
                        <select name="type" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="info">তথ্যমূলক (Info)</option>
                            <option value="urgent">জরুরি (Urgent)</option>
                            <option value="warning">সতর্কবার্তা (Warning)</option>
                            <option value="success">সাফল্য (Success)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">কাদের জন্য প্রযোজ্য</label>
                        <select name="target_audience" class="w-full text-sm rounded-lg border-gray-300">
                            <option value="all">সকল ইউজার</option>
                            <option value="dealers">শুধুমাত্র ডিলারগণ</option>
                            <option value="managers">ম্যানেজারগণ</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">নোটিশের বিবরণ *</label>
                    <textarea name="content" rows="4" required placeholder="বিস্তারিত লিখুন..." class="w-full text-sm rounded-lg border-gray-300"></textarea>
                </div>
                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newNoticeModal').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm text-gray-600">বাতিল</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">প্রকাশ করুন</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
