@extends('layouts.frontend')

@section('title', 'সার ডিলার SaaS — বাংলাদেশের সার, বালাইনাশক ও বীজ ডিলারশিপ ম্যানেজমেন্ট সফটওয়্যার')

@section('content')

<!-- ========================================================================= -->
<!-- 1. HERO SECTION                                                           -->
<!-- ========================================================================= -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-emerald-950 text-white pt-16 pb-24 lg:pt-20 lg:pb-32 overflow-hidden">
    <!-- Background Grid & Glow Effect -->
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-green-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Hero Left: Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Trust Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>🌾 বিসিআইসি ও বিএডিসি সার ডিলারদের জন্য ১০০% উপযোগী</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black tracking-tight leading-[1.25] text-white">
                    খাতা-কলমের দিনের অবসান — <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-green-300 to-teal-300">
                        সারের মজুত ও কৃষকের বাকি খাতা
                    </span> <br>
                    এবার একটি ডিজিটাল সফটওয়্যারে!
                </h1>

                <!-- Subheadline -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    ইউরিয়া, টিএসপি, ডিএপি ও পটাশ সারের বস্তা প্রতি লাইভ স্টক ট্র্যাকিং, কৃষকের ডিজিটাল বাকি মেমো, এসএমএস ইনভয়েস এবং সরকারি সার কোটার নির্ভুল হিসাব। বোরো ও আমন মৌসুমে সারের দোকানে এনে দিন ১০০% স্বচ্ছতা ও মানসিক শান্তি।
                </p>

                <!-- Call To Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl shadow-xl hover:shadow-emerald-500/25 transition transform hover:-translate-y-0.5 text-base">
                        <span>১৪ দিনের ফ্রি ট্রায়াল শুরু করুন</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#demo-preview" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 bg-slate-800/80 hover:bg-slate-800 text-slate-200 border border-slate-700 font-semibold rounded-xl transition text-base backdrop-blur-sm">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>সফটওয়্যার ডেমো দেখুন</span>
                    </a>
                </div>

                <!-- Trust Metrics -->
                <div class="pt-6 border-t border-slate-800/80 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0 text-center lg:text-left">
                    <div>
                        <div class="text-2xl font-black text-white">৫০০+</div>
                        <div class="text-xs text-slate-400 mt-0.5">নিবন্ধিত ডিলার</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-emerald-400">৬৪ জেলায়</div>
                        <div class="text-xs text-slate-400 mt-0.5">সরাসরি ব্যবহৃত</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-white">৳৫০ কোটি+</div>
                        <div class="text-xs text-slate-400 mt-0.5">হিসাবভুক্ত লেনদেন</div>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Realistic Live Dashboard Mockup -->
            <div class="lg:col-span-5 relative" id="demo-preview">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Outer Decorative Rings -->
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500 to-green-500 rounded-2xl blur-lg opacity-30"></div>

                    <!-- Software Window Mockup -->
                    <div class="relative bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden text-slate-200">
                        <!-- Window Titlebar -->
                        <div class="bg-slate-950/90 px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                                <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
                                <span class="text-xs text-slate-400 font-medium ms-2">মেসার্স ভাই ভাই ফার্টিলাইজার্স (বগুড়া)</span>
                            </div>
                            <span class="text-[11px] px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">লাইভ স্টক</span>
                        </div>

                        <!-- Card Contents -->
                        <div class="p-5 space-y-4 text-xs">
                            <!-- Top Stats Row -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-800/80 p-3.5 rounded-xl border border-slate-700/60">
                                    <div class="text-slate-400 font-medium">আজকের মোট বিক্রয়</div>
                                    <div class="text-xl font-black text-emerald-400 mt-1">৳ ৪৪,০০০</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">ক্যাশ: ৳৩৪,০০০ | বাকি: ৳১০,০০০</div>
                                </div>
                                <div class="bg-slate-800/80 p-3.5 rounded-xl border border-slate-700/60">
                                    <div class="text-slate-400 font-medium">কৃষকদের মোট বাকি খাতা</div>
                                    <div class="text-xl font-black text-red-400 mt-1">৳ ৫১,৭০০</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">৪ জন কৃষকের হালনাগাদ</div>
                                </div>
                            </div>

                            <!-- Live Stock Bags Mini-Table -->
                            <div class="bg-slate-950/60 rounded-xl p-3 border border-slate-800">
                                <div class="font-bold text-slate-300 mb-2 flex items-center justify-between">
                                    <span>গুদামের সারের বস্তা লাইভ স্থিতি</span>
                                    <span class="text-[10px] text-emerald-400">রিয়েল-টাইম</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between bg-slate-900/80 p-2 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                            <span class="font-semibold text-white">ইউরিয়া সার (বিসিআইসি ৫০ কেজি)</span>
                                        </div>
                                        <span class="font-bold text-emerald-300 bg-emerald-950 px-2 py-0.5 rounded border border-emerald-800">৪৫০ বস্তা</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-slate-900/80 p-2 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                            <span class="font-semibold text-white">ডিএপি সার (বিএডিসি ৫০ কেজি)</span>
                                        </div>
                                        <span class="font-bold text-blue-300 bg-blue-950 px-2 py-0.5 rounded border border-blue-800">২৮০ বস্তা</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-slate-900/80 p-2 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                            <span class="font-semibold text-white">এমওপি পটাশ সার (৫০ কেজি)</span>
                                        </div>
                                        <span class="font-bold text-amber-300 bg-amber-950 px-2 py-0.5 rounded border border-amber-800">২৫ বস্তা (কম স্টক)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Instant Sale simulation -->
                            <div class="bg-emerald-950/40 border border-emerald-800/60 p-3 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-700/60 flex items-center justify-center text-white">
                                        ✓
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-[11px]">চালান নং INV-2026-001 তৈরি সম্পন্ন</div>
                                        <div class="text-[10px] text-emerald-300">মোঃ রফিকুল ইসলাম (কৃষক) — এসএমএস প্রেরিত</div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-white bg-emerald-600 px-2.5 py-1 rounded">৳ ১৩,৩০০</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 2. PAIN POINTS VS SOLUTIONS (আগে বনাম এখন)                                -->
