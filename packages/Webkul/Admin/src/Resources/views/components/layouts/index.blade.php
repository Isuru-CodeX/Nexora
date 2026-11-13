<!DOCTYPE html>

<html
    class="{{ request()->cookie('dark_mode') ? 'dark' : '' }}"
    lang="{{ app()->getLocale() }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'rtl' : 'ltr' }}"
>

<head>

    {!! view_render_event('admin.layout.head.before') !!}

    <title>{{ $title }}</title>

    <meta charset="UTF-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >
    <meta
        http-equiv="content-language"
        content="{{ app()->getLocale() }}"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="base-url"
        content="{{ url()->to('/') }}"
    >
    <meta
        name="currency"
        content="{{
            json_encode([
                'code' => config('app.currency'),
                'symbol' => core()->currencySymbol(config('app.currency'))])
            }}
        "
    >

    {{--
        Broadcasting settings for the javascript client, rendered only when a socket driver is
        fully configured. Nothing is baked into the asset bundle, so rotating a key or switching
        driver takes effect on the next page load; the values here are the ones a client must
        present to subscribe, never the application secret.
    --}}
    @if ($broadcasting = \Webkul\Admin\Services\NotificationDriver::clientConfig())
        <meta
            name="broadcasting"
            content="{{ json_encode($broadcasting) }}"
        >

        {{-- Echo and its websocket client are only fetched when there is a socket to open. --}}
        {{ vite()->set(['src/Resources/assets/js/echo.js']) }}
    @endif

    @stack('meta')

    <script>
        (function () {
            var STORAGE_KEY = 'nexora_theme';
            var getCookie = function (name) {
                var match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
                return match ? decodeURIComponent(match[1]) : null;
            };
            var saved = null;
            try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) {}
            var cookieVal = getCookie('dark_mode');
            var systemDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isManual = (saved === 'dark' || saved === 'light') || (cookieVal === '1' || cookieVal === '0');
            var isDark = (saved === 'dark' || saved === 'light')
                ? saved === 'dark'
                : ((cookieVal === '1' || cookieVal === '0') ? cookieVal === '1' : systemDark);

            var root = document.documentElement;
            root.classList.toggle('dark', isDark);
            root.style.colorScheme = isDark ? 'dark' : 'light';
            root.dataset.theme = isDark ? 'dark' : 'light';
            root.dataset.themeSource = isManual ? 'manual' : 'system';

            window.__nexoraTheme = {
                isDark: function () { return root.classList.contains('dark'); },
                apply: function (dark, persistManual) {
                    root.classList.toggle('dark', !!dark);
                    root.style.colorScheme = dark ? 'dark' : 'light';
                    root.dataset.theme = dark ? 'dark' : 'light';
                    if (persistManual) {
                        root.dataset.themeSource = 'manual';
                        try { localStorage.setItem(STORAGE_KEY, dark ? 'dark' : 'light'); } catch (e) {}
                        document.cookie = 'dark_mode=' + (dark ? 1 : 0) + '; path=/; max-age=31536000; SameSite=Lax';
                    }
                    document.querySelectorAll('[data-nexora-logo]').forEach(function (img) {
                        var nextSrc = dark ? img.getAttribute('data-dark-src') : img.getAttribute('data-light-src');
                        if (nextSrc) { img.src = nextSrc; }
                    });
                    if (window.emitter) {
                        window.emitter.emit('change-theme', dark ? 'dark' : 'light');
                    }
                }
            };

            if (window.matchMedia) {
                var mq = window.matchMedia('(prefers-color-scheme: dark)');
                var onSystemChange = function (e) {
                    if (root.dataset.themeSource === 'system') {
                        window.__nexoraTheme.apply(e.matches, false);
                    }
                };
                if (mq.addEventListener) {
                    mq.addEventListener('change', onSystemChange);
                } else if (mq.addListener) {
                    mq.addListener(onSystemChange);
                }
            }

            function hideNexoraPreloader() {
                var loader = document.getElementById('nexora-preloader');
                if (loader) {
                    loader.style.opacity = '0';
                    loader.style.pointerEvents = 'none';
                    setTimeout(function () {
                        if (loader && loader.parentNode) {
                            loader.parentNode.removeChild(loader);
                        }
                    }, 450);
                }
            }

            window.__hideNexoraPreloader = hideNexoraPreloader;

            document.addEventListener('DOMContentLoaded', function () {
                window.__nexoraTheme.apply(root.classList.contains('dark'), false);
                requestAnimationFrame(function () {
                    root.classList.add('nexora-theme-ready');
                });
            });

            window.addEventListener('load', function () {
                setTimeout(hideNexoraPreloader, 60);
            });

            // Safety timeout so preloader never blocks page
            setTimeout(hideNexoraPreloader, 2600);
        })();
    </script>

    {{
        vite()->set(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])
    }}

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap"
        rel="stylesheet"
    />

    @if ($favicon = core()->getConfigData('general.general.admin_logo.favicon_image'))
        <link
            type="image/x-icon"
            href="{{ Storage::url($favicon) }}"
            rel="shortcut icon"
            sizes="16x16"
        >
    @else
        <link
            type="image/x-icon"
            href="{{ vite()->asset('images/favicon.ico') }}"
            rel="shortcut icon"
            sizes="16x16"
        />
    @endif

    @php
        $brandColor = core()->getConfigData('general.settings.menu_color.brand_color') ?? '#5A4DB9';
    @endphp

    @stack('styles')

    <style>
        :root {
            --brand-color: {{ $brandColor }};
        }

        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
    </style>

    {!! view_render_event('admin.layout.head.after') !!}
