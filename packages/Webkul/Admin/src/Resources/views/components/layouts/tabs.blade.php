@php
    $tabs = menu()->getCurrentActiveMenu('admin')?->getChildren();
@endphp

@if (
    $tabs
    && $tabs->isNotEmpty()
)
    <div class="tabs">
        <div class="mb-5 flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pt-1 overflow-x-auto max-sm:hidden">
            @foreach ($tabs as $tab)
                <a
                    href="{{ $tab->getUrl() }}"
                    role="tab"
                    data-tab="{{ $tab->getKey() }}"
                    class="group relative inline-flex items-center gap-2 px-3.5 py-2.5 text-sm font-medium transition-all duration-200 select-none {{ $tab->isActive() ? 'text-[#5A4DB9] dark:text-[#01C7F4] font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100/70 dark:hover:bg-gray-800/60 rounded-t-lg' }}"
                >
                    <span>{{ $tab->getName() }}</span>
                    @if ($tab->isActive())
                        <span class="absolute bottom-[-1px] left-0 right-0 h-[2.5px] rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3] shadow-[0_0_8px_rgba(1,199,244,0.6)]"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endif
