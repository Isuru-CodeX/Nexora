<!DOCTYPE html>

<html
    class="{{ request()->cookie('dark_mode') ? 'dark' : '' }}"
    lang="{{ app()->getLocale() }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'rtl' : 'ltr' }}"
>

<head>
    <title>{{ $title ?? '' }}</title>

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
        name="currency-code"
        {{-- content="{{ core()->getCurrentCurrencyCode() }}" --}}
    >

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
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
        rel="stylesheet"
    />

    @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon'))
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

    {!! view_render_event('admin.layout.head') !!}
</head>

<body class="font-inter bg-[#F4F7FB] text-gray-800 dark:bg-[#070B14] dark:text-slate-100">
    {!! view_render_event('admin.layout.body.before') !!}

    <div id="app" class="relative min-h-screen overflow-hidden">
        <!-- Floating Nexora Theme Switcher -->
        <v-anonymous-theme-toggle></v-anonymous-theme-toggle>

        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        {!! view_render_event('admin.layout.content.before') !!}

        <!-- Page Content Blade Component -->
        {{ $slot }}

        {!! view_render_event('admin.layout.content.after') !!}
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-anonymous-theme-toggle-template"
        >
            <button
                type="button"
                class="nexora-theme-toggle fixed top-5 z-[10002] flex h-10 items-center gap-2 rounded-full border border-gray-200/80 bg-white/85 px-3.5 text-xs font-semibold text-gray-700 shadow-lg backdrop-blur-md hover:border-nexora-indigo/50 dark:border-gray-700/80 dark:bg-gray-900/85 dark:text-slate-200 dark:hover:border-cyan-400/50 ltr:right-5 rtl:left-5"
                :title="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                :aria-label="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                @click="toggle"
            >
                <span
                    :key="isDarkMode ? 'light' : 'dark'"
                    class="nexora-theme-icon text-lg"
                    :class="[isDarkMode ? 'icon-light !text-amber-400' : 'icon-dark !text-indigo-600']"
                ></span>
                <span>@{{ isDarkMode ? 'Light' : 'Dark' }}</span>
            </button>
        </script>

        <script type="module">
            app.component('v-anonymous-theme-toggle', {
                template: '#v-anonymous-theme-toggle-template',

                data() {
                    return {
                        isDarkMode: document.documentElement.classList.contains('dark') ? 1 : 0,
                    };
                },

                mounted() {
                    this.isDarkMode = document.documentElement.classList.contains('dark') ? 1 : 0;

                    this.$emitter.on('change-theme', (theme) => {
                        this.isDarkMode = theme === 'dark' ? 1 : 0;
                    });
                },

                methods: {
                    toggle() {
                        const nextDark = this.isDarkMode !== 1;
                        this.isDarkMode = nextDark ? 1 : 0;

                        if (window.__nexoraTheme) {
                            window.__nexoraTheme.apply(nextDark, true);
                        }
                    },
                },
            });
        </script>
    @endPushOnce

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

    <script type="text/javascript">
        {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
    </script>
</body>

</html>
