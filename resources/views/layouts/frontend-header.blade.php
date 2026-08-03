<header class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="{{ route('home') }}"
               hx-get="{{ route('home') }}"
               hx-target="#main-content"
               hx-swap="innerHTML"
               hx-push-url="true"
               class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-sm">
                    F
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">Fertilizer<span class="text-emerald-600">SaaS</span></span>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                   hx-get="{{ route('home') }}"
                   hx-target="#main-content"
                   hx-swap="innerHTML"
                   hx-push-url="true"
                   class="text-slate-700 font-medium hover:text-emerald-600 transition-colors">
                    Home
                </a>

                <a href="{{ route('features') }}"
                   hx-get="{{ route('features') }}"
                   hx-target="#main-content"
                   hx-swap="innerHTML"
                   hx-push-url="true"
                   class="text-slate-600 font-medium hover:text-emerald-600 transition-colors">
                    Features
                </a>

                <a href="{{ route('about') }}"
                   hx-get="{{ route('about') }}"
                   hx-target="#main-content"
                   hx-swap="innerHTML"
                   hx-push-url="true"
                   class="text-slate-600 font-medium hover:text-emerald-600 transition-colors">
                    About Us
                </a>

                <a href="{{ route('pricing') }}"
                   hx-get="{{ route('pricing') }}"
                   hx-target="#main-content"
                   hx-swap="innerHTML"
                   hx-push-url="true"
                   class="text-slate-600 font-medium hover:text-emerald-600 transition-colors">
                    Pricing
                </a>
            </nav>

            <!-- Auth Links (Auth routes reload normally without HTMX for security) -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-emerald-600 transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-all">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </div>
</header>