<!-- ========================================================================= -->
<section class="py-16 lg:py-24 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                বাস্তব সমস্যা ও কার্যকর সমাধান
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3 tracking-tight">
                সার ব্যবসায় খাতা-কলমের দিন শেষ, এবার প্রযুক্তির জয়
            </h2>
            <p class="text-gray-600 text-base mt-3">
                বছরের পর বছর ধরে সারের ডিলাররা যে সমস্যাগুলোতে সবচেয়ে বেশি ক্ষতিগ্রস্ত হচ্ছিলেন, তার পূর্ণাঙ্গ সমাধান এখন একটি সফটওয়্যারে।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- Pain: Traditional Way -->
            <div class="bg-red-50/60 border border-red-200/80 rounded-2xl p-6 sm:p-8 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg">
                        ✕
                    </div>
                    <h3 class="text-xl font-bold text-red-950">আগে খাতা-কলমের জটিলতায় যা হতো:</h3>
                </div>
                <ul class="space-y-4 text-sm text-gray-700">
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold shrink-0 mt-0.5">•</span>
                        <span><strong>খাতা ছিঁড়ে যাওয়া বা ভিজে যাওয়ার ভয়:</strong> বর্ষা বা ফসল মৌসুমে লাল খাতা নষ্ট হলে কৃষকের লাখ টাকার বাকি হিসাব চিরতরে হারিয়ে যেত।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold shrink-0 mt-0.5">•</span>
                        <span><strong>মৌসুমের ভিড়ে মেমো লেখার সময় নেই:</strong> শত শত কৃষক যখন দোকানে ভিড় করত, দ্রুত হিসাব মেলাতে গিয়ে সারের বস্তার হিসাব এলোমেলো হয়ে যেত।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold shrink-0 mt-0.5">•</span>
                        <span><strong>হঠাৎ সারের মজুদ শেষ:</strong> গুদামে কত বস্তা ইউরিয়া বা পটাশ আছে সঠিক তথ্য না থাকায় কৃষকদের ফিরিয়ে দিতে হতো এবং ব্যবসায় ক্ষতি হতো।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold shrink-0 mt-0.5">•</span>
                        <span><strong>কৃষি অফিসের অডিটে ভোগান্তি:</strong> উপজেলা কৃষি কর্মকর্তা সারের রেজিস্টার খাতা দেখতে চাইলে ঘণ্টার পর ঘণ্টা হিসাব খুঁজতে হতো।</span>
                    </li>
                </ul>
            </div>

            <!-- Gain: Fertilizer SaaS Way -->
            <div class="bg-emerald-50/70 border border-emerald-200 rounded-2xl p-6 sm:p-8 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                        ✓
                    </div>
                    <h3 class="text-xl font-bold text-emerald-950">এখন সার ডিলার SaaS ব্যবহারে যা পাচ্ছেন:</h3>
                </div>
                <ul class="space-y-4 text-sm text-gray-700">
                    <li class="flex items-start gap-3">
                        <span class="text-emerald-600 font-bold shrink-0 mt-0.5">✔</span>
                        <span><strong>ক্লাউডে ১০০% সুরক্ষিত কৃষকের খাতা:</strong> ফোন হারালেও বা কম্পিউটার নষ্ট হলেও এক ক্লিকে ফিরে পাবেন আপনার প্রতিটি টাকার হিসাব।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-emerald-600 font-bold shrink-0 mt-0.5">✔</span>
                        <span><strong>৫ সেকেন্ডে ক্যাশ/বাকি মেমো ও প্রিন্ট:</strong> যেকোনো থার্মাল বা সাধারণ প্রিন্টারে মুহূর্তে মেমো প্রিন্ট এবং কৃষকের মোবাইলে অটো এসএমএস।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-emerald-600 font-bold shrink-0 mt-0.5">✔</span>
                        <span><strong>বস্তা প্রতি লাইভ স্টক ও সংকট অ্যালার্ট:</strong> নির্দিষ্ট সীমার নিচে বস্তা নামলেই ড্যাশবোর্ডে লাল সতর্কতা দিয়ে নতুন বরাদ্দ নিতে সাহায্য করে।</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-emerald-600 font-bold shrink-0 mt-0.5">✔</span>
                        <span><strong>১ ক্লিকে বিসিআইসি সরকারি রিপোর্ট:</strong> কত সার এসেছে, কত বিক্রি হয়েছে এবং কত মজুত আছে—এক ক্লিকেই সরকারি অডিট রিপোর্ট তৈরি।</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 3. CORE FEATURES SHOWCASE                                                 -->
