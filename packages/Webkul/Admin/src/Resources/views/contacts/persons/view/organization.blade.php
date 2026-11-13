{!! view_render_event('admin.contacts.persons.view.organization.before', ['person' => $person]) !!}

@if ($person?->organization)
    <div class="flex w-full flex-col gap-3 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
        <div class="flex items-center justify-between">
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                @lang('admin::app.contacts.persons.view.about-organization')
            </h4>

            @if (bouncer()->hasPermission('contacts.organizations.edit'))
                <a
                    href="{{ route('admin.contacts.organizations.edit', $person->organization->id) }}"
                    class="rounded-lg p-1 text-gray-500 transition hover:bg-gray-100 hover:text-brandColor dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-cyan-400"
                    title="@lang('admin::app.contacts.organizations.index.datagrid.edit')"
                >
                    <span class="icon-edit text-base"></span>
                </a>
            @endif
        </div>

        <div class="flex items-start gap-3">
            {!! view_render_event('admin.contacts.persons.view.organization.avatar.before', ['person' => $person]) !!}

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-cyan-600 to-indigo-700 text-sm font-bold text-white shadow-sm">
                {{ strtoupper(substr($person->organization->name, 0, 2)) }}
            </div>

            {!! view_render_event('admin.contacts.persons.view.organization.avatar.after', ['person' => $person]) !!}

            <div class="flex flex-col gap-1 min-w-0">
                {!! view_render_event('admin.contacts.persons.view.organization.name.before', ['person' => $person]) !!}

                <a
                    href="{{ route('admin.contacts.organizations.edit', $person->organization->id) }}"
                    class="font-bold text-gray-900 transition hover:text-brandColor dark:text-white dark:hover:text-cyan-400"
                >
                    {{ $person->organization->name }}
                </a>

                {!! view_render_event('admin.contacts.persons.view.organization.name.after', ['person' => $person]) !!}

                {!! view_render_event('admin.contacts.persons.view.organization.address.before', ['person' => $person]) !!}

                @if ($person->organization->address)
                    <div class="flex flex-col gap-0.5 text-xs text-gray-500 dark:text-gray-400">
                        @isset($person->organization->address['address'])
                            <span>{{ $person->organization->address['address'] }}</span>
                        @endisset

                        @php
                            $locality = collect([
                                $person->organization->address['city'] ?? null,
                                isset($person->organization->address['state']) ? core()->state_name($person->organization->address['state']) : null,
                                $person->organization->address['postcode'] ?? null,
                            ])->filter()->implode(', ');
                        @endphp

                        @if ($locality)
                            <span>{{ $locality }}</span>
                        @endif

                        @isset($person->organization->address['country'])
                            <span class="font-medium text-gray-600 dark:text-gray-300">
                                {{ core()->country_name($person->organization->address['country']) }}
                            </span>
                        @endisset
                    </div>
                @endif

                {!! view_render_event('admin.contacts.persons.view.organization.address.after', ['person' => $person]) !!}
            </div>
        </div>
    </div>
@else
    <div class="flex w-full flex-col gap-2 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
            @lang('admin::app.contacts.persons.view.about-organization')
        </h4>
        <div class="flex items-center justify-between rounded-xl bg-gray-50/70 p-3 dark:bg-gray-800/40">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                @lang('admin::app.contacts.persons.view.no-organization', ['default' => 'No organization linked'])
            </span>
            @if (bouncer()->hasPermission('contacts.persons.edit'))
                <a
                    href="{{ route('admin.contacts.persons.edit', $person->id) }}"
                    class="text-xs font-semibold text-brandColor hover:underline dark:text-cyan-400"
                >
                    + Link
                </a>
            @endif
        </div>
    </div>
@endif

{!! view_render_event('admin.contacts.persons.view.organization.after', ['person' => $person]) !!}
