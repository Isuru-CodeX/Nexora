<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.leads.view.title', ['title' => strip_tags($lead->title)])
    </x-slot>

    <!-- Content -->
    <div class="nexora-animate-in relative flex gap-4 max-lg:flex-wrap">

        <!-- Left Panel -->
        {!! view_render_event('admin.leads.view.left.before', ['lead' => $lead]) !!}

        <div class="nexora-card max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-2xl border border-gray-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
            <!-- Lead Information -->
            <div class="flex w-full flex-col gap-3 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
                <!-- Breadcrumb's -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs
                        name="leads.view"
                        :entity="$lead"
                    />

                    @if (bouncer()->hasPermission('leads.edit'))
                        <a
                            href="{{ route('admin.leads.edit', $lead->id) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-brandColor hover:text-brandColor dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:border-cyan-400 dark:hover:text-cyan-400"
                        >
                            <span class="icon-edit text-sm"></span>
                            @lang('admin::app.leads.view.edit')
                        </a>
                    @endif
                </div>

                <div class="mb-2">
                    @if (($days = $lead->rotten_days) > 0)
                        @php
                            $lead->tags->prepend([
                                'name' => '<span class="icon-rotten text-base"></span>' . trans('admin::app.leads.view.rotten-days', ['days' => $days]),
                                'color' => '#FEE2E2'
                            ]);
                        @endphp
                    @endif

                    {!! view_render_event('admin.leads.view.tags.before', ['lead' => $lead]) !!}

                    <!-- Tags -->
                    <x-admin::tags
                        :attach-endpoint="route('admin.leads.tags.attach', $lead->id)"
                        :detach-endpoint="route('admin.leads.tags.detach', $lead->id)"
                        :added-tags="$lead->tags"
                    />

                    {!! view_render_event('admin.leads.view.tags.after', ['lead' => $lead]) !!}
                </div>


                {!! view_render_event('admin.leads.view.title.before', ['lead' => $lead]) !!}

                <!-- Title -->
                <h1 class="text-lg font-bold dark:text-white">
                    {{ $lead->title }}
                </h1>

                {!! view_render_event('admin.leads.view.title.after', ['lead' => $lead]) !!}

                <!-- Activity Actions -->
                <div class="flex flex-wrap gap-2">
                    {!! view_render_event('admin.leads.view.actions.before', ['lead' => $lead]) !!}

                    @if (bouncer()->hasPermission('mail.compose'))
                        <!-- Mail Activity Action -->
                        <x-admin::activities.actions.mail
                            :entity="$lead"
                            :emails="collect($lead->person?->emails ?? [])->pluck('value')->filter()->values()->toArray()"
                            entity-control-name="lead_id"
                        />
                    @endif

                    @if (bouncer()->hasPermission('activities.create'))
                        <!-- File Activity Action -->
                        <x-admin::activities.actions.file
                            :entity="$lead"
                            entity-control-name="lead_id"
                        />

                        <!-- Note Activity Action -->
                        <x-admin::activities.actions.note
                            :entity="$lead"
                            entity-control-name="lead_id"
                        />

                        <!-- Activity Action -->
                        <x-admin::activities.actions.activity
                            :entity="$lead"
                            entity-control-name="lead_id"
                        />
                    @endif

                    {!! view_render_event('admin.leads.view.actions.after', ['lead' => $lead]) !!}
                </div>
            </div>

            <!-- Lead Attributes -->
            @include ('admin::leads.view.attributes')

            <!-- Contact Person -->
            @include ('admin::leads.view.person')
        </div>

        {!! view_render_event('admin.leads.view.left.after', ['lead' => $lead]) !!}

        {!! view_render_event('admin.leads.view.right.before', ['lead' => $lead]) !!}

        <!-- Right Panel -->
        <div class="flex w-full flex-col gap-4 rounded-2xl">
            <!-- Stages Navigation -->
            @include ('admin::leads.view.stages')

            <!-- Activities -->
            {!! view_render_event('admin.leads.view.activities.before', ['lead' => $lead]) !!}

            <x-admin::activities
                :endpoint="route('admin.leads.activities.index', $lead->id)"
                :email-detach-endpoint="route('admin.leads.emails.detach', $lead->id)"
                :activeType="request()->query('tab') ?? (request()->query('from') === 'quotes' ? 'quotes' : 'all')"
                :extra-types="[
                    ['name' => 'description', 'label' => trans('admin::app.leads.view.tabs.description')],
                    ['name' => 'products', 'label' => trans('admin::app.leads.view.tabs.products')],
                    ['name' => 'quotes', 'label' => trans('admin::app.leads.view.tabs.quotes')],
                ]"
            >
                <!-- Products -->
                <x-slot:products>
                    @include ('admin::leads.view.products')
                </x-slot>

                <!-- Quotes -->
                <x-slot:quotes>
                    @include ('admin::leads.view.quotes')
                </x-slot>

                <!-- Description -->
                <x-slot:description>
                    <div class="p-4 dark:text-white">
                        {{ $lead->description }}
                    </div>
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.leads.view.activities.after', ['lead' => $lead]) !!}
        </div>

        {!! view_render_event('admin.leads.view.right.after', ['lead' => $lead]) !!}
    </div>
</x-admin::layouts>
