@extends('layouts.frontend')

@section('title', 'About Us - FertilizerSaaS')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
            <div>
                <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wider">Our Story</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Empowering Fertilizer Dealers with Modern Technology</h1>
                <p class="text-slate-600 mt-4 leading-relaxed">
                    FertilizerSaaS was built to solve the complex inventory and credit challenges faced by agricultural fertilizer and pesticide dealers. Our mission is to digitize rural agritech businesses with simple, robust, and accessible cloud tools.
                </p>
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow hover:bg-emerald-700 transition">Get Started</a>
                    <a href="#contact" class="px-6 py-3 border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition">Contact Us</a>
                </div>
            </div>

            <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-8 sm:p-12 text-center">
                <div class="text-5xl mb-4">🌾</div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Built for Agriculture</h3>
                <p class="text-slate-600 text-sm">Simplifying supply chains for over 500+ fertilizer dealers across the region.</p>
            </div>
        </div>

        <!-- Stats Counter -->
        <div class="bg-slate-900 rounded-3xl py-12 px-6 text-white grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">500+</div>
                <div class="text-slate-400 text-sm mt-1">Active Dealers</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">৳ 10M+</div>
                <div class="text-slate-400 text-sm mt-1">Monthly Invoices</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">99.9%</div>
                <div class="text-slate-400 text-sm mt-1">Uptime Guaranteed</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">24/7</div>
                <div class="text-slate-400 text-sm mt-1">Dedicated Support</div>
            </div>
        </div>

    </div>
</div>
@endsection
