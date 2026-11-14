<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.reset-password.title')
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
                        <div class="inline-flex items-center gap-2 rounded-full border border-violet-500/30 bg-violet-500/10 px-3.5 py-1 text-xs font-semibold text-violet-600 dark:border-violet-400/30 dark:bg-violet-400/10 dark:text-violet-400">
                            <span class="nexora-pulse-dot h-2 w-2 rounded-full bg-violet-500 shadow-[0_0_8px_#8B5CF6]"></span>
                            <span>Credential Provisioning Protocol</span>
                        </div>

                        <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase dark:text-gray-500">
                            Enterprise Key Exchange
                        </span>
                    </div>

                    <!-- Main Hero Centerpiece -->
                    <div class="my-auto flex flex-col items-center py-6 text-center lg:items-start lg:text-left">
                        <!-- Headline -->
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-[40px] lg:leading-[1.18] dark:text-white">
                            Establish New <br />
                            <span class="nexora-gradient-text">Encrypted Credentials</span>
                        </h1>

                        <p class="mt-4 max-w-lg text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            Set up a resilient, high-entropy password to safeguard your administrative workspace, client databases, and automated sales operations.
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

                            <!-- Central Floating Key/Lock Emblem -->
                            <div class="relative z-10 flex h-20 w-20 items-center justify-center rounded-2xl border border-white/50 bg-gradient-to-br from-white/95 to-white/80 p-3 shadow-2xl backdrop-blur-md transition-transform duration-300 hover:scale-105 dark:border-white/10 dark:from-gray-800/95 dark:to-gray-900/90">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-tr from-[#2590D6] via-[#5A4DB9] to-[#9E24B7] text-white shadow-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </div>
                            </div>

                            <!-- Floating Security Chip 1: Bcrypt Hashing (Top Left) -->
                            <div class="nexora-float-card absolute -left-4 top-2 z-20 flex items-center gap-3 rounded-2xl border border-gray-200/90 bg-white/95 px-3.5 py-2.5 shadow-xl backdrop-blur-md dark:border-gray-700/80 dark:bg-gray-800/95">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-[#01C7F4] to-[#2590D6] text-white shadow-md">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-[10.5px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Cryptographic Standard</div>
                                    <div class="text-xs font-bold text-gray-900 dark:text-white">Bcrypt 12-Round Salting</div>
                                </div>
                            </div>

                            <!-- Floating Security Chip 2: Session Rotation (Bottom Right) -->
                            <div class="nexora-float-card-delayed absolute -right-4 bottom-2 z-20 flex items-center gap-3 rounded-2xl border border-gray-200/90 bg-white/95 px-3.5 py-2.5 shadow-xl backdrop-blur-md dark:border-gray-700/80 dark:bg-gray-800/95">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-[#5A4DB9] to-[#D803B3] text-white shadow-md">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                </div>
                                <div class="text-left">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10.5px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Session Guard</span>
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_#10B981]"></span>
                                    </div>
                                    <div class="text-xs font-bold text-gray-900 dark:text-white">Immediate Token Revocation</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Three Security Pillars -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-200/80 pt-5 dark:border-gray-800/80">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Minimum 6 Chars</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Validated complexity</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Instant Sign In</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Seamless redirect</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Zero Persistence</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Token discarded</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Glassmorphic Password Reset Card -->
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
                                <span>@lang('admin::app.users.reset-password.back-link-title')</span>
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
                                    data-nexora-logo="reset-password"
                                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                                    alt="{{ config('app.name') }}"
                                />
                            @endif
                        </div>

                        <!-- Mobile Compact Graphic Header -->
                        <div class="mt-6 flex items-center gap-3 rounded-2xl border border-gray-200/70 bg-gradient-to-r from-cyan-500/5 via-indigo-500/5 to-pink-500/5 p-3 lg:hidden dark:border-gray-800">
                            <div class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white shadow-sm dark:bg-gray-800">
                                <img
                                    src="{{ asset('images/nexora-icon.png') }}"
                                    alt="Nexora Icon"
                                    class="h-7 w-7 object-contain"
                                />
                            </div>
                            <div class="min-w-0 flex-1 text-left">
                                <div class="text-xs font-bold text-gray-900 dark:text-white">Password Configuration</div>
                                <div class="truncate text-[11px] text-gray-500 dark:text-gray-400">Cryptographic Credential Update</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                @lang('admin::app.users.reset-password.title')
                            </h2>
                            <p class="mt-1.5 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                                Configure your new administrative password to restore access to Nexora.
                            </p>
                        </div>
                    </div>

                    <!-- Form Controls -->
                    <div class="my-6">
                        {!! view_render_event('admin.sessions.reset-password.form_controls.before') !!}

                        <!-- Reset Password Form -->
                        <x-admin::form :action="route('admin.reset_password.store')" class="flex flex-col gap-4">
                            <!-- Hidden Token -->
                            <x-admin::form.control-group.control
                                type="hidden"
                                name="token"
                                :value="$token"
                            />

                            <!-- Registered Email -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.users.reset-password.email')
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
                                        :label="trans('admin::app.users.reset-password.email')"
                                        :placeholder="trans('admin::app.users.reset-password.email')"
                                    />
                                </div>

                                <x-admin::form.control-group.error control-name="email" />
                            </x-admin::form.control-group>

                            <!-- Password -->
                            <x-admin::form.control-group class="relative w-full">
                                <x-admin::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.users.reset-password.password')
                                </x-admin::form.control-group.label>

                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 flex items-center text-gray-400 ltr:left-3 rtl:right-3">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>

                                    <x-admin::form.control-group.control
                                        type="password"
                                        class="w-full !rounded-xl !py-2.5 ltr:!pl-10 ltr:!pr-10 rtl:!pr-10 rtl:!pl-10"
                                        id="password"
                                        name="password"
                                        rules="required|min:6"
                                        :label="trans('admin::app.users.reset-password.password')"
                                        :placeholder="trans('admin::app.users.reset-password.password')"
                                        ref="password"
                                    />

                                    <span
                                        class="icon-eye-hide absolute top-1/2 -translate-y-1/2 cursor-pointer text-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 ltr:right-3 rtl:left-3"
                                        onclick="switchVisibility('password', 'visibilityIcon1')"
                                        id="visibilityIcon1"
                                        role="presentation"
                                        tabindex="0"
                                        title="Toggle password visibility"
                                    >
                                    </span>
                                </div>

                                <x-admin::form.control-group.error control-name="password" />
                            </x-admin::form.control-group>

                            <!-- Confirm Password -->
                            <x-admin::form.control-group class="relative w-full">
                                <x-admin::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.users.reset-password.confirm-password')
                                </x-admin::form.control-group.label>

                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 flex items-center text-gray-400 ltr:left-3 rtl:right-3">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>

                                    <x-admin::form.control-group.control
                                        type="password"
                                        class="w-full !rounded-xl !py-2.5 ltr:!pl-10 ltr:!pr-10 rtl:!pr-10 rtl:!pl-10"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        rules="confirmed:@password"
                                        :label="trans('admin::app.users.reset-password.confirm-password')"
                                        :placeholder="trans('admin::app.users.reset-password.confirm-password')"
                                        ref="password"
                                    />

                                    <span
                                        class="icon-eye-hide absolute top-1/2 -translate-y-1/2 cursor-pointer text-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 ltr:right-3 rtl:left-3"
                                        onclick="switchVisibility('password_confirmation', 'visibilityIcon2')"
                                        id="visibilityIcon2"
                                        role="presentation"
                                        tabindex="0"
                                        title="Toggle password visibility"
                                    >
                                    </span>
                                </div>

                                <x-admin::form.control-group.error control-name="password_confirmation" />
                            </x-admin::form.control-group>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="primary-button group mt-2 flex w-full items-center justify-center gap-2 !rounded-xl !py-3 text-sm font-bold shadow-lg"
                            >
                                <span>@lang('admin::app.users.reset-password.submit-btn')</span>
                                <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </x-admin::form>

                        {!! view_render_event('admin.sessions.reset-password.form_controls.after') !!}
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

    @push('scripts')
        <script>
            function switchVisibility(fieldId, iconId) {
                var passwordField = document.getElementById(fieldId);
                var visibilityIcon = document.getElementById(iconId);

                if (!passwordField || !visibilityIcon) return;

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    visibilityIcon.classList.remove("icon-eye-hide");
                    visibilityIcon.classList.add("icon-eye");
                } else {
                    passwordField.type = "password";
                    visibilityIcon.classList.remove("icon-eye");
                    visibilityIcon.classList.add("icon-eye-hide");
                }
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>
