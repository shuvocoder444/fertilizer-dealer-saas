<x-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('নতুন ডিলারশিপের বিবরণ (Dealership Details)') }}
    </x-slot>

    <x-slot name="description">
        {{ __('আপনার যদি একাধিক সার ডিলারশিপ বা অন্য কোনো জেলায় আলাদা ট্রেড লাইসেন্সভুক্ত প্রতিষ্ঠান থাকে, তবে এখানে নাম দিয়ে নতুন ডিলারশিপ তৈরি করে আলাদাভাবে স্টক ও বিক্রয় পরিচালনা করতে পারেন।') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-label value="{{ __('ডিলারশিপ স্বত্বাধিকারী (Owner)') }}" />

            <div class="flex items-center mt-2">
                <img class="size-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">

                <div class="ms-4 leading-tight">
                    <div class="text-gray-900 font-semibold">{{ $this->user->name }}</div>
                    <div class="text-gray-500 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('ডিলারশিপ প্রতিষ্ঠানের নাম (Dealership Business Name)') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" placeholder="যেমন: মেসার্স পদ্মা এগ্রো ট্রেডার্স (রাজশাহী)" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button class="bg-emerald-600 hover:bg-emerald-700">
            {{ __('নতুন ডিলারশিপ তৈরি করুন') }}
        </x-button>
    </x-slot>
</x-form-section>
