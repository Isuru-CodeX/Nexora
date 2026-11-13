<x-admin::layouts>
    <x-slot:title>
        {{ strip_tags($warehouse->name) }}
    </x-slot>

    <div class="nexora-animate-in flex gap-4 max-lg:flex-wrap">
        <!-- Left Panel -->
        {!! view_render_event('admin.settings.warehouses.view.left.before', ['warehouse' => $warehouse]) !!}

        <div class="nexora-card max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-2xl border border-gray-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
            <!-- Warehouse Information -->
            <div class="flex w-full flex-col gap-3 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
                <!-- Breadcrumbs -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs
                        name="settings.warehouses.view"
                        :entity="$warehouse"
                    />

                    @if (bouncer()->hasPermission('settings.inventory.warehouses.edit'))
                        <a
                            href="{{ route('admin.settings.warehouses.edit', $warehouse->id) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-brandColor hover:text-brandColor dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:border-cyan-400 dark:hover:text-cyan-400"
                        >
                            <span class="icon-edit text-sm"></span>
                            @lang('admin::app.settings.warehouses.index.datagrid.edit')
                        </a>
                    @endif
                </div>

                {!! view_render_event('admin.settings.warehouses.view.left.tags.before', ['warehouse' => $warehouse]) !!}

                <!-- Tags -->
                <x-admin::tags
                    :attach-endpoint="route('admin.settings.warehouses.tags.attach', $warehouse->id)"
                    :detach-endpoint="route('admin.settings.warehouses.tags.detach', $warehouse->id)"
                    :added-tags="$warehouse->tags"
                />

                {!! view_render_event('admin.settings.warehouses.view.left.tags.after', ['warehouse' => $warehouse]) !!}

                {!! view_render_event('admin.settings.warehouses.view.left.title.before', ['warehouse' => $warehouse]) !!}

                <!-- Title -->
                <h3 class="text-lg font-bold dark:text-white">
                    {{ $warehouse->name }}
                </h3>

                {!! view_render_event('admin.settings.warehouses.view.left.title.after', ['warehouse' => $warehouse]) !!}

                {!! view_render_event('admin.settings.warehouses.view.left.actions.before', ['warehouse' => $warehouse]) !!}

                <!-- Activity Actions -->
                <div class="flex flex-wrap gap-2">
                    {!! view_render_event('admin.settings.warehouses.view.left.actions.file.before', ['warehouse' => $warehouse]) !!}

                    <!-- File Activity Action -->
                    <x-admin::activities.actions.file
                        :entity="$warehouse"
                        entity-control-name="warehouse_id"
                    />

                    {!! view_render_event('admin.settings.warehouses.view.left.actions.file.after', ['warehouse' => $warehouse]) !!}

                    {!! view_render_event('admin.settings.warehouses.view.left.actions.note.before', ['warehouse' => $warehouse]) !!}

                    <!-- Note Activity Action -->
                    <x-admin::activities.actions.note
                        :entity="$warehouse"
                        entity-control-name="warehouse_id"
                    />

                    {!! view_render_event('admin.settings.warehouses.view.left.actions.note.after', ['warehouse' => $warehouse]) !!}

                    {!! view_render_event('admin.settings.warehouses.view.left.actions.activity.before', ['warehouse' => $warehouse]) !!}

                    <!-- Activity Action -->
                    <x-admin::activities.actions.activity
                        :entity="$warehouse"
                        entity-control-name="warehouse_id"
                    />

                    {!! view_render_event('admin.settings.warehouses.view.left.actions.activity.after', ['warehouse' => $warehouse]) !!}
                </div>

                {!! view_render_event('admin.settings.warehouses.view.left.actions.after', ['warehouse' => $warehouse]) !!}
            </div>
            
            <!-- General Information -->
            @include ('admin::settings.warehouses.view.general-information')

            <!-- Contact Information -->
            @include ('admin::settings.warehouses.view.contact-information')
        </div>

        {!! view_render_event('admin.settings.warehouses.view.left.after', ['warehouse' => $warehouse]) !!}

        {!! view_render_event('admin.settings.warehouses.view.right.before', ['warehouse' => $warehouse]) !!}
        
        <!-- Right Panel -->
        <div class="flex w-full flex-col gap-4 rounded-2xl">
            {!! view_render_event('admin.settings.warehouses.view.right.attributes.before', ['warehouse' => $warehouse]) !!}

            <!-- Activity Navigation -->
            <x-admin::activities
                :endpoint="route('admin.settings.warehouse.activities.index', $warehouse->id)" 
                :types="[
                    ['name' => 'all', 'label' => trans('admin::app.settings.warehouses.view.all')],
                    ['name' => 'note', 'label' => trans('admin::app.settings.warehouses.view.notes')],
                    ['name' => 'file', 'label' => trans('admin::app.settings.warehouses.view.files')],
                    ['name' => 'system', 'label' => trans('admin::app.settings.warehouses.view.change-logs')],
                ]"
                :extra-types="[
                    ['name' => 'location', 'label' => trans('admin::app.settings.warehouses.view.location')],
                ]"
            >
                <x-slot:location>
                    @include ('admin::settings.warehouses.view.locations')
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.settings.warehouses.view.right.attributes.after', ['warehouse' => $warehouse]) !!}
        </div>

        {!! view_render_event('admin.warehouse.view.right.after', ['warehouse' => $warehouse]) !!}
    </div>    
</x-admin::layouts>