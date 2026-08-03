<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-between bg-slate-50 font-sans antialiased">

        <!-- Header Include -->
        @include('layouts.frontend-header')

        <!-- Login Card Section -->
        <div class="flex-grow flex flex-col justify-center items-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-8">

                <!-- Header Icon & Title -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome back</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Sign in to access your <span class="font-semibold text-emerald-600">FertilizerSaaS</span> dashboard.
                    </p>
                </div>

                <!-- Modern Card Container -->
                <div class="bg-white py-8 px-6 shadow-xl shadow-slate-200/60 rounded-2xl border border-slate-100 sm:px-10">

                    <x-validation-errors class="mb-6" />

                    @session('status')
                        <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 font-medium text-sm text-emerald-700">
                            {{ $value }}
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   placeholder="you@example.com"
                                   class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-medium text-emerald-600 hover:text-emerald-500 transition-colors" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember"
                                   class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <label for="remember_me" class="ms-2 block text-sm text-slate-600 select-none">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-1">
                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                                Sign In
                            </button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-6 text-center border-t border-slate-100 pt-5">
                        <p class="text-sm text-slate-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                                Create an account
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Include -->
        @include('layouts.frontend-footer')

    </div>
</x-guest-layout>