<!-- ========================================================================= -->
<section id="features" class="py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-100/60 px-3 py-1 rounded-full border border-emerald-200">
                শক্তিশালী ফিচারসমূহ
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3 tracking-tight">
                সার ব্যবসা পরিচালনার সকল আধুনিক প্রযুক্তি এক ছাদের নিচে
            </h2>
            <p class="text-gray-600 text-base mt-3">
                বাংলাদেশের কৃষি বাস্তবতায় সার ও কীটনাশক ডিলারদের প্রতিদিনের কাজের গতি শতগুণ বাড়াতে বিশেষভাবে ডিজাইন করা।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Feature 1: Fertilizer Stock & Quota -->
            <div id="inventory" class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        🌾
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">সরকারি সার কোটা ও বস্তা ট্র্যাকিং</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        বিসিআইসি ও বিএডিসি থেকে ডিলার কোটায় বরাদ্দকৃত ৫০ কেজি বা ২৫ কেজি বস্তার ইউরিয়া, টিএসপি, ডিএপি ও এমওপি সারের রিয়েল-টাইম গুদাম ব্যালেন্স ট্র্যাকিং।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-emerald-600">
                    <span>বস্তা প্রতি ক্রয় ও বিক্রয় হিসাব</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Feature 2: Customer Due / Credit Ledger -->
            <div id="ledger" class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        📒
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">কৃষকের ডিজিটাল লাল খাতা (Due Ledger)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        কোন কৃষক কোন জমি বা মৌসুমের জন্য কত টাকা বা কত বস্তা সার বাকি নিয়েছেন, আংশিক কত পরিশোধ করেছেন—তার নির্ভুল গ্রাহক খতিয়ান।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-blue-600">
                    <span>১ ক্লিকে বাকি আদায়ের রশিদ</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Feature 3: POS Billing & SMS Invoices -->
            <div class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        🧾
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">কুইক পিওএস মেমো ও এসএমএস চালান</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        ক্যাশ বা বাকিতে সার বিক্রির সাথে সাথে কম্পিউটার বা মোবাইল দিয়ে ডিজিটাল মেমো তৈরি করুন। কৃষকের ফোনে পৌঁছে যাবে স্বয়ংক্রিয় এসএমএস রশিদ।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-amber-600">
                    <span>থার্মাল ও নরমাল প্রিন্টার সাপোর্ট</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Feature 4: Seasonal Stock Alerts & AI Forecast -->
            <div class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        📈
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">মৌসুমি চাহিদা ও কৃত্রিম বুদ্ধিমত্তা পূর্বাভাস</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        আমন, বোরো ও রবি মৌসুমে কোন সারের চাহিদা কখন বাড়বে তার স্মার্ট অ্যালার্ট। কোনো সারের স্টক কমে এলে আগে থেকেই সতর্কতা প্রদান।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-purple-600">
                    <span>সার সংকট প্রতিরোধ ব্যবস্থা</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Feature 5: Multi-Branch & Outlets -->
            <div class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        🏪
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">একাধিক শাখা ও গোডাউন স্থানান্তর</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        আপনার যদি একাধিক বাজারে দোকান বা আলাদা গুদাম থাকে, তবে মূল দোকান থেকে গোডাউনে সার স্থানান্তর ও কর্মচারীদের বিক্রয় আলাদাভাবে মনিটর করুন।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-teal-600">
                    <span>শাখাভিত্তিক লাভ-ক্ষতি প্রতিবেদন</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Feature 6: Mobile Friendly & 100% Secure -->
            <div class="bg-white p-7 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center font-black text-2xl mb-6 group-hover:scale-110 transition transform">
                        📱
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2.5">মোবাইল ও ট্যাবলেট ফ্রেন্ডলি</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        দোকানে কম্পিউটার না থাকলেও সমস্যা নেই। হাতে থাকা যেকোনো অ্যান্ড্রয়েড স্মার্টফোন বা ট্যাব দিয়ে খুব সহজে পুরো সফটওয়্যার পরিচালনা করা যায়।
                    </p>
                </div>
                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center text-xs font-semibold text-rose-600">
                    <span>অটোমেটিক ক্লাউড ব্যাকআপ</span>
                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 4. REAL TESTIMONIALS FROM BANGLADESHI DEALERS                             -->
