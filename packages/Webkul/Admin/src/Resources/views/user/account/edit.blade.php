<x-admin::layouts>
    <!-- Page title -->
    <x-slot:title>
        @lang('admin::app.account.edit.title')
    </x-slot>

    {!! view_render_event('admin.user.account.form.before', ['user' => $user]) !!}

    <!-- Input Form -->
    <x-admin::form
        :action="route('admin.user.account.update')"
        enctype="multipart/form-data"
        method="PUT"
    >
        <!-- Sticky Action Header -->
        <div class="scroll-reactive-sticky sticky top-[60px] z-[1000] flex items-center justify-between rounded-2xl border border-gray-200/80 bg-white/95 px-5 py-3 text-sm shadow-sm backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/95 dark:text-gray-300">
            <div class="flex flex-col gap-1">
                {!! view_render_event('admin.user.account.breadcrumbs.before', ['user' => $user]) !!}

                <!-- Breadcrumbs -->
                <x-admin::breadcrumbs 
                    name="dashboard.account.edit" 
                    :entity="$user"
                />

                {!! view_render_event('admin.user.account.breadcrumbs.after', ['user' => $user]) !!}

                <div class="flex items-center gap-2.5 text-xl font-bold dark:text-white">
                    {!! view_render_event('admin.user.account.title.before', ['user' => $user]) !!}

                    <span>@lang('admin::app.account.edit.title')</span>

                    <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-400">
                        Active Account
                    </span>

                    {!! view_render_event('admin.user.account.title.after', ['user' => $user]) !!}
                </div>
            </div>

            <div class="flex items-center gap-x-3">
                {!! view_render_event('admin.user.account.save_btn.before', ['user' => $user]) !!}

                <button
                    type="submit"
                    class="primary-button group"
                >
                    <i class="icon-save text-lg transition-transform group-hover:scale-110"></i>
                    <span>@lang('admin::app.account.edit.save-btn')</span>
                </button>

                {!! view_render_event('admin.user.account.save_btn.after', ['user' => $user]) !!}
            </div>
        </div>

        <v-account-settings
            :initial-user="{{ json_encode([
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role'       => $user->role?->name ?? 'Administrator',
                'image_url'  => $user->image_url,
                'created_at' => $user->created_at ? $user->created_at->format('M Y') : 'Recent',
            ]) }}"
        >
            <template #media-images>
                <x-admin::form.control-group>
                    <x-admin::media.images
                        name="image"
                        :uploaded-images="$user->image ? [['id' => 'image', 'url' => $user->image_url]] : []"
                    />
                </x-admin::form.control-group>
            </template>
        </v-account-settings>
    </x-admin::form>

    {!! view_render_event('admin.user.account.form.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-account-settings-template"
        >
            <div class="mt-4 flex flex-col gap-5">
                <!-- Glassmorphic Profile Hero Card -->
                <div class="relative overflow-hidden rounded-3xl border border-gray-200/80 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <!-- Brand Gradient Decorative Banner -->
                    <div class="relative h-36 w-full overflow-hidden bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3]">
                        <!-- Subtle Glowing Floating Orbs -->
                        <div class="pointer-events-none absolute -left-10 -top-10 h-44 w-44 rounded-full bg-cyan-300/30 blur-2xl"></div>
                        <div class="pointer-events-none absolute right-12 -bottom-10 h-48 w-48 rounded-full bg-pink-400/30 blur-2xl"></div>
                        
                        <!-- Mesh Texture -->
                        <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] opacity-15"></div>
                    </div>

                    <!-- Profile Info Row -->
                    <div class="relative -mt-16 flex flex-wrap items-end justify-between gap-4 px-6 pb-6 max-sm:flex-col max-sm:items-start">
                        <div class="flex items-end gap-5 max-sm:flex-col max-sm:items-start">
                            <!-- Avatar with Ring and Pulse Badge -->
                            <div class="relative flex-shrink-0">
                                <div class="relative flex h-28 w-28 items-center justify-center overflow-hidden rounded-2xl border-4 border-white bg-gradient-to-tr from-[#01C7F4] to-[#5A4DB9] shadow-xl dark:border-gray-900">
                                    <template v-if="user.image_url">
                                        <img
                                            :src="user.image_url"
                                            :alt="user.name"
                                            class="h-full w-full object-cover"
                                        />
                                    </template>
                                    <template v-else>
                                        <span class="text-3xl font-extrabold text-white">
                                            @{{ initials }}
                                        </span>
                                    </template>
                                </div>
                                <!-- Online Status Badge -->
                                <span class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-emerald-500 shadow-md dark:border-gray-900" title="Account Active">
                                    <span class="h-2 w-2 rounded-full bg-white"></span>
                                </span>
                            </div>

                            <!-- Name, Email, and Role -->
                            <div class="flex flex-col gap-1 pb-1">
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        @{{ user.name }}
                                    </h1>
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-0.5 text-xs font-semibold text-indigo-700 dark:bg-indigo-950/70 dark:text-indigo-300">
                                        <i class="icon-role text-xs"></i>
                                        @{{ user.role }}
                                    </span>
                                </div>
                                <p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="icon-mail text-xs"></i>
                                    @{{ user.email }}
                                    <span class="text-gray-300 dark:text-gray-700">•</span>
                                    <span>Joined @{{ user.created_at }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Quick Badges -->
                        <div class="flex items-center gap-2 max-sm:w-full max-sm:justify-between">
                            <div class="flex items-center gap-2 rounded-2xl border border-gray-200/80 bg-gray-50/80 px-4 py-2 dark:border-gray-800 dark:bg-gray-800/60">
                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-cyan-100 text-[#01C7F4] dark:bg-cyan-950/80">
                                    <i class="icon-user text-sm"></i>
                                </span>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400">Data Scope</span>
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Global Admin</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 rounded-2xl border border-gray-200/80 bg-gray-50/80 px-4 py-2 dark:border-gray-800 dark:bg-gray-800/60">
                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-950/80 dark:text-emerald-400">
                                    <i class="icon-success text-sm"></i>
                                </span>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400">Security</span>
                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Protected</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs Strip -->
                    <div class="flex items-center gap-2 border-t border-gray-200/80 px-6 pt-2 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-900/60 overflow-x-auto">
                        <button
                            type="button"
                            @click="setTab('profile')"
                            class="relative flex items-center gap-2 px-4 py-3 text-sm font-semibold transition-all duration-200"
                            :class="activeTab === 'profile' ? 'text-[#5A4DB9] dark:text-[#01C7F4]' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'"
                        >
                            <i class="icon-user text-base"></i>
                            <span>Profile Details</span>
                            <span
                                v-if="activeTab === 'profile'"
                                class="absolute bottom-0 left-0 right-0 h-[2.5px] rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3]"
                            ></span>
                        </button>

                        <button
                            type="button"
                            @click="setTab('security')"
                            class="relative flex items-center gap-2 px-4 py-3 text-sm font-semibold transition-all duration-200"
                            :class="activeTab === 'security' ? 'text-[#5A4DB9] dark:text-[#01C7F4]' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'"
                        >
                            <i class="icon-settings-roles text-base"></i>
                            <span>Security & Password</span>
                            <span
                                v-if="activeTab === 'security'"
                                class="absolute bottom-0 left-0 right-0 h-[2.5px] rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3]"
                            ></span>
                        </button>

                        <button
                            type="button"
                            @click="setTab('preferences')"
                            class="relative flex items-center gap-2 px-4 py-3 text-sm font-semibold transition-all duration-200"
                            :class="activeTab === 'preferences' ? 'text-[#5A4DB9] dark:text-[#01C7F4]' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'"
                        >
                            <i class="icon-settings-warehouse text-base"></i>
                            <span>Preferences & System</span>
                            <span
                                v-if="activeTab === 'preferences'"
                                class="absolute bottom-0 left-0 right-0 h-[2.5px] rounded-full bg-gradient-to-r from-[#01C7F4] via-[#5A4DB9] to-[#D803B3]"
                            ></span>
                        </button>
                    </div>
                </div>

                <!-- Tab 1: Profile Details -->
                <div
                    v-show="activeTab === 'profile'"
                    class="nexora-tab-pane grid grid-cols-1 gap-5 lg:grid-cols-3"
                >
                    <!-- Left: Avatar Upload Card -->
                    <div class="flex flex-col gap-4 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-100 text-[#01C7F4] dark:bg-cyan-950/80">
                                <i class="icon-image text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Profile Picture
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    JPG, PNG, or WEBP up to 2MB
                                </p>
                            </div>
                        </div>

                        <!-- Blade Media Images Slot -->
                        <div class="pt-2">
                            <slot name="media-images"></slot>
                        </div>

                        <div class="rounded-2xl bg-gray-50 p-3.5 text-xs text-gray-500 dark:bg-gray-800/50 dark:text-gray-400">
                            <p class="font-medium text-gray-700 dark:text-gray-300 mb-1">
                                💡 Avatar Recommendation
                            </p>
                            Upload a square headshot (at least 200×200px) for best appearance across deals, quotes, and timeline comments.
                        </div>
                    </div>

                    <!-- Right: Personal Information Fields -->
                    <div class="flex flex-col gap-5 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-100 text-[#5A4DB9] dark:bg-indigo-950/80 dark:text-indigo-400">
                                <i class="icon-user text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Personal Information
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Update your name and primary business email address
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <!-- Full Name -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required font-semibold text-gray-700 dark:text-gray-200">
                                    @lang('admin::app.account.edit.name')
                                </x-admin::form.control-group.label>

                                <div class="relative">
                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="name"
                                        rules="required"
                                        :value="old('name') ?: $user->name"
                                        :label="trans('admin::app.account.edit.name')"
                                        :placeholder="trans('admin::app.account.edit.name')"
                                        class="!rounded-xl !pl-10 !py-2.5"
                                    />
                                    <i class="icon-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                </div>

                                <x-admin::form.control-group.error control-name="name" />
                            </x-admin::form.control-group>

                            <!-- Email Address -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required font-semibold text-gray-700 dark:text-gray-200">
                                    @lang('admin::app.account.edit.email')
                                </x-admin::form.control-group.label>

                                <div class="relative">
                                    <x-admin::form.control-group.control
                                        type="email"
                                        name="email"
                                        id="email"
                                        rules="required|email"
                                        :value="old('email') ?: $user->email"
                                        :label="trans('admin::app.account.edit.email')"
                                        :placeholder="trans('admin::app.account.edit.email')"
                                        class="!rounded-xl !pl-10 !py-2.5"
                                    />
                                    <i class="icon-mail absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                </div>

                                <x-admin::form.control-group.error control-name="email" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- Read-only Role & Permissions Badge Card -->
                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-4 dark:border-indigo-950/60 dark:bg-indigo-950/20">
                            <div class="flex items-start gap-3">
                                <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-200/80 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300">
                                    <i class="icon-role text-sm"></i>
                                </span>
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-indigo-900 dark:text-indigo-200">
                                            Role: @{{ user.role }}
                                        </span>
                                        <span class="rounded-md bg-white/80 px-2 py-0.5 text-[10px] font-semibold text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300">
                                            Assigned by Administrator
                                        </span>
                                    </div>
                                    <p class="text-xs text-indigo-700/80 dark:text-indigo-300/80">
                                        Your role defines system permissions, lead assignments, and reporting access. Contact an organization owner to modify role permissions.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Save Action -->
                        <div class="flex justify-end pt-3">
                            <button
                                type="submit"
                                class="primary-button"
                            >
                                <i class="icon-save text-base"></i>
                                <span>Save Profile Details</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Security & Password -->
                <div
                    v-show="activeTab === 'security'"
                    class="nexora-tab-pane grid grid-cols-1 gap-5 lg:grid-cols-3"
                >
                    <!-- Left: Security Guidelines & Tips -->
                    <div class="flex flex-col gap-4 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-100 text-[#9E24B7] dark:bg-violet-950/80 dark:text-violet-400">
                                <i class="icon-settings-roles text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Security Status
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Account credential standards
                                </p>
                            </div>
                        </div>

                        <!-- Real-time Password Strength Check List -->
                        <div class="flex flex-col gap-2.5 pt-1">
                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                Password Requirements:
                            </p>
                            <div class="flex items-center gap-2 text-xs" :class="hasLength ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400'">
                                <i :class="hasLength ? 'icon-success' : 'icon-info'"></i>
                                <span>Minimum 6 characters</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs" :class="hasMixedCase ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400'">
                                <i :class="hasMixedCase ? 'icon-success' : 'icon-info'"></i>
                                <span>Uppercase &amp; lowercase letters</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs" :class="hasNumber ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400'">
                                <i :class="hasNumber ? 'icon-success' : 'icon-info'"></i>
                                <span>At least one number (0-9)</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs" :class="hasSpecial ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400'">
                                <i :class="hasSpecial ? 'icon-success' : 'icon-info'"></i>
                                <span>Special character (!@#$%^&*)</span>
                            </div>
                        </div>

                        <div class="mt-2 rounded-2xl bg-amber-50 p-3.5 text-xs text-amber-800 dark:bg-amber-950/40 dark:text-amber-300">
                            <p class="font-bold mb-1">
                                🔒 Current Password Required
                            </p>
                            For security protection, your current password is required whenever making updates to your account details or credentials.
                        </div>
                    </div>

                    <!-- Right: Password Fields Card -->
                    <div class="flex flex-col gap-5 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-magenta-100 text-[#D803B3] dark:bg-pink-950/80 dark:text-pink-400">
                                <i class="icon-settings-user text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Change Password
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Leave new password blank if you only wish to update profile details
                                </p>
                            </div>
                        </div>

                        <!-- Current Password (Required) -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required font-semibold text-gray-700 dark:text-gray-200">
                                @lang('admin::app.account.edit.current-password')
                            </x-admin::form.control-group.label>

                            <div class="relative">
                                <x-admin::form.control-group.control
                                    :type="'password'"
                                    name="current_password"
                                    rules="required|min:6"
                                    :label="trans('admin::app.account.edit.current-password')"
                                    :placeholder="trans('admin::app.account.edit.current-password')"
                                    class="!rounded-xl !pl-10 !py-2.5"
                                />
                                <i class="icon-settings-roles absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Enter your current login password to verify changes.
                            </p>

                            <x-admin::form.control-group.error control-name="current_password" />
                        </x-admin::form.control-group>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <!-- New Password -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="font-semibold text-gray-700 dark:text-gray-200">
                                    @lang('admin::app.account.edit.password')
                                </x-admin::form.control-group.label>

                                <div class="relative">
                                    <x-admin::form.control-group.control
                                        type="password"
                                        name="password"
                                        rules="min:6"
                                        :placeholder="trans('admin::app.account.edit.password')"
                                        ref="password"
                                        v-model="newPassword"
                                        class="!rounded-xl !pl-10 !py-2.5"
                                    />
                                    <i class="icon-settings-flow absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div
                                    v-if="newPassword.length > 0"
                                    class="mt-2 flex flex-col gap-1.5"
                                >
                                    <div class="flex items-center justify-between text-xs font-semibold">
                                        <span class="text-gray-500">Strength:</span>
                                        <span :class="strengthTextColor">@{{ strengthLabel }}</span>
                                    </div>
                                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-800">
                                        <div
                                            class="h-full transition-all duration-300"
                                            :class="strengthBarColor"
                                            :style="{ width: strengthPercent + '%' }"
                                        ></div>
                                    </div>
                                </div>

                                <x-admin::form.control-group.error control-name="password" />
                            </x-admin::form.control-group>

                            <!-- Confirm Password -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="font-semibold text-gray-700 dark:text-gray-200">
                                    @lang('admin::app.account.edit.confirm-password')
                                </x-admin::form.control-group.label>

                                <div class="relative">
                                    <x-admin::form.control-group.control
                                        type="password"
                                        name="password_confirmation"
                                        rules="confirmed:@password"
                                        :label="trans('admin::app.account.edit.confirm-password')"
                                        :placeholder="trans('admin::app.account.edit.confirm-password')"
                                        v-model="confirmPassword"
                                        class="!rounded-xl !pl-10 !py-2.5"
                                    />
                                    <i class="icon-settings-pipeline absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                </div>

                                <!-- Match Indicator -->
                                <div
                                    v-if="confirmPassword.length > 0"
                                    class="mt-1 flex items-center gap-1.5 text-xs"
                                    :class="passwordsMatch ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'"
                                >
                                    <i :class="passwordsMatch ? 'icon-success' : 'icon-error'"></i>
                                    <span>@{{ passwordsMatch ? 'Passwords match' : 'Passwords do not match' }}</span>
                                </div>

                                <x-admin::form.control-group.error control-name="password_confirmation" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- Bottom Save Action -->
                        <div class="flex justify-end pt-3">
                            <button
                                type="submit"
                                class="primary-button"
                            >
                                <i class="icon-save text-base"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Preferences & System -->
                <div
                    v-show="activeTab === 'preferences'"
                    class="nexora-tab-pane grid grid-cols-1 gap-5 lg:grid-cols-3"
                >
                    <!-- Left: Appearance Settings -->
                    <div class="flex flex-col gap-4 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-[#2590D6] dark:bg-blue-950/80 dark:text-blue-400">
                                <i class="icon-settings-warehouse text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Display Theme
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Select dark or light appearance
                                </p>
                            </div>
                        </div>

                        <!-- Theme Toggle Button -->
                        <div class="flex flex-col gap-3 pt-2">
                            <div class="flex items-center justify-between rounded-2xl border border-gray-200/80 p-4 dark:border-gray-800 dark:bg-gray-800/40">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brandColor/10 text-brandColor dark:bg-cyan-500/15 dark:text-cyan-400">
                                        <i class="icon-settings-tag text-lg"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white">
                                            Current Theme
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            @{{ isDarkMode ? 'Dark Mode (Night)' : 'Light Mode (Day)' }}
                                        </p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    @click="toggleTheme"
                                    class="secondary-button !py-1.5 !px-3 text-xs"
                                >
                                    <span>Switch to @{{ isDarkMode ? 'Light' : 'Dark' }}</span>
                                </button>
                            </div>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Theme preferences are automatically remembered across your sessions and devices.
                            </p>
                        </div>
                    </div>

                    <!-- Right: System Information -->
                    <div class="flex flex-col gap-5 rounded-3xl border border-gray-200/80 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-950/80 dark:text-emerald-400">
                                <i class="icon-system-generate text-base"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Environment &amp; Workspace
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Nexora CRM operational telemetry
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="flex items-center justify-between rounded-2xl border border-gray-200/80 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/40">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Application Framework</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-white">Laravel 12.x</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-gray-200/80 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/40">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">PHP Runtime</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-white">{{ PHP_VERSION }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-gray-200/80 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/40">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Application Timezone</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-white">{{ config('app.timezone') }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-gray-200/80 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/40">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Base Currency</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-white">{{ config('app.currency') }}</span>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 dark:border-emerald-950/60 dark:bg-emerald-950/20">
                            <div class="flex items-center gap-2.5">
                                <i class="icon-success text-emerald-600 dark:text-emerald-400 text-lg"></i>
                                <div>
                                    <p class="text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                        Active Secure Session
                                    </p>
                                    <p class="text-xs text-emerald-700/80 dark:text-emerald-300/80">
                                        Authenticated via HTTPS and encrypted session cookies. All actions are logged to the audit trail.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-account-settings', {
                template: '#v-account-settings-template',

                props: {
                    initialUser: {
                        type: Object,
                        required: true,
                    },
                },

                data() {
                    return {
                        user: this.initialUser,
                        activeTab: 'profile',
                        newPassword: '',
                        confirmPassword: '',
                        isDarkMode: document.documentElement.classList.contains('dark'),
                    };
                },

                computed: {
                    initials() {
                        if (!this.user.name) return 'NX';
                        const parts = this.user.name.trim().split(' ');
                        if (parts.length >= 2) {
                            return (parts[0][0] + parts[1][0]).toUpperCase();
                        }
                        return this.user.name.substring(0, 2).toUpperCase();
                    },

                    hasLength() {
                        return this.newPassword.length >= 6;
                    },

                    hasMixedCase() {
                        return /[a-z]/.test(this.newPassword) && /[A-Z]/.test(this.newPassword);
                    },

                    hasNumber() {
                        return /[0-9]/.test(this.newPassword);
                    },

                    hasSpecial() {
                        return /[^A-Za-z0-9]/.test(this.newPassword);
                    },

                    strengthScore() {
                        let score = 0;
                        if (this.hasLength) score++;
                        if (this.hasMixedCase) score++;
                        if (this.hasNumber) score++;
                        if (this.hasSpecial) score++;
                        return score;
                    },

                    strengthPercent() {
                        return (this.strengthScore / 4) * 100;
                    },

                    strengthLabel() {
                        switch (this.strengthScore) {
                            case 1: return 'Weak';
                            case 2: return 'Fair';
                            case 3: return 'Good';
                            case 4: return 'Strong';
                            default: return 'Too Short';
                        }
                    },

                    strengthTextColor() {
                        switch (this.strengthScore) {
                            case 1: return 'text-red-500';
                            case 2: return 'text-amber-500';
                            case 3: return 'text-blue-500';
                            case 4: return 'text-emerald-500';
                            default: return 'text-gray-400';
                        }
                    },

                    strengthBarColor() {
                        switch (this.strengthScore) {
                            case 1: return 'bg-red-500';
                            case 2: return 'bg-amber-500';
                            case 3: return 'bg-blue-500';
                            case 4: return 'bg-emerald-500';
                            default: return 'bg-gray-300';
                        }
                    },

                    passwordsMatch() {
                        return this.newPassword.length > 0 && this.newPassword === this.confirmPassword;
                    },
                },

                methods: {
                    setTab(tab) {
                        if (window.NexoraTopLoader) {
                            window.NexoraTopLoader.pulse(200);
                        }
                        this.activeTab = tab;
                    },

                    toggleTheme() {
                        if (window.__nexoraTheme) {
                            const newTheme = !this.isDarkMode;
                            window.__nexoraTheme.apply(newTheme, true);
                            this.isDarkMode = newTheme;
                        }
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
