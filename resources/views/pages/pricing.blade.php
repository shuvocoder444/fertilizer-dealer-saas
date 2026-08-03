@extends('layouts.frontend')

@section('title', 'Pricing Plans - FertilizerSaaS')

@section('content')
<div class="bg-slate-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wider">Simple & Transparent</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Choose the right plan for your shop</h1>
            <p class="text-slate-600 mt-4 text-lg">No hidden charges. Upgrade or cancel your subscription at any time.</p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">

            <!-- Basic Plan -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Starter Plan</h3>
                    <p class="text-slate-500 text-sm mt-1">Best for small fertilizer shops.</p>
                    <div class="my-6">
                        <span class="text-4xl font-extrabold text-slate-900">৳ 999</span>
                        <span class="text-slate-500">/ month</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-2">✓ Single Shop / Counter</li>
                        <li class="flex items-center gap-2">✓ Up to 500 Inventory Items</li>
                        <li class="flex items-center gap-2">✓ POS Invoicing & Print</li>
                        <li class="flex items-center gap-2">✓ Basic Sales Reports</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="mt-8 block text-center py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl transition">Start Basic</a>
            </div>

            <!-- Pro Plan (Popular) -->
            <div class="bg-white p-8 rounded-2xl border-2 border-emerald-500 shadow-xl relative flex flex-col justify-between">
                <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Most Popular</span>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Business Pro</h3>
                    <p class="text-slate-500 text-sm mt-1">Perfect for growing dealership shops.</p>
                    <div class="my-6">
                        <span class="text-4xl font-extrabold text-slate-900">৳ 1,999</span>
                        <span class="text-slate-500">/ month</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-2">✓ Unlimited Inventory Items</li>
                        <li class="flex items-center gap-2">✓ Farmer Due Ledger (বাকির খাতা)</li>
                        <li class="flex items-center gap-2">✓ SMS Reminders for Farmers</li>
                        <li class="flex items-center gap-2">✓ Profit & Loss Dashboard</li>
                        <li class="flex items-center gap-2">✓ Priority Phone Support</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="mt-8 block text-center py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow transition">Get Pro Plan</a>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Multi-Branch</h3>
                    <p class="text-slate-500 text-sm mt-1">For large distributors & multiple Godowns.</p>
                    <div class="my-6">
                        <span class="text-4xl font-extrabold text-slate-900">৳ 3,999</span>
                        <span class="text-slate-500">/ month</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-2">✓ Everything in Pro</li>
                        <li class="flex items-center gap-2">✓ Multi-Godown Stock Transfer</li>
                        <li class="flex items-center gap-2">✓ Custom Govt. Report Generator</li>
                        <li class="flex items-center gap-2">✓ Multi-User Staff Accounts</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="mt-8 block text-center py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl transition">Contact Sales</a>
            </div>

        </div>

    </div>
</div>
@endsection