<!-- ========================================================================= -->
<section id="testimonials" class="py-16 lg:py-24 bg-white border-y border-gray-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                ডিলারদের সন্তুষ্টি
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3 tracking-tight">
                দেশের স্বনামধন্য সার ব্যবসায়ীরা কী বলছেন?
            </h2>
            <p class="text-gray-600 text-base mt-3">
                বগুড়া, দিনাজপুর, রাজশাহী, যশোর ও কুমিল্লার সফল সার ডিলারদের বাস্তব অভিজ্ঞতার কথা।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Testimonial 1 -->
            <div class="bg-gray-50/70 p-7 rounded-2xl border border-gray-200/70 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 mb-4 text-sm">
                        ★★★★★
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed italic">
                        "বোরো মৌসুমে শত শত কৃষক সার নিতে ভিড় করে। আগে খাতা লেখার সময় থাকত না, অনেক সময় বাকি দিয়ে লিখে রাখতে ভুলে যেতাম। এই সফটওয়্যার আসার পর মোবাইল থেকে ৫ সেকেন্ডে মেমো হয়ে যায়, কৃষকের ফোনেও মেসেজ চলে যায়। আমার বাকি আদায় এখন শতভাগ।"
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-gray-200/60 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        শি
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">মোঃ শফিকুল ইসলাম</div>
                        <div class="text-xs text-emerald-700 font-medium">মেসার্স ভাই ভাই ফার্টিলাইজার্স, শেরপুর, বগুড়া</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gray-50/70 p-7 rounded-2xl border border-gray-200/70 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 mb-4 text-sm">
                        ★★★★★
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed italic">
                        "উপজেলা কৃষি অফিসার যখন বিসিআইসি সারের স্টক রেজিস্টার দেখতে চান, আগে সারারাত জেগে হিসাব মেলাতে হতো। এখন এক ক্লিকে প্রিন্ট দিয়ে দিই। গুদামে কত বস্তা ইউরিয়া বা টিএসপি আছে সেটা ফোন খুললেই দেখতে পাই।"
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-gray-200/60 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        কা
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">হাজী মোঃ আবুল কাশেম</div>
                        <div class="text-xs text-blue-700 font-medium">হাজী সার ভান্ডার, দিনাজপুর সদর</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gray-50/70 p-7 rounded-2xl border border-gray-200/70 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 mb-4 text-sm">
                        ★★★★★
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed italic">
                        "আমার মূল বাজারের পাশাপাশি আরো দুইটি সাব-আউটলেট আছে। কর্মচারীরা ঠিকমতো টাকা জমা দিচ্ছে কি না এবং কোন গুদামে কত বস্তা ডিএপি সার আছে তা আমি বাড়ি বসেই সব তদারকি করতে পারছি। সার ব্যবসায়ীদের জন্য এটি এক আশীর্বাদ।"
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-gray-200/60 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-purple-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        মা
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">মাহবুবুর রহমান</div>
                        <div class="text-xs text-purple-700 font-medium">বরেন্দ্র এগ্রো ট্রেডার্স, গোদাগাড়ী, রাজশাহী</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 5. TRANSPARENT PRICING PLANS                                              -->
