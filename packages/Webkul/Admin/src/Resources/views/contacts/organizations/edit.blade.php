
<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.contacts.organizations.edit.title')
    </x-slot>

    {!! view_render_event('admin.organizations.edit.form.before') !!}

    <x-admin::form
        :action="route('admin.contacts.organizations.update', $organization->id)"
        method="PUT"
    >
        <div class="nexora-animate-in flex flex-col gap-4">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-2">
                    {!! view_render_event('admin.organizations.edit.breadcrumbs.before', ['organization' => $organization]) !!}

                    <x-admin::breadcrumbs 
                        name="contacts.organizations.edit" 
                        :entity="$organization"
                    />

                    {!! view_render_event('admin.organizations.edit.breadcrumbs.before', ['organization' => $organization]) !!}

                    <div class="text-xl font-bold dark:text-gray-300">
                        @lang('admin::app.contacts.organizations.edit.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <div class="flex items-center gap-x-2.5">
                        {!! view_render_event('admin.organizations.edit.save_button.before', ['organization' => $organization]) !!}

                        <!-- Save button for person -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('admin::app.contacts.organizations.edit.save-btn')
                        </button>

                        {!! view_render_event('admin.organizations.edit.save_button.after', ['organization' => $organization]) !!}
                    </div>
                </div>
            </div>

            <div class="nexora-card flex flex-col gap-4 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                {!! view_render_event('admin.contacts.organizations.edit.form_controls.before') !!}

                <x-admin::attributes
                    :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                        'entity_type' => 'organizations',
                    ])"
                    :custom-validations="[
                        'name' => [
                            'max:100',
                        ],
                        'address' => [
                            'max:100',
                        ],
                        'postcode' => [
                            'postcode',
                        ],
                    ]"
                    :entity="$organization"
                    :can-add-new="false"
                />
                
                {!! view_render_event('admin.contacts.organizations.edit.form_controls.after') !!}
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.organizations.edit.form.after') !!}
</x-admin::layouts>
