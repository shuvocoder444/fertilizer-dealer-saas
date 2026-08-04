<header class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    F
                </div>
                <div>
                    <div class="text-lg font-bold text-slate-900">FertilizerSaaS</div>
                    <div class="text-xs text-slate-500">Smart Dealer Platform</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Home</a>
                <a href="{{ route('features') }}" class="hover:text-emerald-600 transition-colors">Features</a>
                <a href="{{ route('about') }}" class="hover:text-emerald-600 transition-colors">About</a>
                <a href="{{ route('pricing') }}" class="hover:text-emerald-600 transition-colors">Pricing</a>
            </nav>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-emerald-600 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                        Register
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-700 hover:text-emerald-600 transition-colors">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm font-semibold text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</header>
