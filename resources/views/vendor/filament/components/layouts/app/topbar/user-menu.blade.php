@php
    $user = \Filament\Facades\Filament::auth()->user();
    $items = \Filament\Facades\Filament::getUserMenuItems();


    $accountItem = $items['account'] ?? null;
    $accountItemUrl = $accountItem?->getUrl();

    $logoutItem = $items['logout'] ?? null;
@endphp

{{ \Filament\Facades\Filament::renderHook('user-menu.start') }}

<x-filament::dropdown placement="bottom-end">
    <x-slot name="trigger" class="ml-4 rtl:mr-4 rtl:ml-0">
        <button class="block" aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
            <x-filament::user-avatar :user="$user" />
        </button>
    </x-slot>

    {{ \Filament\Facades\Filament::renderHook('user-menu.account.before') }}

    <x-filament::dropdown.header
        :color="$accountItem?->getColor() ?? 'secondary'"
        :icon="$accountItem?->getIcon() ?? 'heroicon-s-user-circle'"
        :href="$accountItemUrl"
        :tag="filled($accountItemUrl) ? 'a' : 'div'"
    >
        {{ $accountItem?->getLabel() ?? \Filament\Facades\Filament::getUserName($user) }}
    </x-filament::dropdown.header>

    {{ \Filament\Facades\Filament::renderHook('user-menu.account.after') }}

    <x-filament::dropdown.list
        x-data="{
            mode: null,

            theme: null,

            init: function () {
                this.theme = localStorage.getItem('theme') || (this.isSystemDark() ? 'dark' : 'light')
                this.mode = localStorage.getItem('theme') ? 'manual' : 'auto'

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
                    if (this.mode === 'manual') return

                    if (event.matches && (! document.documentElement.classList.contains('dark'))) {
                        this.theme = 'dark'

                        document.documentElement.classList.add('dark')
                    } else if ((! event.matches) && document.documentElement.classList.contains('dark')) {
                        this.theme = 'light'

                        document.documentElement.classList.remove('dark')
                    }
                })

                $watch('theme', () => {
                    if (this.mode === 'auto') return

                    localStorage.setItem('theme', this.theme)

                    if (this.theme === 'dark' && (! document.documentElement.classList.contains('dark'))) {
                        document.documentElement.classList.add('dark')
                    } else if (this.theme === 'light' && document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark')
                    }

                    $dispatch('dark-mode-toggled', this.theme)
                })
            },

            isSystemDark: function () {
                return window.matchMedia('(prefers-color-scheme: dark)').matches
            },
        }"
    >

        @if($user->role == 'user' && $user->plan)
            <div>
                <button type="button" wire:loading.attr="disabled" class="filament-dropdown-list-item filament-dropdown-item group flex w-full items-center whitespace-nowrap rounded-md p-2 text-sm outline-none hover:text-white focus:text-white hover:bg-primary-500 focus:bg-primary-500" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span class="filament-dropdown-list-item-label truncate w-full text-start ml-1">
             {{\Illuminate\Support\Str::ucfirst($user->plan->title)}} Plan
                 </span>

                </button>

            </div>
        @endif

        @foreach ($items as $key => $item)
            @if ($key !== 'account' && $key !== 'logout')
                <x-filament::dropdown.list.item
                    :color="$item->getColor() ?? 'secondary'"
                    :icon="$item->getIcon()"
                    :href="$item->getUrl()"
                    tag="a"
                >
                    {{ $item->getLabel() }}
                </x-filament::dropdown.list.item>
            @endif
        @endforeach
{{--        @if($user->plan)--}}
{{--            <b>{{$user->plan->name}} |</b>--}}
{{--        @endif--}}
        @if(\Illuminate\Support\Facades\Auth::user()->role == "user")
            <ul class="ml-58_">
                @php
                    //dd(\Illuminate\Support\Facades\Auth::user()->with('mediaSize','lastMonthDate')->first());
                      $user_details =  \App\Models\User::query()->with('mediaSize','lastMonthDate')->where("id","=",\Illuminate\Support\Facades\Auth::id())->first();

                @endphp
                <li>
                    <b>Bots</b>
                    <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                    {{$user_details->bots->count()."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_bot > 0 ? $user_details->plan->max_number_of_bot : "∞") : "0")}}
               </span>
                </li>
                <li>
                    <b>Responses (GPT3)</b>
                    @php
                        $last_responses = $user_details->lastMonthDateWithCompany("gpt3");
                   $number_of_clicks = $user_details->lastMonthDateWithCompany("gpt3");

                   $last_responses = $last_responses->sum('number_of_response');
                   $number_of_clicks = $number_of_clicks->sum('number_of_clicks');
                    @endphp
                    <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                    {{$last_responses."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_response > 0 ? $user_details->plan->max_number_of_response : "∞") : "0")}}
               </span>
                </li>

                <li>
                    <b>Responses (GPT4)</b>
                    @php
                        $last_responses2 = $user_details->lastMonthDateWithCompany("gpt4");
                   $number_of_clicks2 = $user_details->lastMonthDateWithCompany("gpt4");

                   $last_responses2 = $last_responses2->sum('number_of_response');
                   $number_of_clicks2 = $number_of_clicks2->sum('number_of_clicks');
                    @endphp
                    <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                    {{$last_responses2."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_response > 0 ? $user_details->plan->max_number_of_response : "∞") : "0")}}
               </span>
                </li>
                <li>
                    <b>Clicks</b>
                    @php

                        $last_responses = $number_of_clicks
                    @endphp
                    <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                              {{$last_responses."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_click > 0 ? $user_details->plan->max_number_of_click : "∞") : "0")}}
               </span>
                </li>
                <li>
                    <b>MB</b>
                    <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                {{number_format($user_details->mediaSize->sum('size')*0.000001,0)."|".(!empty($user_details->plan) ? ($user_details->plan->max_number_of_mb > 0 ? $user_details->plan->max_number_of_mb : "∞") : "0")}}
               </span>
                </li>

            </ul>
        @endif

            <div>
                @if (config('filament.dark_mode'))
                    <x-filament::dropdown.list.item icon="heroicon-s-moon" x-show="theme === 'dark'" x-on:click="close(); mode = 'manual'; theme = 'light'">
                        {{ __('filament::layout.buttons.light_mode.label') }}
                    </x-filament::dropdown.list.item>

                    <x-filament::dropdown.list.item icon="heroicon-s-sun" x-show="theme === 'light'" x-on:click="close(); mode = 'manual'; theme = 'dark'">
                        {{ __('filament::layout.buttons.dark_mode.label') }}
                    </x-filament::dropdown.list.item>
                @endif
            </div>


        <x-filament::dropdown.list.item
            :color="$logoutItem?->getColor() ?? 'secondary'"
            :icon="$logoutItem?->getIcon() ?? 'heroicon-s-logout'"
            :action="$logoutItem?->getUrl() ?? route('filament.auth.logout')"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('filament::layout.buttons.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>

{{ \Filament\Facades\Filament::renderHook('user-menu.end') }}
