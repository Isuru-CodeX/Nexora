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

            document.addEventListener('DOMContentLoaded', function () {
                window.__nexoraTheme.apply(root.classList.contains('dark'), false);
                requestAnimationFrame(function () {
                    root.classList.add('nexora-theme-ready');
                });
            });
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

    <div
        id="app"
        class="h-full"
    >
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
                <div class="nexora-animate-in px-4 {{ $showPoweredBy ? 'pb-[72px]' : 'pb-4' }} transition-all duration-300 lg:ltr:pl-[215px] lg:group-[.sidebar-collapsed]/container:ltr:pl-[85px] lg:rtl:pr-[215px] lg:group-[.sidebar-collapsed]/container:rtl:pr-[85px]">
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
