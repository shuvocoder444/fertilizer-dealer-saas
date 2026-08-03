@extends('layouts.frontend')

@section('title', 'Features - FertilizerSaaS')

@section('content')
<div class="bg-slate-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wider">Powerful Tools</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Everything you need to manage your Fertilizer Dealership</h1>
            <p class="text-slate-600 mt-4 text-lg">Streamline inventory, tracking, sales, and supplier management with automated SaaS features.</p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">📦</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Smart Inventory Control</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Real-time stock tracking for Urea, DAP, MoP, and micro-nutrients with instant low-stock alerts.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">🧾</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">POS & Automated Billing</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Fast POS checkout for farmers with printed invoices and automatic SMS receipt options.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">👨‍🌾</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Farmer Due Ledger</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Track credit (বাকির খাতা), payments, and due limits per farmer with automated due reminder SMS.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">📈</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Profit & Loss Analytics</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Get detailed seasonal reports, net profit calculations, and daily cash flow summaries.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">🏢</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Multi-Store Management</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Manage multiple godowns or branch shops under one unified SaaS account effortlessly.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6">🔒</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Govt. Quota Compliance</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Maintain government-requisited dealer reports and stock registers with a single click.</p>
            </div>
        </div>

    </div>
</div>
@endsection
