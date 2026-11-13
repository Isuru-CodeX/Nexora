@php
    $activeConfiguration = system_config()->getActiveConfigurationItem();

    $name = $activeConfiguration->getName();
@endphp

<x-admin::layouts>
    <x-slot:title>
        {{ strip_tags($name) }}
    </x-slot>

    {!! view_render_event('admin.configuration.edit.form_controls.before') !!}

    <!-- Configuration form fields -->
    <x-admin::form
        action=""
        enctype="multipart/form-data"
    >
        <!-- Configuration Header Actions -->
        <div class="mt-3.5 flex items-center justify-between gap-4 max-sm:flex-wrap">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-100 text-[#5A4DB9] dark:bg-gray-800 dark:text-indigo-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    {{ $name }}
                </p>
            </div>

            <div class="flex items-center gap-x-2.5">
                {!! view_render_event('admin.configuration.edit.back_button.before') !!}

                <!-- Back Button -->
                <a
                    href="{{ route('admin.configuration.index') }}"
                    class="secondary-button"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>@lang('admin::app.configuration.index.back')</span>
                </a>

                {!! view_render_event('admin.configuration.edit.back_button.after') !!}

                {!! view_render_event('admin.configuration.edit.save_button.before') !!}

                <button
                    type="submit"
                    class="primary-button"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>@lang('admin::app.configuration.index.save-btn')</span>
                </button>

                {!! view_render_event('admin.configuration.edit.save_button.after') !!}
            </div>
        </div>

        <div class="grid grid-cols-[1fr_2fr] gap-10 max-lg:grid-cols-1 max-lg:gap-6 lg:mt-6">
            @foreach ($activeConfiguration->getChildren() as $child)
                <div class="grid content-start gap-2 max-lg:mt-6">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-[#5A4DB9]"></span>
                        <p class="text-base font-bold text-gray-900 dark:text-white">
                            {{ $child->getName() }}
                        </p>
                    </div>

                    <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                        {!! $child->getInfo() !!}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90">
                    {!! view_render_event('admin.configuration.edit.form_controls.before') !!}

                    @foreach ($child->getFields() as $field)
                        @if (
                            $field->getType() == 'blade'
                            && view()->exists($path = $field->getPath())
                        )
                            {!! view($path, compact('field', 'child'))->render() !!}
                        @else 
                            @include ('admin::configuration.field-type')
                        @endif
                    @endforeach

                    {!! view_render_event('admin.configuration.edit.form_controls.after') !!}
                </div>
            @endforeach
        </div>
    </x-admin::form>

    {!! view_render_event('admin.configuration.edit.form_controls.after') !!}
</x-admin::layouts>
