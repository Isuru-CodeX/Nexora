
<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.products.edit.title')
    </x-slot>

    {!! view_render_event('admin.products.edit.form.before') !!}

    <x-admin::form
        :action="route('admin.products.update', $product->id)"
        encType="multipart/form-data"
        method="PUT"
    >
        <div class="nexora-animate-in flex flex-col gap-5">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-1.5">
                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs
                        name="products.edit"
                        :entity="$product"
                    />

                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $product->name ?: trans('admin::app.products.edit.title') }}
                        </h1>

                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60 font-mono">
                            {{ $product->sku ?: 'SKU-'.$product->id }}
                        </span>

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                            {!! core()->formatBasePrice($product->price, true) !!}
                        </span>

                        @if ((float) $product->quantity > 10)
                            <span class="inline-flex items-center gap-1 rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-medium text-teal-700 dark:bg-teal-950/50 dark:text-teal-300 border border-teal-200/60 dark:border-teal-800/60">
                                In Stock ({{ $product->quantity }})
                            </span>
                        @elseif ((float) $product->quantity > 0)
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60">
                                Low Stock ({{ $product->quantity }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-medium text-rose-700 dark:bg-rose-950/50 dark:text-rose-300 border border-rose-200/60 dark:border-rose-800/60">
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    {!! view_render_event('admin.products.edit.create_button.before', ['product' => $product]) !!}
                    
                    <!-- View Product Link -->
                    <a
                        href="{{ route('admin.products.view', $product->id) }}"
                        class="secondary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>View Product</span>
                    </a>

                    <!-- Save button for Product -->
                    <button
                        type="submit"
                        class="primary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @lang('admin::app.products.create.save-btn')
                    </button>

                    {!! view_render_event('admin.products.edit.create_button.after', ['product' => $product]) !!}
                </div>
            </div>

            <div class="flex gap-6 max-xl:flex-wrap">
                <!-- Left sub-component (Product Details) -->
                <div class="flex flex-1 flex-col gap-6 max-xl:flex-auto">
                    <div class="nexora-card flex flex-col gap-6 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <!-- Product Banner -->
                        <div class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-r from-violet-50/60 via-transparent to-cyan-50/40 p-4 dark:border-gray-800 dark:from-violet-950/20 dark:to-cyan-950/10">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-tr from-[#5A4DB9] to-[#01C7F4] text-white shadow-md shadow-[#5A4DB9]/25">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>

                            <div class="flex flex-col gap-0.5">
                                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    SKU: <span class="font-mono font-medium text-gray-700 dark:text-gray-300">{{ $product->sku }}</span> &bull; Base Price: {!! core()->formatBasePrice($product->price, true) !!}
                                </p>
                            </div>
                        </div>

                        {!! view_render_event('admin.products.edit.attributes.before', ['product' => $product]) !!}

                        <x-admin::attributes
                            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                'entity_type' => 'products',
                                ['code', 'NOTIN', ['price', 'quantity']],
                            ])"
                            :entity="$product"
                        />

                        {!! view_render_event('admin.products.edit.attributes.after', ['product' => $product]) !!}
                    </div>
                </div>

                <!-- Right sub-component (Pricing & Inventory) -->
                <div class="flex w-[380px] max-w-full flex-col gap-4 max-sm:w-full">
                    {!! view_render_event('admin.products.edit.accordion.before', ['product' => $product]) !!}

                    <div class="nexora-card flex flex-col gap-4 rounded-2xl border border-gray-200/80 bg-white/90 p-5 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Pricing &amp; Inventory
                            </span>
                        </div>

                        {!! view_render_event('admin.products.edit.accordion.content.attributes.before', ['product' => $product]) !!}

                        <x-admin::attributes
                            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                'entity_type' => 'products',
                                ['code', 'IN', ['price', 'quantity']],
                            ])"
                            :entity="$product"
                        />

                        {!! view_render_event('admin.products.edit.accordion.content.attributes.after', ['product' => $product]) !!}

                        <!-- Quick Financial Metric Box -->
                        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3 text-xs dark:border-gray-800 dark:bg-gray-800/50">
                            <div class="flex items-center justify-between pb-1.5 border-b border-gray-200/50 dark:border-gray-700/50">
                                <span class="text-gray-500 dark:text-gray-400">Total Stock Value</span>
                                <span class="font-bold text-gray-900 dark:text-white">
                                    {!! core()->formatBasePrice((float) $product->price * (float) $product->quantity, true) !!}
                                </span>
                            </div>
                            <div class="flex items-center justify-between pt-1.5">
                                <span class="text-gray-500 dark:text-gray-400">Inventory Status</span>
                                <span class="font-semibold {{ (float) $product->quantity > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    {{ (float) $product->quantity > 0 ? 'Available for Deals' : 'Backorder Required' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Meta Info -->
                        <div class="flex flex-col gap-2 pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center justify-between">
                                <span>Product ID</span>
                                <span class="font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $product->id }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Created</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ core()->formatDate($product->created_at, 'M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {!! view_render_event('admin.products.edit.accordion.after', ['product' => $product]) !!}
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.products.edit.form.after') !!}
</x-admin::layouts>
