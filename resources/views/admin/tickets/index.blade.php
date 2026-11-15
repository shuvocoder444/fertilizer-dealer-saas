<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('ডিলার সাপোর্ট টিকিট ও হেল্পডেস্ক (Support Tickets)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($tickets as $ticket)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="font-black text-indigo-600 text-sm">{{ $ticket->ticket_number }}</span>
                                <span class="px-2.5 py-0.5 rounded text-xs font-bold {{ $ticket->status === 'Open' ? 'bg-amber-100 text-amber-800' : ($ticket->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $ticket->status }}
                                </span>
                                <span class="text-xs text-gray-400">অগ্রাধিকার: {{ $ticket->priority }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $ticket->created_at->format('d M, Y h:i A') }}</span>
                        </div>

                        <h3 class="font-bold text-gray-900 text-base">{{ $ticket->subject }}</h3>
                        <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100">{{ $ticket->message }}</p>

                        @if($ticket->admin_reply)
                            <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-lg">
                                <div class="text-xs font-bold text-indigo-800 mb-1">অ্যাডমিন উত্তর (Admin Reply):</div>
                                <div class="text-sm text-indigo-950">{{ $ticket->admin_reply }}</div>
                            </div>
                        @endif

                        <!-- Reply Form -->
                        <form method="POST" action="{{ route('admin.tickets.reply', $ticket->id) }}" class="pt-2 flex flex-col md:flex-row gap-3">
                            @csrf
                            <input type="text" name="admin_reply" required placeholder="ডিলারকে উত্তর লিখুন..." class="flex-1 text-sm rounded-lg border-gray-300">
                            <select name="status" class="text-sm rounded-lg border-gray-300">
                                <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $ticket->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">উত্তর দিন</button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center text-gray-400 rounded-xl border border-gray-100">কোনো সাপোর্ট টিকিট নেই।</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
