
<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.contacts.persons.edit.title')
    </x-slot>

    {!! view_render_event('admin.persons.edit.form.before') !!}

    <x-admin::form
        :action="route('admin.contacts.persons.update', $person->id)"
        method="PUT"
        enctype="multipart/form-data"
    >
        <div class="nexora-animate-in flex flex-col gap-5">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-1.5">
                    {!! view_render_event('admin.persons.edit.breadcrumbs.before') !!}

                    <x-admin::breadcrumbs
                        name="contacts.persons.edit"
                        :entity="$person"
                    />

                    {!! view_render_event('admin.persons.edit.breadcrumbs.after') !!}

                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $person->name ?: trans('admin::app.contacts.persons.edit.title') }}
                        </h1>

                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            #{{ $person->id }}
                        </span>

                        @if ($person->job_title)
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700 dark:bg-gray-800 dark:text-gray-300">
                                {{ $person->job_title }}
                            </span>
                        @endif

                        @if ($person->organization)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-2.5 py-0.5 text-xs font-medium text-violet-700 dark:bg-violet-950/50 dark:text-violet-300 border border-violet-200/60 dark:border-violet-800/60">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $person->organization->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    {!! view_render_event('admin.persons.edit.save_button.before') !!}

                    <!-- View Profile Link -->
                    <a
                        href="{{ route('admin.contacts.persons.view', $person->id) }}"
                        class="secondary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>View Profile</span>
                    </a>

                    <button
                        type="submit"
                        class="primary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @lang('admin::app.contacts.persons.edit.save-btn')
                    </button>

                    {!! view_render_event('admin.persons.edit.save_button.after') !!}
                </div>
            </div>

            <!-- Two-Column Form Layout -->
            <div class="flex gap-6 max-xl:flex-wrap">
                <!-- Left Main Form Card -->
                <div class="nexora-card flex flex-1 flex-col gap-6 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 max-xl:flex-auto transition-all duration-300">
                    <!-- Profile Identity Header Banner -->
                    <div class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-r from-violet-50/60 via-transparent to-cyan-50/40 p-4 dark:border-gray-800 dark:from-violet-950/20 dark:to-cyan-950/10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-tr from-[#5A4DB9] to-[#01C7F4] text-lg font-bold text-white shadow-md shadow-[#5A4DB9]/25">
                            {{ strtoupper(substr($person->name, 0, 2)) }}
                        </div>

                        <div class="flex flex-col gap-0.5">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $person->name }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $person->job_title ?: 'Contact Person' }}
                                @if ($person->organization)
                                    &bull; <span class="font-medium text-[#5A4DB9] dark:text-indigo-400">{{ $person->organization->name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {!! view_render_event('admin.contacts.persons.edit.form_controls.before') !!}

                    <!-- Contact Attributes -->
                    <x-admin::attributes
                        :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                            ['code', 'NOTIN', ['organization_id']],
                            'entity_type' => 'persons',
                        ])"
                        :custom-validations="[
                            'name' => [
                                'min:2',
                                'max:100',
                            ],
                            'job_title' => [
                                'max:100',
                            ],
                        ]"
                        :entity="$person"
                    />

                    <!-- Organization Lookup -->
                    <v-organization></v-organization>

                    {!! view_render_event('admin.contacts.persons.edit.form_controls.after') !!}
                </div>

                <!-- Right Sidebar Overview Card -->
                <div class="flex w-[340px] max-w-full flex-col gap-4 max-xl:w-full">
                    <div class="nexora-card flex flex-col gap-4 rounded-2xl border border-gray-200/80 bg-white/90 p-5 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Contact Summary
                            </span>
                        </div>

                        <!-- Quick Contact Pills -->
                        @php
                            $primaryEmail = is_array($person->emails) ? ($person->emails[0]['value'] ?? null) : null;
                            $primaryPhone = is_array($person->contact_numbers) ? ($person->contact_numbers[0]['value'] ?? null) : null;
                        @endphp

                        <div class="flex flex-col gap-2.5">
                            @if ($primaryEmail)
                                <a
                                    href="mailto:{{ $primaryEmail }}"
                                    class="flex items-center gap-2.5 rounded-xl border border-gray-200/70 bg-gray-50/60 p-2.5 text-xs text-gray-700 transition hover:border-[#5A4DB9] hover:bg-white dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-300 dark:hover:bg-gray-800"
                                >
                                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-50 text-[#5A4DB9] dark:bg-indigo-950/80">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <span class="truncate font-medium">{{ $primaryEmail }}</span>
                                </a>
                            @endif

                            @if ($primaryPhone)
                                <a
                                    href="tel:{{ $primaryPhone }}"
                                    class="flex items-center gap-2.5 rounded-xl border border-gray-200/70 bg-gray-50/60 p-2.5 text-xs text-gray-700 transition hover:border-emerald-500 hover:bg-white dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-300 dark:hover:bg-gray-800"
                                >
                                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/80">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </span>
                                    <span class="truncate font-medium">{{ $primaryPhone }}</span>
                                </a>
                            @endif
                        </div>

                        <!-- Metadata Info -->
                        <div class="flex flex-col gap-2 pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center justify-between">
                                <span>Record ID</span>
                                <span class="font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $person->id }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Created</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ core()->formatDate($person->created_at, 'M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.persons.edit.form.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-organization-template"
        >
            <div>
                <x-admin::attributes
                    :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                        ['code', 'IN', ['organization_id']],
                        'entity_type' => 'persons',
                    ])"
                    :entity="$person"
                />

                <template v-if="organizationName">
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="organization_name"
                        v-model="organizationName"
                    />
                </template>
            </div>
        </script>

        <script type="module">
            app.component('v-organization', {
                template: '#v-organization-template',

                data() {
                    return {
                        organizationName: null,
                    };
                },

                methods: {
                    handleLookupAdded(event) {
                        this.organizationName = event?.name || null;
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
