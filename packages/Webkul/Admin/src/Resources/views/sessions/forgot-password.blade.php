<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.forget-password.create.page-title')
    </x-slot>

    <div class="relative flex min-h-screen flex-col items-center justify-center gap-8 overflow-hidden px-4 py-10">
        <!-- Ambient Nexora Gradient Orbs -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="nexora-orb absolute -left-24 -top-24 h-80 w-80 rounded-full bg-[#01C7F4]/20 blur-3xl dark:bg-[#01C7F4]/15"></div>
            <div class="nexora-orb-delayed absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-[#D803B3]/20 blur-3xl dark:bg-[#D803B3]/15"></div>
        </div>

        <div class="nexora-animate-in relative z-10 flex w-full max-w-[410px] flex-col items-center gap-6">
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
                    data-nexora-logo="forgot-password"
                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                    alt="{{ config('app.name') }}"
                />
            @endif

            <div class="nexora-scale-in box-shadow flex w-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white/95 shadow-2xl backdrop-blur-xl dark:border-gray-800/80 dark:bg-gray-900/90">
                <div class="nexora-gradient-bar h-1 w-full"></div>
                {!! view_render_event('admin.sessions.forgor_password.form_controls.before') !!}

                <!-- Forget Password Form -->
                <x-admin::form :action="route('admin.forgot_password.store')">
                    <div class="p-5">
                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                            @lang('admin::app.users.forget-password.create.title')
                        </p>
                    </div>

                    <div class="border-y p-5 dark:border-gray-800">
                        <!-- Registered Email -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.forget-password.create.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                class="w-full"
                                id="email"
                                name="email"
                                rules="required|email"
                                :value="old('email')"
                                :label="trans('admin::app.users.forget-password.create.email')"
                                :placeholder="trans('admin::app.users.forget-password.create.email')"
                            />

                            <x-admin::form.control-group.error control-name="email" />
                        </x-admin::form.control-group>
                    </div>

                    <div class="flex items-center justify-between p-5">
                        <!-- Back to Sign In link -->
                        <a
                            class="cursor-pointer text-xs font-semibold leading-6 text-brandColor transition-colors hover:opacity-85"
                            href="{{ route('admin.session.create') }}"
                        >
                            @lang('admin::app.users.forget-password.create.sign-in-link')
                        </a>

                        <!-- Form Submit Button -->
                        <button
                            class="primary-button px-5 py-2"
                        >
                            @lang('admin::app.users.forget-password.create.submit-btn')
                        </button>
                    </div>
                </x-admin::form>

                {!! view_render_event('admin.sessions.forgor_password.form_controls.after') !!}
            </div>
        </div>

        <!-- Powered By -->
        <div class="relative z-10 text-sm font-normal text-gray-500 dark:text-gray-400">
            @lang('admin::app.components.layouts.powered-by.description', [
                'krayin' => '<span class="nexora-gradient-text font-semibold">Nexora</span>',
                'webkul' => '<span class="font-semibold text-gray-700 dark:text-gray-200">Nexora Community</span>',
            ])
        </div>
    </div>
</x-admin::layouts.anonymous>
