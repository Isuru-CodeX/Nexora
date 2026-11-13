<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.contacts.persons.view.title', ['name' => strip_tags($person->name)])
    </x-slot>

    <!-- Content -->
    <div class="nexora-animate-in flex gap-4 max-lg:flex-wrap">
        <!-- Left Panel -->
        {!! view_render_event('admin.contact.persons.view.left.before', ['person' => $person]) !!}

        <div class="nexora-card max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-2xl border border-gray-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
            <!-- Person Information -->
            <div class="flex w-full flex-col gap-3 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
                <!-- Breadcrumbs & Quick Edit -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs
                        name="contacts.persons.view"
                        :entity="$person"
                    />

                    @if (bouncer()->hasPermission('contacts.persons.edit'))
                        <a
                            href="{{ route('admin.contacts.persons.edit', $person->id) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-brandColor hover:text-brandColor dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:border-cyan-400 dark:hover:text-cyan-400"
                        >
                            <span class="icon-edit text-sm"></span>
                            @lang('admin::app.contacts.persons.index.datagrid.edit')
                        </a>
                    @endif
                </div>

                {!! view_render_event('admin.contact.persons.view.tags.before', ['person' => $person]) !!}

                <!-- Tags -->
                <x-admin::tags
                    :attach-endpoint="route('admin.contacts.persons.tags.attach', $person->id)"
                    :detach-endpoint="route('admin.contacts.persons.tags.detach', $person->id)"
                    :added-tags="$person->tags"
                />

                {!! view_render_event('admin.contact.persons.view.tags.after', ['person' => $person]) !!}

                <!-- Person Profile Card -->
                <div class="my-1 flex items-start gap-3.5">
                    {!! view_render_event('admin.contact.persons.view.title.before', ['person' => $person]) !!}

                    @php
                        $initials = collect(explode(' ', $person->name))
                            ->filter()
                            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                            ->take(2)
                            ->implode('');
                    @endphp

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-cyan-500 to-indigo-600 text-lg font-bold text-white shadow-md shadow-cyan-500/20">
                        {{ $initials ?: 'CP' }}
                    </div>

                    <div class="flex flex-1 flex-col gap-0.5 min-w-0">
                        <h1 class="truncate text-lg font-bold text-gray-900 dark:text-white" title="{{ $person->name }}">
                            {{ $person->name }}
                        </h1>

                        @if ($person->job_title)
                            <p class="truncate text-xs font-medium text-gray-500 dark:text-gray-400">
                                {{ $person->job_title }}
                            </p>
                        @endif

                        @if ($person->organization)
                            <a
                                href="{{ route('admin.contacts.organizations.edit', $person->organization->id) }}"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-brandColor hover:underline dark:text-cyan-400"
                            >
                                <span class="icon-organization text-xs"></span>
                                {{ $person->organization->name }}
                            </a>
                        @endif
                    </div>

                    {!! view_render_event('admin.contact.persons.view.title.after', ['person' => $person]) !!}
                </div>

                <!-- Quick Contact Information -->
                @php
                    $emails = collect($person->emails ?? [])->pluck('value')->filter()->values()->toArray();
                    $phones = collect($person->contact_numbers ?? [])->pluck('value')->filter()->values()->toArray();
                @endphp

                @if (! empty($emails) || ! empty($phones))
                    <div class="flex flex-col gap-1.5 pt-1">
                        @foreach ($emails as $email)
                            <a
                                href="mailto:{{ $email }}"
                                class="inline-flex items-center gap-2 truncate rounded-lg bg-gray-50 px-2.5 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-brandColor/10 hover:text-brandColor dark:bg-gray-800/60 dark:text-gray-300 dark:hover:bg-cyan-500/10 dark:hover:text-cyan-400"
                            >
                                <span class="icon-mail text-sm text-gray-400"></span>
                                <span class="truncate">{{ $email }}</span>
                            </a>
                        @endforeach

                        @foreach ($phones as $phone)
                            <a
                                href="tel:{{ $phone }}"
                                class="inline-flex items-center gap-2 truncate rounded-lg bg-gray-50 px-2.5 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-brandColor/10 hover:text-brandColor dark:bg-gray-800/60 dark:text-gray-300 dark:hover:bg-cyan-500/10 dark:hover:text-cyan-400"
                            >
                                <span class="icon-phone text-sm text-gray-400"></span>
                                <span class="truncate">{{ $phone }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <!-- Activity Actions -->
                <div class="mt-2 flex flex-wrap gap-2">
                    {!! view_render_event('admin.contact.persons.view.actions.before', ['person' => $person]) !!}

                    @if (bouncer()->hasPermission('mail.compose'))
                        <!-- Mail Activity Action -->
                        <x-admin::activities.actions.mail
                            :entity="$person"
                            :emails="$emails"
                            entity-control-name="person_id"
                        />
                    @endif

                    @if (bouncer()->hasPermission('activities.create'))
                        <!-- File Activity Action -->
                        <x-admin::activities.actions.file
                            :entity="$person"
                            entity-control-name="person_id"
                        />

                        <!-- Note Activity Action -->
                        <x-admin::activities.actions.note
                            :entity="$person"
                            entity-control-name="person_id"
                        />

                        <!-- Activity Action -->
                        <x-admin::activities.actions.activity
                            :entity="$person"
                            entity-control-name="person_id"
                        />
                    @endif

                    {!! view_render_event('admin.contact.persons.view.actions.after', ['person' => $person]) !!}
                </div>
            </div>

            <!-- Person Attributes -->
            @include ('admin::contacts.persons.view.attributes')

            <!-- Contact Organization -->
            @include ('admin::contacts.persons.view.organization')
        </div>

        {!! view_render_event('admin.contact.persons.view.left.after', ['person' => $person]) !!}

        <!-- Right Panel -->
        <div class="flex w-full flex-col gap-4 rounded-2xl">
            {!! view_render_event('admin.contact.persons.view.right.before', ['person' => $person]) !!}

            <!-- Activities Navigation & Extended Tabs -->
            <x-admin::activities
                :endpoint="route('admin.contacts.persons.activities.index', $person->id)"
                :activeType="request()->query('tab') ?? 'all'"
                :extra-types="[
                    ['name' => 'leads', 'label' => trans('admin::app.contacts.persons.view.tabs.leads') ?? 'Deals / Leads'],
                    ['name' => 'quotes', 'label' => trans('admin::app.contacts.persons.view.tabs.quotes') ?? 'Quotes'],
                ]"
            >
                <!-- Leads / Deals Tab -->
                <x-slot:leads>
                    @include ('admin::contacts.persons.view.leads')
                </x-slot>

                <!-- Quotes Tab -->
                <x-slot:quotes>
                    @include ('admin::contacts.persons.view.quotes')
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.contact.persons.view.right.after', ['person' => $person]) !!}
        </div>
    </div>
</x-admin::layouts>
