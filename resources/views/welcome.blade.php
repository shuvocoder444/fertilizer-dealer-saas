@extends('layouts.frontend')

@section('title', 'Smart Management for Fertilizer Dealers')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-b from-slate-900 to-slate-800 text-white py-20 lg:py-28 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold uppercase tracking-wider rounded-full inline-block mb-4">
            Next-Gen Fertilizer Management
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6">
            Smart Solutions for Your <br class="hidden sm:inline">
            <span class="text-emerald-400">Fertilizer Dealership</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-300 max-w-3xl mx-auto mb-8 leading-relaxed">
            Manage inventory, tracking sales, automate billing, and build strong relationships with farm clients—all from a single, powerful platform.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-emerald-500/25 transition-all text-sm md:text-base">
                Start Free Trial
            </a>
            <a href="#features" class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold rounded-lg transition-all text-sm md:text-base">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- Features Grid Section -->
<section id="features" class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-3">Designed specifically for Dealers</h2>
            <p class="text-slate-600">All the tools you need to run your Fertilizer business effortlessly.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 bg-slate-50 border border-slate-100 rounded-2xl hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold mb-5">
                    📦
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Inventory Control</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Real-time stock tracking for urea, DAP, MOP, and organic fertilizers with low-stock alerts.</p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 bg-slate-50 border border-slate-100 rounded-2xl hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold mb-5">
                    🧾
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Instant Invoicing</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Generate digital receipts and manage due balances for farmers and sub-dealers easily.</p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 bg-slate-50 border border-slate-100 rounded-2xl hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold mb-5">
                    📊
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Analytics & Insights</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Detailed profit/loss reports, seasonal sales trends, and smart business forecasting.</p>
            </div>
        </div>
    </div>
</section>
@endsection
