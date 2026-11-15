<!-- Top Banner Notice -->
<div class="bg-emerald-900 text-emerald-100 text-xs py-2 px-4 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="flex items-center gap-2 text-center sm:text-left">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-700 text-emerald-100 uppercase tracking-wide">বিসিআইসি ও বিএডিসি</span>
            <span>বাংলাদেশের সার, বালাইনাশক ও বীজ ডিলারদের জন্য ডিজিটাল অ্যাকাউন্টিং ও ইনভেন্টরি ম্যানেজমেন্ট প্ল্যাটফর্ম</span>
        </div>
        <div class="flex items-center gap-4 text-[11px]">
            <a href="tel:+8801700000000" class="hover:text-white flex items-center gap-1 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                হটলাইন: <span>+৮৮০ ১৭০০-০০০০০০</span>
            </a>
            <span class="text-emerald-700">|</span>
            <span class="text-emerald-300">সকাল ৯টা - রাত ১০টা</span>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50 transition" x-data="{ mobileNav: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-700 to-green-500 text-white flex items-center justify-center font-black text-xl shadow-md group-hover:scale-105 transition transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-1.5">
                        <span>সার ডিলার</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800">SaaS</span>
                    </div>
                    <div class="text-[11px] font-medium text-emerald-700">বাংলাদেশ এগ্রো ডিলারশিপ ম্যানেজমেন্ট</div>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-gray-700">
                <a href="{{ route('home') }}" class="text-emerald-600 hover:text-emerald-700 transition">হোম</a>
                <a href="#features" class="hover:text-emerald-600 transition">মূল সুবিধাসমূহ</a>
                <a href="#inventory" class="hover:text-emerald-600 transition">সার স্টক ও কোটা</a>
                <a href="#ledger" class="hover:text-emerald-600 transition">কৃষকের বাকি খাতা</a>
                <a href="#pricing" class="hover:text-emerald-600 transition">প্যাকেজ ও ফি</a>
                <a href="#testimonials" class="hover:text-emerald-600 transition">ডিলারদের মতামত</a>
                <a href="#faq" class="hover:text-emerald-600 transition">জিজ্ঞাসা</a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                        লগইন করুন
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md hover:shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
                        <span>ফ্রি রেজিস্ট্রেশন</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 00-1 1m-6 0h6"/></svg>
                        <span>আমার ড্যাশবোর্ড</span>
                    </a>
                @endguest
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="lg:hidden flex items-center">
                <button @click="mobileNav = ! mobileNav" type="button" class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileNav">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileNav" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileNav" x-transition class="lg:hidden py-4 border-t border-gray-100 bg-white" style="display: none;">
            <div class="flex flex-col space-y-3 px-2 text-sm font-semibold text-gray-700">
                <a @click="mobileNav = false" href="{{ route('home') }}" class="px-3 py-2 rounded-lg bg-emerald-50 text-emerald-700">হোম</a>
                <a @click="mobileNav = false" href="#features" class="px-3 py-2 rounded-lg hover:bg-gray-50">মূল সুবিধাসমূহ</a>
                <a @click="mobileNav = false" href="#inventory" class="px-3 py-2 rounded-lg hover:bg-gray-50">সার স্টক ও কোটা</a>
                <a @click="mobileNav = false" href="#ledger" class="px-3 py-2 rounded-lg hover:bg-gray-50">কৃষকের বাকি খাতা</a>
                <a @click="mobileNav = false" href="#pricing" class="px-3 py-2 rounded-lg hover:bg-gray-50">প্যাকেজ ও ফি</a>
                <a @click="mobileNav = false" href="#testimonials" class="px-3 py-2 rounded-lg hover:bg-gray-50">ডিলারদের মতামত</a>
                <a @click="mobileNav = false" href="#faq" class="px-3 py-2 rounded-lg hover:bg-gray-50">জিজ্ঞাসা</a>

                <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-lg border border-gray-200 text-gray-800 font-semibold">লগইন করুন</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-lg bg-emerald-600 text-white font-bold">ফ্রি ট্রায়াল শুরু করুন</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-lg bg-emerald-600 text-white font-bold">ড্যাশবোর্ডে প্রবেশ করুন</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</header>
