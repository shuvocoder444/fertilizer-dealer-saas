<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-between bg-slate-50 font-sans antialiased">

        <!-- Header Include -->
        @include('layouts.frontend-header')

        <!-- Register Form Section -->
        <div class="flex-grow flex flex-col justify-center items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="w-full max-w-2xl space-y-6">

                <!-- Title & Subtitle -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 mb-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create your account</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Get started with your <span class="font-semibold text-emerald-600">FertilizerSaaS</span> dealership portal.
                    </p>
                </div>

                <!-- Modern Wide Card Container -->
                <div class="bg-white py-8 px-8 sm:px-12 shadow-xl shadow-slate-200/60 rounded-2xl border border-slate-100">

                    <x-validation-errors class="mb-6" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- 2-Column Grid for Name & Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                       placeholder="e.g. John Doe"
                                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                       placeholder="you@example.com"
                                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                            </div>
                        </div>

                        <!-- 2-Column Grid for Password & Confirm Password -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 transition duration-150 ease-in-out" />
                            </div>
                        </div>

                        <!-- Account Role Selection Dropdown -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Select Account Type</label>
                            <select id="role" name="role" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 transition duration-150 ease-in-out bg-white">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role...</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="team" {{ old('role') == 'team' ? 'selected' : '' }}>Team Member</option>
                                <option value="dealer" {{ old('role') == 'dealer' ? 'selected' : '' }}>Dealer</option>
                            </select>
                        </div>

                        <!-- Terms & Privacy -->
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="pt-1">
                                <label for="terms" class="flex items-start">
                                    <input type="checkbox" name="terms" id="terms" required
                                           class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4 mt-0.5">
                                    <span class="ms-2 text-xs text-slate-600 leading-relaxed">
                                        I agree to the
                                        <a target="_blank" href="{{ route('terms.show') }}" class="font-medium text-emerald-600 hover:text-emerald-500 underline">Terms of Service</a>
                                        and
                                        <a target="_blank" href="{{ route('policy.show') }}" class="font-medium text-emerald-600 hover:text-emerald-500 underline">Privacy Policy</a>
                                    </span>
                                </label>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                                Create Account
                            </button>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center border-t border-slate-100 pt-5">
                        <p class="text-sm text-slate-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                                Sign in instead
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
