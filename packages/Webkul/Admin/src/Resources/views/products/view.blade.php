<x-admin::layouts>
    <x-slot:title>
        {{ strip_tags($product->name) }}
    </x-slot>

    <!-- Content -->
    <div class="nexora-animate-in flex gap-4 max-lg:flex-wrap">
        <!-- Left Panel -->
        {!! view_render_event('admin.products.view.left.before', ['product' => $product]) !!}

        <div class="nexora-card max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-2xl border border-gray-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
            <!-- Product Information -->
            <div class="flex w-full flex-col gap-3 border-b border-gray-200/80 p-5 dark:border-gray-800/80">
                <!-- Breadcrumbs -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs name="products.view" :entity="$product" />

                    @if (bouncer()->hasPermission('products.edit'))
                        <a
                            href="{{ route('admin.products.edit', $product->id) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-brandColor hover:text-brandColor dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:border-cyan-400 dark:hover:text-cyan-400"
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

                <!-- Title -->
                <div class="mb-2 flex flex-col gap-0.5">
                    {!! view_render_event('admin.products.view.left.title.before', ['product' => $product]) !!}

                    <h3 class="break-words text-lg font-bold dark:text-white">
                        {{ $product->name }}
                    </h3>
                    
                    {!! view_render_event('admin.products.view.left.title.after', ['product' => $product]) !!}

                    {!! view_render_event('admin.products.view.left.sku.before', ['product' => $product]) !!}

                    <p class="break-words text-sm font-normal dark:text-white">
                        @lang('admin::app.products.view.sku') : {{ $product->sku }}
                    </p>

                    {!! view_render_event('admin.products.view.left.sku.after', ['product' => $product]) !!}
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