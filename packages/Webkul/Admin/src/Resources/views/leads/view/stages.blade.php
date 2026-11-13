<!-- Stages Navigation -->
{!! view_render_event('admin.leads.view.stages.before', ['lead' => $lead]) !!}

<!-- Stages Vue Component -->
<v-lead-stages>
    <x-admin::shimmer.leads.view.stages :count="$lead->pipeline->stages->count() - 1" />
</v-lead-stages>

{!! view_render_event('admin.leads.view.stages.after', ['lead' => $lead]) !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-lead-stages-template">
        <!-- Stages Container -->
        <div
            class="flex w-full max-w-full"
            :class="{'opacity-50 pointer-events-none': isUpdating}"
        >
            <!-- Stages Item -->
            <template v-for="stage in stages">
                {!! view_render_event('admin.leads.view.stages.items.before', ['lead' => $lead]) !!}

                <div
                    class="stage relative flex h-7 cursor-pointer items-center justify-center bg-white pl-7 pr-4 dark:bg-gray-900 ltr:first:rounded-l-lg rtl:first:rounded-r-lg"
                    :class="{
                        '!bg-green-500 text-white dark:text-gray-900 ltr:after:bg-green-500 rtl:before:bg-green-500': currentStage.sort_order >= stage.sort_order,
                        '!bg-red-500 text-white dark:text-gray-900 ltr:after:bg-red-500 rtl:before:bg-red-500': currentStage.code == 'lost',
                    }"
                    v-if="! ['won', 'lost'].includes(stage.code)"
                    @click="update(stage)"
                >
                    <span class="z-20 whitespace-nowrap text-sm font-medium dark:text-white">
                        @{{ stage.name }}
                    </span>
                </div>

                {!! view_render_event('admin.leads.view.stages.items.after', ['lead' => $lead]) !!}
            </template>

            {!! view_render_event('admin.leads.view.stages.items.dropdown.before', ['lead' => $lead]) !!}

            <!-- Won/Lost Stage Item -->
            <x-admin::dropdown position="bottom-right">
                <x-slot:toggle>
                    {!! view_render_event('admin.leads.view.stages.items.dropdown.toggle.before', ['lead' => $lead]) !!}

                    <div
                        class="relative flex h-7 min-w-24 cursor-pointer items-center justify-center rounded-r-lg bg-white pl-7 pr-4 dark:bg-gray-900"
                        :class="{
                            '!bg-green-500 text-white dark:text-gray-900 after:bg-green-500': ['won', 'lost'].includes(currentStage.code) && currentStage.code == 'won',
                            '!bg-red-500 text-white dark:text-gray-900 after:bg-red-500': ['won', 'lost'].includes(currentStage.code) && currentStage.code == 'lost',
                        }"
                        @click="stageToggler = ! stageToggler"
                    >
                        <span class="z-20 whitespace-nowrap text-sm font-medium dark:text-white">
                             @{{ stages.filter(stage => ['won', 'lost'].includes(stage.code)).map(stage => stage.name).join('/') }}
                        </span>

                        <span
                            class="text-2xl dark:text-gray-900"
                            :class="{'icon-up-arrow': stageToggler, 'icon-down-arrow': ! stageToggler}"
                        ></span>
                    </div>

                    {!! view_render_event('admin.leads.view.stages.items.dropdown.toggle.after', ['lead' => $lead]) !!}
                </x-slot>

                <x-slot:menu>
                    {!! view_render_event('admin.leads.view.stages.items.dropdown.menu_item.before', ['lead' => $lead]) !!}

                    <x-admin::dropdown.menu.item
                        v-for="stage in stages.filter(stage => ['won', 'lost'].includes(stage.code))"
                        @click="openModal(stage)"
                    >
                        @{{ stage.name }}
                    </x-admin::dropdown.menu.item>

                    {!! view_render_event('admin.leads.view.stages.items.dropdown.menu_item.after', ['lead' => $lead]) !!}
                </x-slot>
            </x-admin::dropdown>

            {!! view_render_event('admin.leads.view.stages.items.dropdown.after', ['lead' => $lead]) !!}

            {!! view_render_event('admin.leads.view.stages.form_controls.before', ['lead' => $lead]) !!}

            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="stageUpdateForm"
                >
                <form @submit="handleSubmit($event, handleFormSubmit)">
                    {!! view_render_event('admin.leads.view.stages.form_controls.modal.before', ['lead' => $lead]) !!}

                    <x-admin::modal ref="stageUpdateModal">
                        <x-slot:header>
                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.header.before', ['lead' => $lead]) !!}

                            <h3 class="text-base font-semibold dark:text-white">
                                @lang('admin::app.leads.view.stages.need-more-info')
                            </h3>

                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.header.after', ['lead' => $lead]) !!}
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.content.before', ['lead' => $lead]) !!}

                            <!-- Won Value -->
                            <template v-if="nextStage.code == 'won'">
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label>
                                        @lang('admin::app.leads.view.stages.won-value')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="price"
                                        name="lead_value"
                                        :value="$lead->lead_value"
                                        v-model="nextStage.lead_value"
                                    />
                                </x-admin::form.control-group>
                            </template>

                            <!-- Lost Reason -->
                            <template v-else>
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label>
                                        @lang('admin::app.leads.view.stages.lost-reason')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        name="lost_reason"
                                        v-model="nextStage.lost_reason"
                                    />
                                </x-admin::form.control-group>
                            </template>

                            <!-- Closed At -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('admin::app.leads.view.stages.closed-at')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="datetime"
                                    name="closed_at"
                                    v-model="nextStage.closed_at"
                                    :label="trans('admin::app.leads.view.stages.closed-at')"
                                />

                                <x-admin::form.control-group.error control-name="closed_at"/>
                            </x-admin::form.control-group>

                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.content.after', ['lead' => $lead]) !!}
                        </x-slot>

                        <x-slot:footer>
                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.footer.before', ['lead' => $lead]) !!}

                            <button
                                type="submit"
                                class="primary-button"
                            >
                                @lang('admin::app.leads.view.stages.save-btn')
                            </button>

                            {!! view_render_event('admin.leads.view.stages.form_controls.modal.footer.after', ['lead' => $lead]) !!}
                        </x-slot>
                    </x-admin::modal>

                    {!! view_render_event('admin.leads.view.stages.form_controls.modal.after', ['lead' => $lead]) !!}
                </form>
            </x-admin::form>

            {!! view_render_event('admin.leads.view.stages.form_controls.after', ['lead' => $lead]) !!}

            <!-- Stage Velocity & Playbook Widget -->
            <div class="mt-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900" v-if="checklists.length || daysInStage !== undefined">
                <!-- Stagnation / Velocity Header -->
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="icon-clock text-xl text-brandColor"></span>
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200">
                            <span>Stage Velocity:</span>
                            <span class="rounded bg-gray-100 px-2 py-0.5 text-gray-800 dark:bg-gray-800 dark:text-gray-200 font-bold">
                                @{{ daysInStage }} Days in Current Stage
                            </span>
                        </div>

                        <!-- Rotten Alert Badge -->
                        <div
                            class="flex items-center gap-1 rounded bg-rose-100 px-2 py-0.5 text-xs font-bold text-rose-700 dark:bg-rose-950 dark:text-rose-300 animate-pulse"
                            v-if="rottenDays > 0"
                        >
                            <span class="icon-rotten text-sm text-rose-600"></span>
                            <span>Rotten for @{{ rottenDays }} Days (Stagnant Deal)</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2" v-if="checklists.length">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Playbook Progress: @{{ completedCount }} / @{{ checklists.length }}
                        </span>
                        <span
                            class="rounded px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300"
                            v-if="canAdvance"
                        >
                            Requirements Met
                        </span>
                        <span
                            class="rounded px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300"
                            v-else
                        >
                            Required Tasks Pending
                        </span>
                    </div>
                </div>

                <!-- Checklist Items -->
                <div class="flex flex-col gap-2" v-if="checklists.length">
                    <div
                        class="flex items-start gap-3 rounded-md border p-2.5 transition-all cursor-pointer hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/60"
                        :class="{
                            'border-emerald-300 bg-emerald-50/20 dark:border-emerald-900/40': item.is_completed,
                            'border-gray-200 dark:border-gray-800': ! item.is_completed
                        }"
                        v-for="item in checklists"
                        :key="item.id"
                        @click="toggleChecklist(item)"
                    >
                        <input
                            type="checkbox"
                            :checked="item.is_completed"
                            class="mt-0.5 h-4 w-4 cursor-pointer rounded border-gray-300 text-brandColor focus:ring-brandColor"
                            @click.stop="toggleChecklist(item)"
                        />

                        <div class="flex flex-1 flex-col gap-0.5">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-semibold"
                                    :class="{
                                        'line-through text-gray-400 dark:text-gray-500': item.is_completed,
                                        'text-gray-800 dark:text-white': ! item.is_completed
                                    }"
                                >
                                    @{{ item.name }}
                                </span>

                                <span
                                    class="rounded px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300"
                                    v-if="item.is_required"
                                >
                                    Required
                                </span>
                            </div>

                            <p class="text-[11px] text-gray-500 dark:text-gray-400" v-if="item.description">
                                @{{ item.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-lead-stages', {
            template: '#v-lead-stages-template',

            data() {
                return {
                    isUpdating: false,

                    currentStage: @json($lead->stage),

                    nextStage: null,

                    stages: @json($lead->pipeline->stages),

                    stageToggler: '',

                    daysInStage: @json($lead->days_in_stage),

                    rottenDays: @json($lead->rotten_days),

                    checklists: [],
                }
            },

            computed: {
                completedCount() {
                    return this.checklists.filter(c => c.is_completed).length;
                },

                canAdvance() {
                    return this.checklists.filter(c => c.is_required && ! c.is_completed).length === 0;
                },
            },

            mounted() {
                this.fetchChecklists();
            },

            methods: {
                fetchChecklists() {
                    this.$axios.get("{{ route('admin.leads.checklists.get', $lead->id) }}")
                        .then(response => {
                            this.checklists = response.data.checklists;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },

                toggleChecklist(item) {
                    this.$axios.post("{{ route('admin.leads.checklists.toggle', ['id' => $lead->id, 'checklist_id' => '__CID__']) }}".replace('__CID__', item.id))
                        .then(response => {
                            item.is_completed = ! item.is_completed;
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: 'Failed to update checklist item.' });
                        });
                },
                openModal(stage) {
                    if (this.currentStage.code == stage.code) {
                        return;
                    }

                    this.nextStage = stage;

                    this.$refs.stageUpdateModal.open();
                },

                handleFormSubmit(event) {
                    let params = {
                        'lead_pipeline_stage_id': this.nextStage.id
                    };

                    if (this.nextStage.code == 'won') {
                        params.lead_value = this.nextStage.lead_value;

                        params.closed_at = this.nextStage.closed_at;
                    } else if (this.nextStage.code == 'lost') {
                        params.lost_reason = this.nextStage.lost_reason;

                        params.closed_at = this.nextStage.closed_at;
                    }

                    this.update(this.nextStage, params);
                },

                update(stage, params = null) {
                    if (this.currentStage.code == stage.code) {
                        return;
                    }

                    this.$refs.stageUpdateModal.close();

                    this.isUpdating = true;

                    this.$axios
                        .put("{{ route('admin.leads.stage.update', $lead->id) }}", params ?? {
                            'lead_pipeline_stage_id': stage.id
                        })
                        .then ((response) => {
                            this.isUpdating = false;

                            this.currentStage = stage;

                            this.$parent.$refs.activities.get();

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch ((error) => {
                            this.isUpdating = false;

                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });
                },
            },
        });
    </script>
@endPushOnce
