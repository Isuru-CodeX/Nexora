
<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.settings.warehouses.edit.title')
    </x-slot>

    {!! view_render_event('admin.settings.warehouses.edit.form.before', ['warehouse' => $warehouse]) !!}

    <x-admin::form
        method="PUT"
        :action="route('admin.settings.warehouses.update', $warehouse->id)"
    >
        <div class="nexora-animate-in flex flex-col gap-4">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-2">
                    {!! view_render_event('admin.settings.warehouses.edit.breadcrumbs.before') !!}

                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs 
                        name="settings.warehouses.edit" 
                        :entity="$warehouse"
                    />

                    {!! view_render_event('admin.settings.warehouses.edit.breadcrumbs.after') !!}
                    
                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.settings.warehouses.edit.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <div class="flex items-center gap-x-2.5">
                        {!! view_render_event('admin.settings.warehouse.edit.save_button.after') !!}
                        
                        @if (bouncer()->hasPermission('settings.inventory.warehouse.edit'))
                        <!-- Create button for person -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('admin::app.settings.warehouses.edit.save-btn')
                        </button>
                        @endif

                        {!! view_render_event('admin.settings.warehouses.edit.save_button.before') !!}
                    </div>
                </div>
            </div>

            <div class="flex gap-2.5 max-xl:flex-wrap">
                <!-- Left sub-component -->
                <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                    <div class="nexora-card rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.settings.warehouses.edit.contact-info')
                        </p>
                        
                        {!! view_render_event('admin.settings.warehouses.edit.left.form_controls.before', ['warehouse' => $warehouse]) !!}

                        <x-admin::attributes
                            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                ['code', 'NOTIN', ['name', 'description']],
                                'entity_type' => 'warehouses',
                            ])->sortBy('sort_order')"
                            :custom-validations="[
                                'contact_address' => [
                                    'max:100',
                                ],
                                'postcode' => [
                                    'postcode',
                                ],
                            ]"
                            :entity="$warehouse"
                        />

                        {!! view_render_event('admin.settings.warehouses.edit.left.form_controls.after', ['warehouse' => $warehouse]) !!}
                    </div>
                </div>

                <!-- Right sub-component -->
                <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                    <x-admin::accordion>
                        <x-slot:header>
                            <div class="flex items-center justify-between">
                                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('admin::app.settings.roles.create.general')
                                </p>
                            </div>
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('admin.settings.warehouses.edit.right.form_controls.before', ['warehouse' => $warehouse]) !!}

                            <x-admin::attributes
                                :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                    ['code', 'IN', ['name', 'description']],
                                    'entity_type' => 'warehouses',
                                ])->sortBy('sort_order')"
                                :entity="$warehouse"
                            />

                            {!! view_render_event('admin.settings.warehouses.edit.right.form_controls.after', ['warehouse' => $warehouse]) !!}
                        </x-slot>
                    </x-admin::accordion>
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.settings.warehouses.edit.form.after', ['warehouse' => $warehouse]) !!}
</x-admin::layouts>