<!-- ========================================================================= -->
<section id="pricing" class="py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-100/60 px-3 py-1 rounded-full border border-emerald-200">
                সাধ্যের মধ্যে প্যাকেজ
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3 tracking-tight">
                স্বচ্ছ সাবস্ক্রিপশন প্ল্যান — কোনো লুকানো খরচ নেই
            </h2>
            <p class="text-gray-600 text-base mt-3">
                আপনার ব্যবসায়ের আকার অনুযায়ী সেরা প্যাকেজটি বেছে নিন। ১৪ দিনের ফ্রি ট্রায়াল দিয়ে যাচাই করুন।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch max-w-6xl mx-auto">

            <!-- Plan 1: Starter -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm flex flex-col justify-between hover:border-emerald-500 transition">
                <div>
                    <h3 class="font-bold text-xl text-gray-900">স্টার্টার ডিলার</h3>
                    <p class="text-gray-500 text-xs mt-1">একক দোকান ও ছোট ব্যবসায়ীদের জন্য</p>
                    <div class="text-4xl font-black text-gray-900 mt-6">৳ ১,৫০০ <span class="text-sm font-normal text-gray-500">/ মাসিক</span></div>

                    <ul class="space-y-3.5 text-xs text-gray-700 mt-8 border-t border-gray-100 pt-6">
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>১টি শপ / আউটলেট</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>সর্বোচ্চ ৩ জন স্টাফ ইউজার</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>সারের বস্তা অনুযায়ী লাইভ স্টক</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>কৃষকের বাকি খাতা ও কালেকশন রশিদ</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>এসএমএস চালান নোটিফিকেশন</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-8">
                    <a href="{{ route('register') }}" class="w-full block text-center py-3.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl text-sm transition shadow-sm">
                        স্টার্টার ট্রায়াল শুরু করুন
                    </a>
                </div>
            </div>

            <!-- Plan 2: Business Pro (Featured) -->
            <div class="bg-gradient-to-b from-emerald-950 to-slate-900 text-white rounded-3xl p-8 border-2 border-emerald-500 shadow-2xl flex flex-col justify-between relative transform lg:-translate-y-3">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-emerald-500 to-green-400 text-slate-950 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg">
                        সবচেয়ে জনপ্রিয় চয়েস
                    </span>
                </div>

                <div>
                    <h3 class="font-bold text-xl text-white">বিজনেস প্রো (Professional)</h3>
                    <p class="text-emerald-300 text-xs mt-1">মাঝারি ও বিসিআইসি ডিলারদের জন্য সেরা</p>
                    <div class="text-4xl font-black text-white mt-6">৳ ৩,৫০০ <span class="text-sm font-normal text-emerald-300">/ মাসিক</span></div>

                    <ul class="space-y-3.5 text-xs text-emerald-100 mt-8 border-t border-emerald-800/80 pt-6">
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>৩টি আউটলেট বা গোডাউন সাপোর্ট</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>১০ জন স্টাফ ও সেলসম্যান আইডি</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>বিসিআইসি ও বিএডিসি সার কোটা রিপোর্ট</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>এআই সার ডিমান্ড পূর্বাভাস ও অ্যালার্ট</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>আনলিমিটেড ডিজিটাল মেমো ও এসএমএস</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>২৪/৭ ডেডিকেটেড ফোন সাপোর্ট</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-8">
                    <a href="{{ route('register') }}" class="w-full block text-center py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-sm transition shadow-lg">
                        বিজনেস প্রো ট্রায়াল নিন
                    </a>
                </div>
            </div>

            <!-- Plan 3: Enterprise -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm flex flex-col justify-between hover:border-emerald-500 transition">
                <div>
                    <h3 class="font-bold text-xl text-gray-900">এন্টারপ্রাইজ কর্পোরেট</h3>
                    <p class="text-gray-500 text-xs mt-1">বড় হোলসেলার ও আঞ্চলিক ডিলার নেটওয়ার্ক</p>
                    <div class="text-4xl font-black text-gray-900 mt-6">৳ ৭,৫০০ <span class="text-sm font-normal text-gray-500">/ মাসিক</span></div>

                    <ul class="space-y-3.5 text-xs text-gray-700 mt-8 border-t border-gray-100 pt-6">
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>১০+ আউটলেট ও কেন্দ্রীয় গোডাউন</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>৫০ জন স্টাফ ও ম্যানেজার রোলস</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>হোলসেল ও সাব-ডিলার নেটওয়ার্ক পোর্টাল</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>ডেডিকেটেড অন-সাইট ট্রেইনার ও সাপোর্ট</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-emerald-600 font-bold">✔</span>
                            <span>কাস্টম রিপোর্টিং ও এপিআই সুবিধা</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-8">
                    <a href="{{ route('register') }}" class="w-full block text-center py-3.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl text-sm transition shadow-sm">
                        এন্টারপ্রাইজ যোগাযোগ করুন
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 6. FREQUENTLY ASKED QUESTIONS (FAQ)                                       -->
<!-- ========================================================================= -->
<section id="faq" class="py-16 lg:py-24 bg-white border-t border-gray-200/80" x-data="{ active: 1 }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                সাধারণ জিজ্ঞাসা
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-3 tracking-tight">
                আপনার মনে কি কোনো প্রশ্ন আছে?
            </h2>
            <p class="text-gray-500 text-sm mt-2">
                ডিলার ভাইদের বহুল জিজ্ঞাসিত প্রশ্নগুলোর সহজ উত্তর নিচে দেওয়া হলো।
            </p>
        </div>

        <div class="space-y-4">
            <!-- Q1 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button @click="active = active === 1 ? null : 1" class="w-full px-6 py-5 text-left font-bold text-gray-900 flex items-center justify-between bg-gray-50/50 hover:bg-gray-50 transition">
                    <span class="text-base">১. এই সফটওয়্যার চালাতে কি কম্পিউটার থাকা বাধ্যতামূলক?</span>
                    <span class="text-xl text-emerald-600 font-bold" x-text="active === 1 ? '−' : '+'"></span>
                </button>
                <div x-show="active === 1" x-collapse class="px-6 py-4 text-sm text-gray-600 border-t border-gray-100 bg-white leading-relaxed">
                    না, একদমই নয়। দোকানে কম্পিউটার না থাকলেও আপনি আপনার হাতের সাধারণ যেকোনো অ্যান্ড্রয়েড স্মার্টফোন দিয়েও মেমো কাটা, সারের স্টক দেখা ও কৃষকের বাকি খাতা পরিচালনা করতে পারবেন।
                </div>
            </div>

            <!-- Q2 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button @click="active = active === 2 ? null : 2" class="w-full px-6 py-5 text-left font-bold text-gray-900 flex items-center justify-between bg-gray-50/50 hover:bg-gray-50 transition">
                    <span class="text-base">২. দোকানে বিদ্যুৎ বা ইন্টারনেট না থাকলে কি সমস্যা হবে?</span>
                    <span class="text-xl text-emerald-600 font-bold" x-text="active === 2 ? '−' : '+'"></span>
                </button>
                <div x-show="active === 2" x-collapse class="px-6 py-4 text-sm text-gray-600 border-t border-gray-100 bg-white leading-relaxed" style="display: none;">
                    সফটওয়্যারটি মোবাইল ডাটা (2G/3G/4G) দিয়েও অত্যন্ত দ্রুত চলে। তাছাড়া আপনার ফোনের ইন্টারনেট সংযোগ পেলেই সকল ডাটা স্বয়ংক্রিয়ভাবে ক্লাউড সার্ভারে সিঙ্ক হয়ে যায়।
                </div>
            </div>

            <!-- Q3 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button @click="active = active === 3 ? null : 3" class="w-full px-6 py-5 text-left font-bold text-gray-900 flex items-center justify-between bg-gray-50/50 hover:bg-gray-50 transition">
                    <span class="text-base">৩. আমার পুরোনো খাতার বাকি হিসাবগুলো কীভাবে সফটওয়্যারে তুলব?</span>
                    <span class="text-xl text-emerald-600 font-bold" x-text="active === 3 ? '−' : '+'"></span>
                </button>
                <div x-show="active === 3" x-collapse class="px-6 py-4 text-sm text-gray-600 border-t border-gray-100 bg-white leading-relaxed" style="display: none;">
                    আমরা আপনাকে একটি সহজ কাস্টমার এন্ট্রি সুবিধা দেব। সেখানে কৃষকের নাম, মোবাইল নম্বর ও পূর্বের মোট বাকি টাকা লিখে রাখলেই সফটওয়্যার স্বয়ংক্রিয়ভাবে খতিয়ান চালু করে নেবে। আমাদের হেল্পলাইন টিম প্রয়োজনে ডাটা এন্ট্রিতে সহায়তা করে।
                </div>
            </div>

            <!-- Q4 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button @click="active = active === 4 ? null : 4" class="w-full px-6 py-5 text-left font-bold text-gray-900 flex items-center justify-between bg-gray-50/50 hover:bg-gray-50 transition">
                    <span class="text-base">৪. আমার সার দোকানের বিক্রয় ও টাকার তথ্য কি অন্য কেউ দেখতে পারবে?</span>
                    <span class="text-xl text-emerald-600 font-bold" x-text="active === 4 ? '−' : '+'"></span>
                </button>
                <div x-show="active === 4" x-collapse class="px-6 py-4 text-sm text-gray-600 border-t border-gray-100 bg-white leading-relaxed" style="display: none;">
                    কখনোই না। প্রতিটি ডিলারশিপের জন্য আলাদা টেন্যান্ট ডাটাবেজ সুরক্ষায় এনক্রিপ্ট করা থাকে। আপনি এবং আপনার অনুমোদিত স্টাফ ব্যতীত আপনার স্টক ও টাকার তথ্য অন্য কোনো ডিলার বা ব্যক্তি দেখতে পারবে না।
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 7. HIGH IMPACT FINAL CALL TO ACTION (CTA)                                 -->
<!-- ========================================================================= -->
<section class="py-16 lg:py-20 bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
        <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
            আপনার সার ব্যবসাকে আরও আধুনিক ও ঝামেলামুক্ত করতে প্রস্তুত তো?
        </h2>
        <p class="text-emerald-100 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
            আজই ১৪ দিনের ফ্রি ট্রায়াল শুরু করুন। কোনো অগ্রিম ফি নেই, কোনো চুক্তি নেই। ভালো লাগলেই নিয়মিত ব্যবহার করবেন।
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-emerald-900 hover:bg-emerald-50 font-black rounded-xl text-base shadow-xl transition transform hover:scale-105">
                বিনামূল্যে ডিলার অ্যাকাউন্ট খুলুন
            </a>
            <a href="tel:+8801700000000" class="w-full sm:w-auto px-7 py-4 bg-emerald-950/70 hover:bg-emerald-950 text-white border border-emerald-600 font-bold rounded-xl text-base transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>হটলাইনে কল করুন: ০১৭০০-০০০০০০</span>
            </a>
        </div>
    </div>
</section>

@endsection