</head>

<body class="h-full font-inter bg-[#F4F7FB] dark:bg-[#070B14]">
    {!! view_render_event('admin.layout.body.before') !!}

    <!-- Nexora Global Top Loader Bar -->
    <div
        id="nexora-top-loader"
        class="pointer-events-none fixed top-0 left-0 right-0 z-[1000000] h-[3px] w-0 opacity-0"
    ></div>

    <!-- Nexora Page Preloader -->
    <div
        id="nexora-preloader"
        class="fixed inset-0 z-[999999] flex flex-col items-center justify-center bg-white transition-opacity duration-400 ease-out dark:bg-[#070B14]"
    >
        <div class="pointer-events-none absolute h-80 w-80 rounded-full bg-gradient-to-tr from-[#01C7F4]/25 via-[#5A4DB9]/30 to-[#D803B3]/25 blur-3xl dark:from-[#01C7F4]/20 dark:to-[#D803B3]/20"></div>

        <div class="relative flex flex-col items-center gap-6">
            <div class="relative flex h-24 w-24 items-center justify-center">
                <!-- Outer orbital ring -->
                <div class="absolute inset-0 nexora-spin-ring rounded-full border-[2.5px] border-transparent border-t-[#01C7F4] border-r-[#5A4DB9] border-b-[#D803B3]"></div>
                <!-- Inner counter-rotating orbital ring -->
                <div class="absolute inset-2 nexora-spin-reverse rounded-full border-2 border-transparent border-t-[#D803B3] border-l-[#01C7F4]"></div>
                <!-- Ambient glow -->
                <div class="absolute inset-1 rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3] opacity-25 blur-md"></div>
                <!-- Brand icon -->
                <img
                    src="{{ asset('images/nexora-icon.png') }}"
                    alt="{{ config('app.name', 'Nexora') }}"
                    class="h-11 w-11 object-contain drop-shadow-[0_0_14px_rgba(1,199,244,0.5)] transition-transform duration-300"
                />
            </div>

            <div class="flex flex-col items-center gap-2.5">
                <span class="text-xs font-extrabold tracking-[0.25em] text-gray-900 uppercase dark:text-white">
                    Nexora<span class="bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3] bg-clip-text text-transparent">.CRM</span>
                </span>
                <div class="h-1.5 w-32 overflow-hidden rounded-full bg-gray-200/80 dark:bg-gray-800/80 shadow-inner">
                    <div class="nexora-preloader-bar h-full w-full rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3] shadow-[0_0_10px_rgba(1,199,244,0.8)]"></div>
                </div>
            </div>
        </div>
    </div>

    <div
        id="app"
        class="h-full"
    >
        <!-- Action Loader Component -->
        <v-nexora-action-loader></v-nexora-action-loader>

        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        <!-- Confirm Modal Blade Component -->
        <x-admin::modal.confirm />

        {!! view_render_event('admin.layout.content.before') !!}

        <!-- Page Header Blade Component -->
        <x-admin::layouts.header />

        <div
            class="group/container {{ request()->cookie('sidebar_collapsed') ?? 0 ? 'sidebar-collapsed' : 'sidebar-not-collapsed' }} flex gap-4"
            ref="appLayout"
        >
            <!-- Page Sidebar Blade Component -->
            <x-admin::layouts.sidebar.desktop />

            @php
                /**
                 * The bar is fixed, so the content below reserves space for it.
                 * When it is switched off that reserve goes away too, otherwise
                 * every page keeps a strip of dead space at the bottom.
                 */
                $showPoweredBy = (bool) core()->getConfigData('general.settings.footer.show');
            @endphp

            <div class="flex min-h-[calc(100vh-62px)] max-w-full flex-1 flex-col bg-[#F4F7FB] pt-3 transition-all duration-300 dark:bg-transparent">
                <!-- Page Content Blade Component -->
                <div class="nexora-animate-in px-3 py-2 sm:px-4 sm:py-3 lg:px-6 {{ $showPoweredBy ? 'pb-[72px]' : 'pb-4' }} transition-all duration-300 lg:ltr:pl-[215px] lg:group-[.sidebar-collapsed]/container:ltr:pl-[85px] lg:rtl:pr-[215px] lg:group-[.sidebar-collapsed]/container:rtl:pr-[85px]">
                    {{ $slot }}
                </div>

                @if ($showPoweredBy)
                    <!-- Powered By -->
                    <div class="fixed bottom-0 left-0 right-0 z-1">
                        <div class="border-t bg-white py-5 text-center text-sm font-normal dark:border-gray-800 dark:bg-gray-900 dark:text-white max-md:py-3">
                            <p>{!! core()->sanitizeHtml(core()->getConfigData('general.settings.footer.label')) !!}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {!! view_render_event('admin.layout.content.after') !!}
    </div>

    {!! view_render_event('admin.layout.body.after') !!}

    <script
        type="text/x-template"
        id="v-nexora-action-loader-template"
    >
        <transition
            enter-active-class="transition-opacity duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isVisible"
                class="fixed inset-0 z-[100000] flex items-center justify-center bg-gray-950/70 backdrop-blur-md"
            >
                <div class="nexora-scale-in relative flex flex-col items-center gap-4 rounded-3xl border border-white/20 bg-white/90 p-8 shadow-2xl backdrop-blur-xl dark:border-gray-800/80 dark:bg-gray-900/90 min-w-[260px] max-w-sm text-center">
                    <!-- Glow background -->
                    <div class="pointer-events-none absolute -inset-1 rounded-3xl bg-gradient-to-r from-[#01C7F4]/20 via-[#5A4DB9]/25 to-[#D803B3]/20 blur-xl opacity-75"></div>

                    <div class="relative flex h-16 w-16 items-center justify-center">
                        <!-- Outer rotating orbital -->
                        <div class="absolute inset-0 nexora-spin-ring rounded-full border-2 border-transparent border-t-[#01C7F4] border-r-[#5A4DB9] border-b-[#D803B3]"></div>
                        <!-- Inner counter rotating orbital -->
                        <div class="absolute inset-2 nexora-spin-reverse rounded-full border-2 border-transparent border-t-[#D803B3] border-l-[#01C7F4]"></div>
                        <img
                            src="{{ asset('images/nexora-icon.png') }}"
                            alt="Nexora"
                            class="h-8 w-8 object-contain drop-shadow-[0_0_10px_rgba(1,199,244,0.5)]"
                        />
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <p class="text-sm font-semibold tracking-wide text-gray-800 dark:text-gray-100">
                            @{{ message }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Please wait a moment...
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </script>

    <script type="module">
        app.component('v-nexora-action-loader', {
            template: '#v-nexora-action-loader-template',

            data() {
                return {
                    isVisible: false,
                    message: 'Loading...',
                };
            },

            mounted() {
                this.$emitter?.on('show-action-loader', (msg) => {
                    this.message = msg || 'Processing...';
                    this.isVisible = true;
                });

                this.$emitter?.on('hide-action-loader', () => {
                    this.isVisible = false;
                });
            },
        });
    </script>

    @stack('scripts')

    {!! view_render_event('admin.layout.vue-app-mount.before') !!}

    <script>
        /**
         * Load event, the purpose of using the event is to mount the application
         * after all of our `Vue` components which is present in blade file have
         * been registered in the app. No matter what `app.mount()` should be
         * called in the last.
         */
        window.addEventListener("load", function(event) {
            app.mount("#app");
        });
    </script>

    {!! view_render_event('admin.layout.vue-app-mount.after') !!}
</body>

</html>
