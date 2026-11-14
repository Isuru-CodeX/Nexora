<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.forget-password.create.page-title')
    </x-slot>

    <!-- Main Auth Portal Wrapper -->
    <div class="relative flex min-h-screen w-full items-center justify-center overflow-x-hidden px-4 py-8 sm:px-6 lg:px-8">
        <!-- Ambient Glowing Aura Orbs -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="nexora-orb absolute -left-32 -top-32 h-[420px] w-[420px] rounded-full bg-[#01C7F4]/20 blur-[110px] dark:bg-[#01C7F4]/15"></div>
            <div class="nexora-orb-delayed absolute -bottom-36 -right-36 h-[500px] w-[500px] rounded-full bg-[#D803B3]/20 blur-[130px] dark:bg-[#D803B3]/15"></div>
            <div class="absolute left-1/2 top-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#5A4DB9]/15 blur-[120px] dark:bg-[#5A4DB9]/20"></div>
            <!-- Tech Grid Particle Texture -->
            <div class="absolute inset-0 bg-[radial-gradient(#5A4DB9_1px,transparent_1px)] [background-size:28px_28px] opacity-15 dark:opacity-25"></div>
        </div>

        <div class="nexora-animate-in relative z-10 w-full max-w-6xl">
            <!-- Responsive Grid: Showcase Banner (Left) + Glassmorphic Card (Right) -->
            <div class="grid grid-cols-1 items-stretch gap-6 lg:grid-cols-12 lg:gap-8">

                <!-- LEFT COLUMN: Interactive Animated Security Showcase Banner (Visible on lg+) -->
                <div class="nexora-showcase-card relative hidden flex-col justify-between overflow-hidden rounded-3xl p-8 lg:col-span-7 lg:flex lg:p-10">
                    <!-- Top Multi-stop Gradient Accent Bar -->
                    <div class="nexora-gradient-bar absolute left-0 right-0 top-0 h-1.5 w-full"></div>

                    <!-- Top Telemetry Header -->
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/10 px-3.5 py-1 text-xs font-semibold text-cyan-600 dark:border-cyan-400/30 dark:bg-cyan-400/10 dark:text-cyan-400">
                            <span class="nexora-pulse-dot h-2 w-2 rounded-full bg-cyan-500 shadow-[0_0_8px_#01C7F4]"></span>
                            <span>Cryptographic Vault Active</span>
                        </div>

                        <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase dark:text-gray-500">
                            Token Verification Protocol
                        </span>
                    </div>

                    <!-- Main Hero Centerpiece -->
                    <div class="my-auto flex flex-col items-center py-6 text-center lg:items-start lg:text-left">
                        <!-- Headline -->
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-[40px] lg:leading-[1.18] dark:text-white">
                            Secure Account <br />
                            <span class="nexora-gradient-text">Recovery & Verification</span>
                        </h1>

                        <p class="mt-4 max-w-lg text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            Lost your credentials? Nexora utilizes time-sensitive cryptographic tokens and zero-knowledge verification to restore your administrative access without compromising enterprise data.
                        </p>

                        <!-- Centered Animated Security Orbit & Floating Badges -->
                        <div class="relative my-8 flex h-64 w-full max-w-md items-center justify-center self-center overflow-visible">
                            <!-- Glowing Ambient Halo -->
                            <div class="absolute h-52 w-52 rounded-full bg-gradient-to-tr from-[#01C7F4]/20 via-[#5A4DB9]/30 to-[#D803B3]/20 blur-2xl"></div>

                            <!-- Outer Planetary Dashed Orbit Ring (Clockwise) -->
                            <div class="nexora-orbit-cw absolute h-52 w-52 rounded-full border border-dashed border-[#01C7F4]/40">
                                <span class="absolute -top-1 left-1/2 h-2.5 w-2.5 -translate-x-1/2 rounded-full bg-[#01C7F4] shadow-[0_0_10px_#01C7F4]"></span>
                            </div>

                            <!-- Middle Counter-Clockwise Ring -->
                            <div class="nexora-orbit-ccw absolute h-40 w-40 rounded-full border border-dashed border-[#D803B3]/45">
                                <span class="absolute -bottom-1 left-1/2 h-2.5 w-2.5 -translate-x-1/2 rounded-full bg-[#D803B3] shadow-[0_0_10px_#D803B3]"></span>
                            </div>

                            <!-- Inner Tech Orbit Ring -->
                            <div class="nexora-orbit-cw absolute h-28 w-28 rounded-full border border-[#5A4DB9]/50">
                                <span class="absolute top-1/2 -right-1 h-2 w-2 -translate-y-1/2 rounded-full bg-[#2590D6]"></span>
                            </div>

                            <!-- Central Floating Shield Emblem -->
                            <div class="relative z-10 flex h-20 w-20 items-center justify-center rounded-2xl border border-white/50 bg-gradient-to-br from-white/95 to-white/80 p-3 shadow-2xl backdrop-blur-md transition-transform duration-300 hover:scale-105 dark:border-white/10 dark:from-gray-800/95 dark:to-gray-900/90">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-tr from-[#5A4DB9] via-[#9E24B7] to-[#D803B3] text-white shadow-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                            </div>

                            <!-- Floating Security Chip 1: Cryptographic Hashes (Top Left) -->
                            <div class="nexora-float-card absolute -left-4 top-2 z-20 flex items-center gap-3 rounded-2xl border border-gray-200/90 bg-white/95 px-3.5 py-2.5 shadow-xl backdrop-blur-md dark:border-gray-700/80 dark:bg-gray-800/95">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-[#01C7F4] to-[#2590D6] text-white shadow-md">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-[10.5px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Token Protocol</div>
                                    <div class="text-xs font-bold text-gray-900 dark:text-white">SHA-256 One-Time Signature</div>
                                </div>
                            </div>

                            <!-- Floating Security Chip 2: Encrypted Dispatch (Bottom Right) -->
                            <div class="nexora-float-card-delayed absolute -right-4 bottom-2 z-20 flex items-center gap-3 rounded-2xl border border-gray-200/90 bg-white/95 px-3.5 py-2.5 shadow-xl backdrop-blur-md dark:border-gray-700/80 dark:bg-gray-800/95">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-[#5A4DB9] to-[#D803B3] text-white shadow-md">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-left">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10.5px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Direct Dispatch</span>
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_#10B981]"></span>
                                    </div>
                                    <div class="text-xs font-bold text-gray-900 dark:text-white">Outbound SMTP TLS Relay</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Three Security Pillars -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-200/80 pt-5 dark:border-gray-800/80">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Rate-Limited</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Anti-enumeration shield</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Auto-Expiring</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">60-minute token TTL</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Audit Logged</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Tamper-evident trail</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Glassmorphic Password Recovery Card -->
                <div class="nexora-glass-card relative flex flex-col justify-between overflow-hidden rounded-3xl p-6 sm:p-8 lg:col-span-5 lg:p-10">
                    <!-- Top Multi-stop Gradient Accent Bar -->
                    <div class="nexora-gradient-bar absolute left-0 right-0 top-0 h-1.5 w-full"></div>

                    <!-- Card Header: Back Link, Logo & Title -->
                    <div>
                        <div class="flex items-center justify-between">
                            <!-- Back to Sign In Link -->
                            <a
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-brandColor transition-colors hover:opacity-85"
                                href="{{ route('admin.session.create') }}"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                <span>@lang('admin::app.users.forget-password.create.sign-in-link')</span>
                            </a>

                            <!-- Official Nexora Logo -->
                            @if ($logo = core()->getConfigData('general.general.admin_logo.logo_image'))
                                <img
                                    class="h-9 w-auto object-contain"
                                    src="{{ Storage::url($logo) }}"
                                    alt="{{ config('app.name') }}"
                                />
                            @else
                                <img
                                    class="h-9 w-auto"
                                    src="{{ request()->cookie('dark_mode') ? vite()->asset('images/dark-logo.svg') : vite()->asset('images/logo.svg') }}"
                                    data-nexora-logo="forgot-password"
                                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                                    alt="{{ config('app.name') }}"
                                />
                            @endif
                        </div>

                        <!-- Mobile Compact Graphic Header (Displayed only on smaller screens) -->
                        <div class="mt-6 flex items-center gap-3 rounded-2xl border border-gray-200/70 bg-gradient-to-r from-cyan-500/5 via-indigo-500/5 to-pink-500/5 p-3 lg:hidden dark:border-gray-800">
                            <div class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white shadow-sm dark:bg-gray-800">
                                <img
                                    src="{{ asset('images/nexora-icon.png') }}"
                                    alt="Nexora Icon"
                                    class="h-7 w-7 object-contain"
                                />
                            </div>
                            <div class="min-w-0 flex-1 text-left">
                                <div class="text-xs font-bold text-gray-900 dark:text-white">Account Recovery</div>
                                <div class="truncate text-[11px] text-gray-500 dark:text-gray-400">Encrypted Token Verification</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                @lang('admin::app.users.forget-password.create.title')
                            </h2>
                            <p class="mt-1.5 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                                Enter your registered email address below and we'll dispatch an encrypted recovery link.
                            </p>
                        </div>
                    </div>

                    <!-- Form Controls -->
                    <div class="my-6">
                        {!! view_render_event('admin.sessions.forgor_password.form_controls.before') !!}

                        <!-- Forget Password Form -->
                        <x-admin::form :action="route('admin.forgot_password.store')" class="flex flex-col gap-5">
                            <!-- Registered Email -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.users.forget-password.create.email')
                                </x-admin::form.control-group.label>

                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 flex items-center text-gray-400 ltr:left-3 rtl:right-3">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>

                                    <x-admin::form.control-group.control
                                        type="email"
                                        class="w-full !rounded-xl !py-2.5 ltr:!pl-10 rtl:!pr-10"
                                        id="email"
                                        name="email"
                                        rules="required|email"
                                        :value="old('email')"
                                        :label="trans('admin::app.users.forget-password.create.email')"
                                        :placeholder="trans('admin::app.users.forget-password.create.email')"
                                    />
                                </div>

                                <x-admin::form.control-group.error control-name="email" />
                            </x-admin::form.control-group>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="primary-button group flex w-full items-center justify-center gap-2 !rounded-xl !py-3 text-sm font-bold shadow-lg"
                            >
                                <svg class="h-4 w-4 transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>@lang('admin::app.users.forget-password.create.submit-btn')</span>
                            </button>
                        </x-admin::form>

                        {!! view_render_event('admin.sessions.forgor_password.form_controls.after') !!}
                    </div>

                    <!-- Card Footer: Powered by Nexora -->
                    <div class="border-t border-gray-200/70 pt-4 text-center dark:border-gray-800/70">
                        <div class="text-xs font-normal text-gray-500 dark:text-gray-400">
                            @lang('admin::app.components.layouts.powered-by.description', [
                                'krayin' => '<span class="nexora-gradient-text font-bold">Nexora</span>',
                                'webkul' => '<span class="font-semibold text-gray-700 dark:text-gray-200">Nexora Community</span>',
                            ])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin::layouts.anonymous>
