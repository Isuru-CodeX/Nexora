
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
        <div class="nexora-animate-in flex flex-col gap-5">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-1.5">
                    {!! view_render_event('admin.organizations.edit.breadcrumbs.before', ['organization' => $organization]) !!}

                    <x-admin::breadcrumbs 
                        name="contacts.organizations.edit" 
                        :entity="$organization"
                    />

                    {!! view_render_event('admin.organizations.edit.breadcrumbs.after', ['organization' => $organization]) !!}

                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $organization->name ?: trans('admin::app.contacts.organizations.edit.title') }}
                        </h1>

                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            #{{ $organization->id }}
                        </span>

                        @php
                            $contactsCount = $organization->persons ? $organization->persons->count() : 0;
                        @endphp
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-cyan-50 px-2.5 py-0.5 text-xs font-medium text-cyan-700 dark:bg-cyan-950/50 dark:text-cyan-300 border border-cyan-200/60 dark:border-cyan-800/60">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ $contactsCount }} {{ $contactsCount === 1 ? 'Contact' : 'Contacts' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    {!! view_render_event('admin.organizations.edit.save_button.before', ['organization' => $organization]) !!}

                    <!-- Save button for organization -->
                    <button
                        type="submit"
                        class="primary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @lang('admin::app.contacts.organizations.edit.save-btn')
                    </button>

                    {!! view_render_event('admin.organizations.edit.save_button.after', ['organization' => $organization]) !!}
                </div>
            </div>

            <!-- Two-Column Form Layout -->
            <div class="flex gap-6 max-xl:flex-wrap">
                <!-- Left Main Form Card -->
                <div class="nexora-card flex flex-1 flex-col gap-6 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 max-xl:flex-auto transition-all duration-300">
                    <!-- Organization Banner -->
                    <div class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-r from-violet-50/60 via-transparent to-cyan-50/40 p-4 dark:border-gray-800 dark:from-violet-950/20 dark:to-cyan-950/10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-tr from-[#5A4DB9] to-[#01C7F4] text-white shadow-md shadow-[#5A4DB9]/25">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>

                        <div class="flex flex-col gap-0.5">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $organization->name }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Organization Profile &bull; {{ $contactsCount }} linked {{ $contactsCount === 1 ? 'person' : 'people' }}
                            </p>
                        </div>
                    </div>

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

                <!-- Right Sidebar Overview Card -->
                <div class="flex w-[340px] max-w-full flex-col gap-4 max-xl:w-full">
                    <div class="nexora-card flex flex-col gap-4 rounded-2xl border border-gray-200/80 bg-white/90 p-5 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Organization Overview
                            </span>
                        </div>

                        <!-- Associated Contacts Quick List -->
                        @if ($organization->persons && $organization->persons->isNotEmpty())
                            <div class="flex flex-col gap-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                                    Key Contacts ({{ $contactsCount }})
                                </span>

                                <div class="flex flex-col gap-2 max-h-48 overflow-y-auto pr-1">
                                    @foreach ($organization->persons->take(5) as $person)
                                        <a
                                            href="{{ route('admin.contacts.persons.view', $person->id) }}"
                                            class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50/60 p-2 text-xs text-gray-700 transition hover:border-[#5A4DB9] hover:bg-white dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-300"
                                        >
                                            <div class="flex items-center gap-2 truncate">
                                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-violet-100 text-[10px] font-bold text-[#5A4DB9] dark:bg-violet-900/60 dark:text-violet-300">
                                                    {{ strtoupper(substr($person->name, 0, 1)) }}
                                                </div>
                                                <span class="truncate font-medium">{{ $person->name }}</span>
                                            </div>
                                            @if ($person->job_title)
                                                <span class="text-[10px] text-gray-400 truncate max-w-[100px]">{{ $person->job_title }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Metadata Info -->
                        <div class="flex flex-col gap-2 pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center justify-between">
                                <span>Record ID</span>
                                <span class="font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $organization->id }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Created</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ core()->formatDate($organization->created_at, 'M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.organizations.edit.form.after') !!}
</x-admin::layouts>
