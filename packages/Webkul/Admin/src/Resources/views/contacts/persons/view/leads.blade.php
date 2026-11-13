<div class="p-4">
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="icon-leads text-xl text-brandColor dark:text-cyan-400"></span>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                @lang('admin::app.contacts.persons.view.tabs.leads-title', ['default' => 'Associated Deals & Leads'])
                <span class="ml-1.5 rounded-full bg-brandColor/10 px-2 py-0.5 text-xs font-semibold text-brandColor dark:bg-cyan-500/10 dark:text-cyan-400">
                    {{ $person->leads->count() }}
                </span>
            </h3>
        </div>

        @if (bouncer()->hasPermission('leads.create'))
            <a
                href="{{ route('admin.leads.create') }}?person_id={{ $person->id }}"
                class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-cyan-500 to-indigo-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:opacity-90"
            >
                <span class="icon-add text-sm"></span>
                @lang('admin::app.leads.index.create-btn')
            </a>
        @endif
    </div>

    @if ($person->leads->isNotEmpty())
        <div class="overflow-x-auto rounded-xl border border-gray-200/80 bg-white dark:border-gray-800/80 dark:bg-gray-900/60">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-200/80 bg-gray-50/70 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-800/80 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">@lang('admin::app.leads.view.tabs.description')</th>
                        <th class="px-4 py-3">@lang('admin::app.leads.view.stages.stage')</th>
                        <th class="px-4 py-3">@lang('admin::app.leads.view.attributes.lead-value')</th>
                        <th class="px-4 py-3">@lang('admin::app.leads.index.datagrid.status')</th>
                        <th class="px-4 py-3">@lang('admin::app.leads.index.datagrid.created-at')</th>
                        <th class="px-4 py-3 text-right">@lang('admin::app.leads.index.datagrid.actions')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/60">
                    @foreach ($person->leads as $lead)
                        <tr class="transition hover:bg-gray-50/60 dark:hover:bg-gray-800/40">
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('admin.leads.view', $lead->id) }}"
                                    class="font-semibold text-gray-900 hover:text-brandColor dark:text-white dark:hover:text-cyan-400"
                                >
                                    {{ $lead->title }}
                                </a>
                                @if ($lead->pipeline)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $lead->pipeline->name }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($lead->stage)
                                    <span class="inline-flex items-center rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                        {{ $lead->stage->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                {{ core()->formatBasePrice($lead->lead_value) }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($lead->status === 1)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        @lang('admin::app.leads.index.datagrid.won')
                                    </span>
                                @elseif ($lead->status === 0)
                                    <span class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-800 dark:bg-rose-900/40 dark:text-rose-300">
                                        @lang('admin::app.leads.index.datagrid.lost')
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                        @lang('admin::app.leads.index.datagrid.open')
                                    </span>
                                @endif

                                @if (($days = $lead->rotten_days) > 0)
                                    <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-800 dark:bg-amber-900/40 dark:text-amber-300" title="{{ $days }} days without activity">
                                        <span class="icon-rotten text-xs"></span>
                                        {{ $days }}d
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                {{ $lead->created_at?->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a
                                    href="{{ route('admin.leads.view', $lead->id) }}"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-brandColor hover:underline dark:text-cyan-400"
                                >
                                    @lang('admin::app.contacts.persons.index.datagrid.view')
                                    <span class="icon-arrow-right text-xs"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200/80 bg-gray-50/50 p-10 text-center dark:border-gray-800 dark:bg-gray-900/40">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brandColor/10 text-brandColor dark:bg-cyan-500/10 dark:text-cyan-400">
                <span class="icon-leads text-3xl"></span>
            </div>
            <h4 class="mt-4 text-base font-bold text-gray-900 dark:text-white">
                @lang('admin::app.contacts.persons.view.tabs.no-leads', ['default' => 'No active deals for this contact'])
            </h4>
            <p class="mt-1 max-w-sm text-xs text-gray-500 dark:text-gray-400">
                @lang('admin::app.contacts.persons.view.tabs.no-leads-info', ['default' => 'Create a deal to track pipeline progress, revenue forecasts, and sales stages.'])
            </p>
            @if (bouncer()->hasPermission('leads.create'))
                <a
                    href="{{ route('admin.leads.create') }}?person_id={{ $person->id }}"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-cyan-500 to-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-cyan-500/20 transition hover:opacity-90"
                >
                    <span class="icon-add text-sm"></span>
                    @lang('admin::app.leads.index.create-btn')
                </a>
            @endif
        </div>
    @endif
</div>
