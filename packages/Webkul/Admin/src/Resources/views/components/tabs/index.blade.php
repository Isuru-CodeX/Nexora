@props(['position' => 'left'])

<v-tabs
    position="{{ $position }}"
    {{ $attributes }}
>
    <x-admin::shimmer.tabs />
</v-tabs>

@pushOnce('scripts')
    <script 
        type="text/x-template"
        id="v-tabs-template"
    >
        <div class="w-full">
            <div
                class="flex items-center gap-2 border-b border-gray-200 pb-px mb-4 overflow-x-auto dark:border-gray-800"
                :style="positionStyles"
            >
                <div
                    v-for="tab in tabs"
                    role="tab"
                    :aria-selected="tab.isActive"
                    class="cursor-pointer px-4 py-2.5 text-sm font-medium transition-all duration-200 select-none"
                    :class="[
                        tab.isActive
                            ? 'border-b-2 border-[#01C7F4] !text-[#5A4DB9] dark:!text-[#01C7F4] font-semibold bg-gradient-to-t from-gray-100/70 to-transparent dark:from-gray-800/40 rounded-t-lg shadow-sm'
                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/60 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-800/40 rounded-t-lg'
                    ]"
                    @click="change(tab)"
                >
                    @{{ tab.title }}
                </div>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-tabs', {
            template: '#v-tabs-template',

            props: ['position'],

            data() {
                return {
                    tabs: []
                }
            },

            computed: {
                positionStyles() {
                    return [
                        `justify-content: ${this.position}`
                    ];
                },
            },

            methods: {
                change(selectedTab) {
                    if (window.NexoraTopLoader) {
                        window.NexoraTopLoader.pulse(200);
                    }

                    this.tabs.forEach(tab => {
                        tab.isActive = (tab.title == selectedTab.title);
                    });
                },
            },
        });
    </script>
@endPushOnce
