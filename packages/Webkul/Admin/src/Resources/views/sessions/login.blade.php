<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.login.title')
    </x-slot>

    <div class="relative flex min-h-screen flex-col items-center justify-center gap-8 overflow-hidden px-4 py-10">
        <!-- Ambient Nexora Gradient Orbs -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="nexora-orb absolute -left-24 -top-24 h-80 w-80 rounded-full bg-[#01C7F4]/20 blur-3xl dark:bg-[#01C7F4]/15"></div>
            <div class="nexora-orb-delayed absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-[#D803B3]/20 blur-3xl dark:bg-[#D803B3]/15"></div>
            <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#5A4DB9]/15 blur-3xl"></div>
        </div>

        <div class="nexora-animate-in relative z-10 flex w-full max-w-[380px] flex-col items-center gap-6">
            <!-- Logo -->
            @if ($logo = core()->getConfigData('general.general.admin_logo.logo_image'))
                <img
                    class="h-12 w-auto object-contain transition-transform duration-300 hover:scale-105"
                    src="{{ Storage::url($logo) }}"
                    alt="{{ config('app.name') }}"
                />
            @else
                <img
                    class="h-12 w-auto transition-transform duration-300 hover:scale-105"
                    src="{{ request()->cookie('dark_mode') ? vite()->asset('images/dark-logo.svg') : vite()->asset('images/logo.svg') }}"
                    data-nexora-logo="login"
                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                    alt="{{ config('app.name') }}"
                />
            @endif

            <div class="nexora-scale-in box-shadow flex w-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white/90 shadow-2xl backdrop-blur-xl dark:border-gray-800/80 dark:bg-gray-900/85">
                <div class="nexora-gradient-bar h-1 w-full"></div>
                {!! view_render_event('admin.sessions.login.form_controls.before') !!}

                <!-- Login Form -->
                <x-admin::form :action="route('admin.session.store')">
                    <p class="p-4 text-xl font-bold text-gray-800 dark:text-white">
                        @lang('admin::app.users.login.title')
                    </p>

                    <div class="border-y p-4 dark:border-gray-800">
                        <!-- Email -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.login.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                class="w-[254px] max-w-full"
                                id="email"
                                name="email"
                                rules="required|email"
                                :label="trans('admin::app.users.login.email')"
                                :placeholder="trans('admin::app.users.login.email')"
                            />

                            <x-admin::form.control-group.error control-name="email" />
                        </x-admin::form.control-group>

                        <!-- Password -->
                        <x-admin::form.control-group class="relative w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.login.password')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="password"
                                class="w-[254px] max-w-full ltr:pr-10 rtl:pl-10"
                                id="password"
                                name="password"
                                rules="required|min:6"
                                :label="trans('admin::app.users.login.password')"
                                :placeholder="trans('admin::app.users.login.password')"
                            />

                            <span
                                class="icon-eye-hide absolute top-11 -translate-y-2/4 cursor-pointer text-2xl ltr:right-3 rtl:left-3"
                                onclick="switchVisibility()"
                                id="visibilityIcon"
                                role="presentation"
                                tabindex="0"
                            >
                            </span>

                            <x-admin::form.control-group.error control-name="password" />
                        </x-admin::form.control-group>
                    </div>

                    <div class="flex items-center justify-between p-4">
                        <!-- Forgot Password Link -->
                        <a
                            class="cursor-pointer text-xs font-semibold leading-6 text-brandColor"
                            href="{{ route('admin.forgot_password.create') }}"
                        >
                            @lang('admin::app.users.login.forget-password-link')
                        </a>

                        <!-- Submit Button -->
                        <button
                            class="primary-button"
                            aria-label="{{ trans('admin::app.users.login.submit-btn')}}"
                        >
                            @lang('admin::app.users.login.submit-btn')
                        </button>
                    </div>
                </x-admin::form>

                {!! view_render_event('admin.sessions.login.form_controls.after') !!}
            </div>
        </div>

        <!-- Powered By -->
        <div class="relative z-10 text-sm font-normal text-gray-500 dark:text-gray-400">
            @lang('admin::app.components.layouts.powered-by.description', [
                'krayin' => '<span class="nexora-gradient-text font-semibold">Nexora</span>',
                'webkul' => '<span class="font-semibold text-gray-700 dark:text-gray-200">Isuru Rathnayaka</span>',
            ])
        </div>
    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let visibilityIcon = document.getElementById("visibilityIcon");

                passwordField.type = passwordField.type === "password" ? "text" : "password";
                visibilityIcon.classList.toggle("icon-eye");
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>
