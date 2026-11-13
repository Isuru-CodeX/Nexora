<x-admin::layouts>
    <x-slot:title>
        {{ strip_tags($product->name) }}
    </x-slot>

    <!-- Content -->
    <div class="nexora-animate-in flex gap-6 max-lg:flex-wrap">
        <!-- Left Panel -->
        {!! view_render_event('admin.products.view.left.before', ['product' => $product]) !!}

        <div class="nexora-card max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[400px] max-w-[400px] flex-col self-start rounded-2xl border border-gray-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
            <!-- Product Information -->
            <div class="flex w-full flex-col gap-4 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
                <!-- Breadcrumbs & Edit Button -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs name="products.view" :entity="$product" />

                    @if (bouncer()->hasPermission('products.edit'))
                        <a
                            href="{{ route('admin.products.edit', $product->id) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200/80 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-[#5A4DB9] hover:text-[#5A4DB9] dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-indigo-400 dark:hover:text-indigo-400"
                        >
                            <span class="icon-edit text-sm"></span>
                            @lang('admin::app.products.index.datagrid.edit')
                        </a>
                    @endif
                </div>

                {!! view_render_event('admin.products.view.left.tags.before', ['product' => $product]) !!}

                <!-- Tags -->
                <x-admin::tags
                    :attach-endpoint="route('admin.products.tags.attach', $product->id)"
                    :detach-endpoint="route('admin.products.tags.detach', $product->id)"
                    :added-tags="$product->tags"
                />

                {!! view_render_event('admin.products.view.left.tags.after', ['product' => $product]) !!}

                <!-- Product Identity Banner -->
                <div class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-r from-violet-50/60 via-transparent to-cyan-50/40 p-3.5 dark:border-gray-800 dark:from-violet-950/20 dark:to-cyan-950/10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-[#5A4DB9] to-[#01C7F4] text-white shadow-md shadow-[#5A4DB9]/25">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>

                    <div class="flex flex-col gap-0.5 truncate">
                        {!! view_render_event('admin.products.view.left.title.before', ['product' => $product]) !!}

                        <h3 class="truncate text-base font-bold text-gray-900 dark:text-white">
                            {{ $product->name }}
                        </h3>

                        {!! view_render_event('admin.products.view.left.title.after', ['product' => $product]) !!}

                        <p class="font-mono text-xs text-gray-500 dark:text-gray-400">
                            {{ $product->sku ?: 'SKU-'.$product->id }}
                        </p>
                    </div>
                </div>

                <!-- Key Metrics Grid -->
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-3 dark:border-gray-800 dark:bg-gray-800/50">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Unit Price</span>
                        <div class="text-base font-extrabold text-[#5A4DB9] dark:text-indigo-400">
                            {!! core()->formatBasePrice($product->price, true) !!}
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-3 dark:border-gray-800 dark:bg-gray-800/50">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Inventory</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-base font-extrabold text-gray-900 dark:text-white">
                                {{ (float) $product->quantity }}
                            </span>
                            @if ((float) $product->quantity > 10)
                                <span class="rounded-full bg-emerald-100 px-1.5 py-0.5 text-[9px] font-bold text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300">In Stock</span>
                            @elseif ((float) $product->quantity > 0)
                                <span class="rounded-full bg-amber-100 px-1.5 py-0.5 text-[9px] font-bold text-amber-700 dark:bg-amber-950/80 dark:text-amber-300">Low</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-1.5 py-0.5 text-[9px] font-bold text-rose-700 dark:bg-rose-950/80 dark:text-rose-300">Empty</span>
                            @endif
                        </div>
                    </div>
                </div>

                {!! view_render_event('admin.products.view.left.activity_actions.before', ['product' => $product]) !!}

                <!-- Activity Actions -->
                <div class="flex flex-wrap gap-2">
                    {!! view_render_event('admin.products.view.left.activity_actions.note.before', ['product' => $product]) !!}

                    <!-- Note Activity Action -->
                    <x-admin::activities.actions.note
                        :entity="$product"
                        entity-control-name="product_id"
                    />

                    {!! view_render_event('admin.products.view.left.activity_actions.note.after', ['product' => $product]) !!}

                    {!! view_render_event('admin.products.view.left.activity_actions.file.before', ['product' => $product]) !!}

                    <!-- File Activity Action -->
                    <x-admin::activities.actions.file
                        :entity="$product"
                        entity-control-name="product_id"
                    />

                    {!! view_render_event('admin.products.view.left.activity_actions.file.after', ['product' => $product]) !!}
                </div>

                {!! view_render_event('admin.products.view.left.activity_actions.after', ['product' => $product]) !!}
            </div>
            
            <!-- Product Attributes -->
            @include ('admin::products.view.attributes')
        </div>

        {!! view_render_event('admin.products.view.left.after', ['product' => $product]) !!}

        {!! view_render_event('admin.products.view.right.before', ['product' => $product]) !!}
        
        <!-- Right Panel -->
        <div class="flex w-full flex-col gap-4 rounded-2xl">
            {!! view_render_event('admin.products.view.right.activities.before', ['product' => $product]) !!}

            <!-- Activity Navigation -->
            <x-admin::activities
                :endpoint="route('admin.products.activities.index', $product->id)" 
                :types="[
                    ['name' => 'all', 'label' => trans('admin::app.products.view.all')],
                    ['name' => 'note', 'label' => trans('admin::app.products.view.notes')],
                    ['name' => 'file', 'label' => trans('admin::app.products.view.files')],
                    ['name' => 'system', 'label' => trans('admin::app.products.view.change-logs')],
                ]"
                :extra-types="[
                    ['name' => 'inventory', 'label' => trans('admin::app.products.view.inventories')],
                ]"
            >
                <x-slot:inventory>
                    @include('admin::products.view.inventory')
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.products.view.right.activities.after', ['product' => $product]) !!}
        </div>

        {!! view_render_event('admin.products.view.right.after', ['product' => $product]) !!}
    </div>    
</x-admin::layouts>