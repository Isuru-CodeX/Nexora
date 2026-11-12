<header class="sticky top-0 z-[10001] flex items-center justify-between gap-2 border-b border-gray-200/90 bg-white/85 px-3 py-2 sm:px-4 sm:py-2.5 backdrop-blur-md shadow-sm transition-all duration-200 dark:border-gray-800/80 dark:bg-gray-900/85 dark:shadow-gray-950/40">  
    <!-- logo -->
    <div class="flex items-center gap-1.5">
        <!-- Sidebar Menu -->
        <x-admin::layouts.sidebar.mobile />
        
        <a href="{{ route('admin.dashboard.index') }}">
            @if ($logo = core()->getConfigData('general.general.admin_logo.logo_image'))
                <img
                    class="h-10"
                    src="{{ Storage::url($logo) }}"
                    alt="{{ config('app.name') }}"
                />
            @else
                <img
                    class="h-10 max-sm:hidden transition-transform duration-300 hover:scale-[1.03]"
                    src="{{ request()->cookie('dark_mode') ? vite()->asset('images/dark-logo.svg') : vite()->asset('images/logo.svg') }}"
                    data-nexora-logo="desktop"
                    data-light-src="{{ vite()->asset('images/logo.svg') }}"
                    data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                    id="logo-image"
                    alt="{{ config('app.name') }}"
                />

                <img
                    class="h-10 sm:hidden transition-transform duration-300 hover:scale-[1.05]"
                    src="{{ request()->cookie('dark_mode') ? vite()->asset('images/mobile-dark-logo.svg') : vite()->asset('images/mobile-light-logo.svg') }}"
                    data-nexora-logo="mobile"
                    data-light-src="{{ vite()->asset('images/mobile-light-logo.svg') }}"
                    data-dark-src="{{ vite()->asset('images/mobile-dark-logo.svg') }}"
                    alt="{{ config('app.name') }}"
                />
            @endif
        </a>
    </div>

    <div class="flex items-center gap-1.5 max-md:hidden">
        <!-- Mega Search Bar -->
        @include('admin::components.layouts.header.desktop.mega-search')

        <!-- Quick Creation Bar -->
        @include('admin::components.layouts.header.quick-creation')
    </div>

    <div class="flex items-center gap-2.5">
        <div class="md:hidden">
            <!-- Mega Search Bar -->
            @include('admin::components.layouts.header.mobile.mega-search')
        </div>
        
        <!-- Notifications -->
        @include('admin::components.layouts.header.notifications')

        <!-- Dark mode -->
        <v-dark>
            <div class="flex">
                <span
                    class="{{ request()->cookie('dark_mode') ? 'icon-light' : 'icon-dark' }} p-1.5 rounded-md text-2xl cursor-pointer transition-all hover:bg-gray-100 dark:hover:bg-gray-950"
                ></span>
            </div>
        </v-dark>

        <div class="md:hidden">
            <!-- Quick Creation Bar -->
            @include('admin::components.layouts.header.quick-creation')
        </div>
        
        <!-- Admin profile -->
        <x-admin::dropdown position="bottom-{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left' : 'right' }}">
            <x-slot:toggle>
                @php($user = auth()->guard('user')->user())

                @if ($user->image)
                    <button class="flex h-9 w-9 cursor-pointer overflow-hidden rounded-full hover:opacity-80 focus:opacity-80">
                        <img
                            src="{{ $user->image_url }}"
                            class="h-full w-full object-cover"
                        />
                    </button>
                @else
                    <button class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full bg-pink-400 font-semibold leading-6 text-white">
                        {{ substr($user->name, 0, 1) }}
                    </button>
                @endif
            </x-slot>

            <!-- Admin Dropdown -->
            <x-slot:content class="mt-2 border-t-0 !p-0">
                <div class="flex items-center gap-1.5 border border-x-0 border-b-gray-300 px-5 py-2.5 dark:border-gray-800">
                    @if ($logo = core()->getConfigData('general.general.admin_logo.logo_image'))
                        <img
                            src="{{ Storage::url($logo) }}"
                            alt="{{ config('app.name') }}"
                            width="24"
                            height="24"
                        />
                    @else
                        <img
                            src="{{ request()->cookie('dark_mode') ? vite()->asset('images/dark-logo.svg') : vite()->asset('images/logo.svg') }}"
                            data-nexora-logo="dropdown"
                            data-light-src="{{ vite()->asset('images/logo.svg') }}"
                            data-dark-src="{{ vite()->asset('images/dark-logo.svg') }}"
                            alt="{{ config('app.name') }}"
                            width="24"
                            height="24"
                        />
                    @endif

                    <!-- Version -->
                    <p class="text-gray-400">
                        @lang('admin::app.layouts.app-version', ['version' => core()->version()])
                    </p>
                </div>

                <div class="grid gap-1 pb-2.5">
                    <a
                        class="cursor-pointer px-5 py-2 text-base text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-950"
                        href="{{ route('admin.user.account.edit') }}"
                    >
                        @lang('admin::app.layouts.my-account')
                    </a>

                    <!--Admin logout-->
                    <x-admin::form
                        method="DELETE"
                        action="{{ route('admin.session.destroy') }}"
                        id="adminLogout"
                    >
                    </x-admin::form>

                    <a
                        class="cursor-pointer px-5 py-2 text-base text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-950"
                        href="{{ route('admin.session.destroy') }}"
                        onclick="event.preventDefault(); document.getElementById('adminLogout').submit();"
                    >
                        @lang('admin::app.layouts.sign-out')
                    </a>
                </div>
            </x-slot>
        </x-admin::dropdown>
    </div>
</header>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dark-template"
    >
        <div class="flex">
            <button
                type="button"
                class="nexora-theme-toggle flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-gray-200/80 bg-gray-50/80 text-gray-700 hover:border-nexora-indigo/50 hover:bg-gray-100 dark:border-gray-700/80 dark:bg-gray-800/80 dark:text-slate-200 dark:hover:border-cyan-400/50 dark:hover:bg-gray-800"
                :title="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                :aria-label="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                @click="toggle"
            >
                <span
                    :key="isDarkMode ? 'light' : 'dark'"
                    class="nexora-theme-icon text-xl"
                    :class="[isDarkMode ? 'icon-light !text-amber-400' : 'icon-dark !text-indigo-600']"
                ></span>
            </button>
        </div>
    </script>

    <script type="module">
        app.component('v-dark', {
            template: '#v-dark-template',

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
                    } else {
                        var expiryDate = new Date();
                        expiryDate.setMonth(expiryDate.getMonth() + 1);
                        document.cookie = 'dark_mode=' + this.isDarkMode + '; path=/; expires=' + expiryDate.toGMTString();
                        document.documentElement.classList.toggle('dark', nextDark);
                        this.$emitter.emit('change-theme', nextDark ? 'dark' : 'light');
                    }
                },
            },
        });
    </script>
@endPushOnce
