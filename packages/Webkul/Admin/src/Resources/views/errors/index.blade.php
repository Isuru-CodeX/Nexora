<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang("admin::app.errors.{$errorCode}.title")
    </x-slot>

    <!-- Error page Information -->
	<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#F4F7FB] px-4 py-8 dark:bg-[#070B14]">
        <!-- Ambient Nexora Gradient Orbs -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="nexora-orb absolute -left-24 -top-24 h-80 w-80 rounded-full bg-[#01C7F4]/20 blur-3xl dark:bg-[#01C7F4]/15"></div>
            <div class="nexora-orb-delayed absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-[#D803B3]/20 blur-3xl dark:bg-[#D803B3]/15"></div>
        </div>

        <div class="nexora-animate-in relative z-10 flex w-full max-w-[780px] items-center gap-8 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-2xl backdrop-blur-xl dark:border-gray-800/80 dark:bg-gray-900/85 sm:p-10 max-md:flex-col-reverse max-md:text-center">
            <div class="flex w-full flex-col gap-5 max-md:items-center">
                <img
                    src="{{ 
                        request()->cookie('dark_mode') 
                        ? vite()->asset('images/dark-logo.svg') 
                        : vite()->asset('images/logo.svg') 
                    }}"
                    data-nexora-logo="error"
                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                    class="h-10 w-auto object-contain"
                    alt="{{ config('app.name') }}"
                >

				<div class="text-4xl font-extrabold text-gray-800 dark:text-white sm:text-5xl">
                    {{ $errorCode }}
                </div>

                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    @lang("admin::app.errors.{$errorCode}.description")
                </p>

                <div class="flex items-center gap-3 max-md:justify-center">
                    <a
                        href="{{ url()->previous() }}"
                        class="primary-button text-xs py-1.5 px-3.5"
                    >
                        @lang('admin::app.errors.go-back')
                    </a>

                    <a
                        href="{{ route('admin.dashboard.index') }}"
                        class="secondary-button text-xs py-1.5 px-3.5"
                    >
                        @lang('admin::app.errors.dashboard')
                    </a>
                </div>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    @lang('admin::app.errors.support', [
                        'link' => 'mailto:support@nexora.local',
                        'email' => 'support@nexora.local',
                        'class' => 'font-semibold text-brandColor transition-all hover:underline',
                    ])
                </p>
            </div>

            <div class="w-full max-w-[280px] sm:max-w-[340px]">
                <img src="{{ vite()->asset('images/error.svg') }}" class="h-auto w-full object-contain" />
            </div>
        </div>
	</div>
</x-admin::layouts.anonymous>
