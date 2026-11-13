<div class="p-4">
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="icon-quote text-xl text-brandColor dark:text-cyan-400"></span>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                @lang('admin::app.contacts.persons.view.tabs.quotes-title', ['default' => 'Associated Quotations'])
                <span class="ml-1.5 rounded-full bg-brandColor/10 px-2 py-0.5 text-xs font-semibold text-brandColor dark:bg-cyan-500/10 dark:text-cyan-400">
                    {{ $person->quotes->count() }}
                </span>
            </h3>
        </div>

        @if (bouncer()->hasPermission('quotes.create'))
            <a
                href="{{ route('admin.quotes.create') }}?person_id={{ $person->id }}"
                class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-cyan-500 to-indigo-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:opacity-90"
            >
                <span class="icon-add text-sm"></span>
                @lang('admin::app.quotes.index.create-btn')
            </a>
        @endif
    </div>

    @if ($person->quotes->isNotEmpty())
        <div class="overflow-x-auto rounded-xl border border-gray-200/80 bg-white dark:border-gray-800/80 dark:bg-gray-900/60">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-200/80 bg-gray-50/70 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-800/80 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">@lang('admin::app.quotes.index.datagrid.subject')</th>
                        <th class="px-4 py-3">@lang('admin::app.quotes.index.datagrid.grand-total')</th>
                        <th class="px-4 py-3">@lang('admin::app.quotes.index.datagrid.expired-at')</th>
                        <th class="px-4 py-3">@lang('admin::app.quotes.index.datagrid.created-at')</th>
                        <th class="px-4 py-3 text-right">@lang('admin::app.quotes.index.datagrid.actions')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/60">
                    @foreach ($person->quotes as $quote)
                        <tr class="transition hover:bg-gray-50/60 dark:hover:bg-gray-800/40">
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('admin.quotes.edit', $quote->id) }}"
                                    class="font-semibold text-gray-900 hover:text-brandColor dark:text-white dark:hover:text-cyan-400"
                                >
                                    {{ $quote->subject }}
                                </a>
                                @if ($quote->description)
                                    <p class="truncate max-w-xs text-xs text-gray-400 dark:text-gray-500">
                                        {{ $quote->description }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                {{ core()->formatBasePrice($quote->grand_total) }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                {{ $quote->expired_at ? $quote->expired_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                {{ $quote->created_at?->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        href="{{ route('admin.quotes.edit', $quote->id) }}"
                                        class="rounded-lg p-1 text-gray-500 transition hover:bg-gray-100 hover:text-brandColor dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-cyan-400"
                                        title="@lang('admin::app.quotes.index.datagrid.edit')"
                                    >
                                        <span class="icon-edit text-base"></span>
                                    </a>
                                    <a
                                        href="{{ route('admin.quotes.print', $quote->id) }}"
                                        target="_blank"
                                        class="rounded-lg p-1 text-gray-500 transition hover:bg-gray-100 hover:text-brandColor dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-cyan-400"
                                        title="@lang('admin::app.quotes.index.datagrid.print')"
                                    >
                                        <span class="icon-printer text-base"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200/80 bg-gray-50/50 p-10 text-center dark:border-gray-800 dark:bg-gray-900/40">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brandColor/10 text-brandColor dark:bg-cyan-500/10 dark:text-cyan-400">
                <span class="icon-quote text-3xl"></span>
            </div>
            <h4 class="mt-4 text-base font-bold text-gray-900 dark:text-white">
                @lang('admin::app.contacts.persons.view.tabs.no-quotes', ['default' => 'No quotations generated for this contact'])
            </h4>
            <p class="mt-1 max-w-sm text-xs text-gray-500 dark:text-gray-400">
                @lang('admin::app.contacts.persons.view.tabs.no-quotes-info', ['default' => 'Draft professional proposals, calculate taxes, and send for digital signature.'])
            </p>
            @if (bouncer()->hasPermission('quotes.create'))
                <a
                    href="{{ route('admin.quotes.create') }}?person_id={{ $person->id }}"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-cyan-500 to-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-cyan-500/20 transition hover:opacity-90"
                >
                    <span class="icon-add text-sm"></span>
                    @lang('admin::app.quotes.index.create-btn')
                </a>
            @endif
        </div>
    @endif
</div>
