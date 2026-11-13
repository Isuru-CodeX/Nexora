<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.activities.edit.title')
    </x-slot>

    {!! view_render_event('admin.activities.edit.form.before') !!}

    <x-admin::form
        :action="route('admin.activities.update', $activity->id)"
        method="PUT"
    >
        <div class="nexora-animate-in flex flex-col gap-5">
            <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/85 px-6 py-4 text-sm shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/85 dark:text-gray-300 transition-all duration-200">
                <div class="flex flex-col gap-1.5">
                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs
                        name="activities.edit"
                        :entity="$activity"
                    />

                    <!-- Page Title & Badges -->
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $activity->title ?: trans('admin::app.activities.edit.title') }}
                        </h1>

                        <!-- Activity Type Badge -->
                        @if ($activity->type == 'call')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Call
                            </span>
                        @elseif ($activity->type == 'meeting')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Meeting
                            </span>
                        @elseif ($activity->type == 'lunch')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Lunch
                            </span>
                        @endif

                        <!-- Status Badge -->
                        @if ($activity->is_done)
                            <span class="inline-flex items-center gap-1 rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-medium text-teal-700 dark:bg-teal-950/50 dark:text-teal-300 border border-teal-200/60 dark:border-teal-800/60">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700 dark:bg-gray-800 dark:text-gray-300">
                                Pending
                            </span>
                        @endif

                        @if ($activity->schedule_from)
                            <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ core()->formatDate($activity->schedule_from, 'M d, Y h:i A') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    {!! view_render_event('admin.activities.edit.save_button.before') !!}

                    <!-- Save Button -->
                    <button
                        type="submit"
                        class="primary-button inline-flex items-center gap-1.5"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @lang('admin::app.activities.edit.save-btn')
                    </button>

                    {!! view_render_event('admin.activities.edit.save_button.after') !!}
                </div>
            </div>

            <!-- Form Content -->
            <div class="flex gap-6 max-xl:flex-wrap-reverse">
                <!-- Left sub-component -->
                <div class="nexora-card flex flex-1 flex-col gap-6 rounded-2xl border border-gray-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 max-xl:flex-auto transition-all duration-300">
                    {!! view_render_event('admin.activities.edit.form_controls.before') !!}

                    <!-- Section: Schedule Date & Time -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-[#5A4DB9] dark:bg-indigo-950/60 dark:text-indigo-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Schedule &amp; Timing
                            </span>
                        </div>

                        <x-admin::form.control-group class="!mb-0">
                            <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                                <div class="w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.activities.edit.schedule_from')
                                    </x-admin::form.control-group.label>

                                    <x-admin::flat-picker.datetime class="!w-full" ::allow-input="true">
                                        <input
                                            name="schedule_from"
                                            value="{{ old('schedule_from') ?? $activity->schedule_from }}"
                                            class="flex w-full rounded-xl border border-gray-200 px-3 py-2 text-sm text-gray-700 transition-all hover:border-[#5A4DB9] focus:border-[#5A4DB9] dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                                            placeholder="@lang('admin::app.activities.edit.schedule_from')"
                                        />
                                    </x-admin::flat-picker.datetime>
                                </div>

                                <div class="w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.activities.edit.schedule_to')
                                    </x-admin::form.control-group.label>

                                    <x-admin::flat-picker.datetime class="!w-full" ::allow-input="true">
                                        <input
                                            name="schedule_to"
                                            value="{{ old('schedule_to') ?? $activity->schedule_to }}"
                                            class="flex w-full rounded-xl border border-gray-200 px-3 py-2 text-sm text-gray-700 transition-all hover:border-[#5A4DB9] focus:border-[#5A4DB9] dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                                            placeholder="@lang('admin::app.activities.edit.schedule_to')"
                                        />
                                    </x-admin::flat-picker.datetime>
                                </div>
                            </div>
                        </x-admin::form.control-group>
                    </div>

                    <!-- Section: Details & Comment -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-violet-950/60 dark:text-violet-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Activity Summary &amp; Notes
                            </span>
                        </div>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.activities.edit.comment')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="comment"
                                id="comment"
                                :value="old('comment') ?? $activity->comment"
                                :label="trans('admin::app.activities.edit.comment')"
                                :placeholder="trans('admin::app.activities.edit.comment')"
                                rows="4"
                            />

                            <x-admin::form.control-group.error control-name="comment" />
                        </x-admin::form.control-group>
                    </div>

                    <!-- Section: Participants -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 dark:bg-cyan-950/60 dark:text-cyan-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                Participants &amp; Invitees
                            </span>
                        </div>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.activities.edit.participants')
                            </x-admin::form.control-group.label>

                            <!-- Participants Multi lookup Vue Component -->
                            <v-multi-lookup-component>
                                <div
                                    class="relative rounded-xl border border-gray-200 px-3 py-2 hover:border-[#5A4DB9] focus:border-[#5A4DB9] dark:border-gray-800 dark:bg-gray-900"
                                    role="button"
                                >
                                    <ul class="flex flex-wrap items-center gap-1.5">
                                        <li>
                                            <input
                                                type="text"
                                                class="w-full px-1 py-1 text-sm dark:bg-gray-900 dark:text-gray-300"
                                                placeholder="@lang('admin::app.activities.edit.participants')"
                                            />
                                        </li>
                                    </ul>

                                    <span class="icon-down-arrow absolute top-2.5 text-2xl ltr:right-2 rtl:left-2 text-gray-400"></span>
                                </div>
                            </v-multi-lookup-component>
                        </x-admin::form.control-group>
                    </div>

                    <!-- Section: Lead Link -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                CRM Pipeline Association
                            </span>
                        </div>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.activities.edit.lead')
                            </x-admin::form.control-group.label>

                            <x-admin::attributes.edit.lookup/>

                            <!-- Lead Lookup Vue Component -->
                            <v-lookup-component
                                :attribute="{'code': 'lead_id', 'name': 'Lead', 'lookup_type': 'leads'}"
                                :value='@json($lookUpEntityData)'
                            >
                                <x-admin::form.control-group.control
                                    type="text"
                                    placeholder="@lang('admin::app.common.start-typing')"
                                />
                            </v-lookup-component>
                        </x-admin::form.control-group>
                    </div>

                    {!! view_render_event('admin.activities.edit.form_controls.after') !!}
                </div>

                <!-- Right sub-component (Sidebar Card) -->
                <div class="flex w-[380px] max-w-full flex-col gap-4 max-xl:w-full">
                    <div class="nexora-card flex flex-col gap-4 rounded-2xl border border-gray-200/80 bg-white/90 p-5 shadow-sm backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/90 transition-all duration-300">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                @lang('admin::app.activities.edit.general')
                            </span>
                        </div>

                        <!-- Title -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.activities.edit.title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="title"
                                id="title"
                                rules="required"
                                :value="old('title') ?? $activity->title"
                                :label="trans('admin::app.activities.edit.title')"
                                :placeholder="trans('admin::app.activities.edit.title')"
                            />

                            <x-admin::form.control-group.error control-name="title" />
                        </x-admin::form.control-group>

                        <!-- Edit Type -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.activities.edit.type')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="select"
                                name="type"
                                id="type"
                                :value="old('type') ?? $activity->type"
                                rules="required"
                                :label="trans('admin::app.activities.edit.type')"
                                :placeholder="trans('admin::app.activities.edit.type')"
                            >
                                <option value="call">
                                    @lang('admin::app.activities.edit.call')
                                </option>

                                <option value="meeting">
                                    @lang('admin::app.activities.edit.meeting')
                                </option>

                                <option value="lunch">
                                    @lang('admin::app.activities.edit.lunch')
                                </option>
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="type" />
                        </x-admin::form.control-group>

                        <!-- Location -->
                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.activities.edit.location')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="location"
                                id="location"
                                :value="old('location') ?? $activity->location"
                                :label="trans('admin::app.activities.edit.location')"
                                :placeholder="trans('admin::app.activities.edit.location')"
                            />

                            <x-admin::form.control-group.error control-name="location" />
                        </x-admin::form.control-group>
                    </div>

                    <!-- Meta Information Box -->
                    <div class="rounded-2xl border border-gray-200/80 bg-gray-50/80 p-4 text-xs text-gray-500 dark:border-gray-800/80 dark:bg-gray-900/60 dark:text-gray-400">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/60 dark:border-gray-800/60">
                            <span>Created At</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ core()->formatDate($activity->created_at, 'M d, Y h:i A') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <span>Activity ID</span>
                            <span class="font-mono font-medium text-gray-700 dark:text-gray-300">
                                #{{ $activity->id }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.activities.edit.form.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-multi-lookup-component-template"
        >
            <!-- Search Button -->
            <div class="relative">
                <div class="relative rounded border border-gray-300 px-2 py-1 hover:border-gray-400 focus:border-gray-400 dark:border-gray-800" role="button">
                    <ul class="flex flex-wrap items-center gap-1">
                        <!-- Added Participants -->
                        <template v-for="userType in ['users', 'persons']">
                            <template v-if="! addedParticipants[userType].length">
                                <input
                                    type="hidden"
                                    :name="`participants[${userType}][]`"
                                    value=""
                                />
                            </template>

                            <li
                                class="flex items-center gap-1 rounded-md bg-slate-100 pl-2 dark:bg-slate-950 dark:text-gray-300"
                                v-for="(user, index) in addedParticipants[userType]"
                            >
                                <!-- Person and User Hidden Input Field -->
                                <input
                                    type="hidden"
                                    :name="`participants[${userType}][]`"
                                    :value="user.id"
                                />

                                @{{ user.name }}

                                <span
                                    class="icon-cross-large cursor-pointer p-0.5 text-xl"
                                    @click="remove(userType, user)"
                                ></span>
                            </li>
                        </template>

                        <!-- Search Input Box -->
                        <li>
                            <input
                                type="text"
                                class="w-full px-1 py-1 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="@lang('admin::app.activities.edit.participants')"
                                v-model.lazy="searchTerm"
                                v-debounce="500"
                            />
                        </li>
                    </ul>

                    <!-- Search and Spinner Icon -->
                    <div>
                        <template v-if="! isSearching.users && ! isSearching.persons">
                            <span
                                class="absolute top-1.5 text-2xl ltr:right-1.5 rtl:left-1.5"
                                :class="[searchTerm.length >= 2 ? 'icon-up-arrow' : 'icon-down-arrow']"
                            ></span>
                        </template>

                        <template v-else>
                            <x-admin::spinner class="absolute top-2 ltr:right-2 rtl:left-2" />
                        </template>
                    </div>
                </div>

                <!-- Search Dropdown -->
                <div
                    class="absolute z-10 w-full rounded bg-white shadow-[0px_10px_20px_0px_#0000001F] dark:bg-gray-900"
                    v-if="searchTerm.length >= 2"
                >
                    <ul class="flex flex-col gap-1 p-2">
                        <!-- Users and Person Searched Participants -->
                        <li
                            class="flex flex-col gap-2"
                            v-for="userType in ['users', 'persons']"
                        >
                            <h3 class="text-sm font-bold text-gray-600 dark:text-gray-400">
                                <template v-if="userType === 'users'">
                                    @lang('admin::app.activities.edit.users')
                                </template>

                                <template v-else>
                                    @lang('admin::app.activities.edit.persons')
                                </template>
                            </h3>

                            <ul>
                                <li
                                    class="rounded-sm px-5 py-2 text-sm text-gray-800 dark:text-gray-300"
                                    v-if="! searchedParticipants[userType].length && ! isSearching[userType]"
                                >
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @lang('admin::app.activities.edit.no-result-found')
                                    </p>
                                </li>

                                <li
                                    class="cursor-pointer rounded-sm px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
                                    v-for="user in searchedParticipants[userType]"
                                    @click="add(userType, user)"
                                >
                                    @{{ user.name }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-multi-lookup-component', {
                template: '#v-multi-lookup-component-template',

                data() {
                    return {
                        isSearching: {
                            users: false,

                            persons: false,
                        },

                        searchTerm: '',

                        addedParticipants: {
                            users: [],

                            persons: [],
                        },

                        searchedParticipants: {
                            users: [],

                            persons: [],
                        },

                        searchEnpoints: {
                            users: "{{ route('admin.settings.users.search') }}",

                            persons: "{{ route('admin.contacts.persons.search') }}",
                        },
                    };
                },

                watch: {
                    searchTerm(newVal, oldVal) {
                        this.search('users');

                        this.search('persons');
                    },
                },

                created() {
                    @json($activity->participants).forEach(participant => {
                        if (participant.user) {
                            this.addedParticipants.users.push(participant.user);
                        } else if (participant.person) {
                            this.addedParticipants.persons.push(participant.person);
                        }
                    });
                },

                methods: {
                    search(userType) {
                        if (this.searchTerm.length <= 1) {
                            this.searchedParticipants[userType] = [];

                            this.isSearching[userType] = false;

                            return;
                        }

                        this.isSearching[userType] = true;

                        this.$axios.get(this.searchEnpoints[userType], {
                                params: {
                                    search: 'name:' + this.searchTerm,
                                    searchFields: 'name:like',
                                }
                            })
                            .then ((response) => {
                                this.addedParticipants[userType].forEach(addedParticipant =>
                                    response.data.data = response.data.data.filter(participant => participant.id !== addedParticipant.id)
                                );

                                this.searchedParticipants[userType] = response.data.data;

                                this.isSearching[userType] = false;
                            })
                            .catch (function (error) {
                                this.isSearching[userType] = false;
                            });
                    },

                    add(userType, participant) {
                        this.addedParticipants[userType].push(participant);

                        this.searchTerm = '';

                        this.searchedParticipants = {
                            users: [],

                            persons: [],
                        };
                    },

                    remove(userType, participant) {
                        this.addedParticipants[userType] = this.addedParticipants[userType].filter(addedParticipant =>
                            addedParticipant.id !== participant.id
                        );
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
