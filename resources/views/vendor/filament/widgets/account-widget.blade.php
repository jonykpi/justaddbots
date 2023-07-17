@php
    \Illuminate\Support\Facades\Cache::set('company',\Illuminate\Support\Facades\Auth::user()->company);
@endphp
@if(request()->start && request()->end)
  @php
      \Illuminate\Support\Facades\Cache::set('start',request()->start);
  \Illuminate\Support\Facades\Cache::set('end',request()->end);
  @endphp
@endif
<x-filament::widget class="filament-account-widget">
    <x-filament::card>
        <style>
            .top-100 {top: 100%}
            .bottom-100 {bottom: 100%}
            .max-h-select {
                max-height: 300px;
            }
        </style>
        <div class="flex justify-space-between">
            <div>
                @php
                    $user = \Filament\Facades\Filament::auth()->user();
                @endphp

                <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
                    <x-filament::user-avatar :user="$user" />

                    <div>
                        <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                            {{ __('filament::widgets/account-widget.welcome', ['user' => \Filament\Facades\Filament::getUserName($user)]) }}
                        </h2>


                        <form action="{{ route('filament.auth.logout') }}" method="post" class="text-sm">
                            @csrf
                            @if($user->role == 'user' && $user->plan)
                                <b>{{\Illuminate\Support\Str::ucfirst($user->plan->title)}} |</b>
                            @endif

                            <button
                                type="submit"
                                @class([
                                    'text-gray-600 hover:text-primary-500 outline-none focus:underline',
                                    'dark:text-gray-300 dark:hover:text-primary-500' => config('filament.dark_mode'),
                                ])
                            >
                                {{ __('filament::widgets/account-widget.buttons.logout.label') }}
                            </button>


                        </form>

                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->role == "user")
                    <ul class="ml-58">
                        @php
                            //dd(\Illuminate\Support\Facades\Auth::user()->with('mediaSize','lastMonthDate')->first());
                              $user_details =  \App\Models\User::query()->with('mediaSize')->where("id","=",\Illuminate\Support\Facades\Auth::id())->first();

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

                                $last_responses = $last_responses->sum('number_of_response');

                            @endphp
                            <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                    {{$last_responses."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_response > 0 ? $user_details->plan->max_number_of_response : "∞") : "0")}}
               </span>
                        </li>
                        <li>
                            <b>Responses (GPT4)</b>
                            @php

                                $last_responses = $user_details->lastMonthDateWithCompany("gpt4");
                                $number_of_clicks = $user_details->lastMonthDateWithCompany();
                                $last_responses = $last_responses->sum('number_of_response');
                                $number_of_clicks = $number_of_clicks->sum('number_of_clicks');
                            @endphp
                            <span class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-primary-700 bg-primary-500/10 dark:text-primary-500">
                    {{$last_responses."|". (!empty($user_details->plan) ? ($user_details->plan->max_number_of_response > 0 ? $user_details->plan->max_number_of_response : "∞") : "0")}}
               </span>
                        </li>
                        <li>
                            <b>Clicks</b>
                            @php

                                $last_responses = $number_of_clicks;
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
            </div>
           @if(\Illuminate\Support\Facades\Auth::user()->role == "user")
                <div class="">
                    <form>
                        <div class="flex flex-col items-center">
                            <div class="w-162 md:w-1/2 flex flex-col items-center h-64">
                                <div class="w-50">
                                    <div x-data="selectConfigs()" x-init="fetchOptions()" class="flex flex-col items-center relative">
                                        <div class="w-full">
                                            <div @click.away="close()" class="my-2 p-1  flex border border-gray-200 rounded">
                                                <input
                                                    x-model="filter"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    @mousedown="open()"
                                                    @keydown.enter.stop.prevent="selectOption()"
                                                    @keydown.arrow-up.prevent="focusPrevOption()"
                                                    @keydown.arrow-down.prevent="focusNextOption()"
                                                    class="p-1 px-2 appearance-none outline-none w-full bg-none">
                                                <div class=" w-8 py-1 pl-2 pr-1 border-l flex items-center ">
                                                    <button type="button" @click="toggle()" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                        <svg  xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                                                            <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                                                        </svg>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="isOpen()" class="absolute shadow border border-gray-200 top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                                            <div class="flex flex-col w-full">
                                                <template x-for="(option, index) in filteredOptions()" :key="index">
                                                    <div @click="onOptionClick(index)" :class="classOption(option.name, index)" :aria-selected="focusedOptionIndex === index">
                                                        <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">

                                                            <div class="w-full items-center flex">
                                                                <div class="mx-2 -mt-1"><span x-text="option.name"></span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
           @endif

        </div>


        <script !src="">
            function selectConfigs() {
                return {
                    filter: '',
                    show: false,
                    selected: null,
                    focusedOptionIndex: null,
                    options: null,
                    close() {
                        this.show = false;
                        this.filter = this.selectedName();
                        this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
                    },
                    open() {
                        this.show = true;
                        this.filter = '';
                    },
                    toggle() {
                        if (this.show) {
                            this.close();
                        }
                        else {
                            this.open()
                        }
                    },
                    isOpen() { return this.show === true },
                    selectedName() { return this.selected ? this.selected.name : this.filter; },
                    classOption(id, index) {
                        const isSelected = this.selected ? (id == this.selected.name) : false;
                        const isFocused = (index == this.focusedOptionIndex);
                        return {
                            'cursor-pointer w-full border-gray-100 border-b hover:bg-blue-50': true,
                            'bg-blue-100': isSelected,
                            'bg-blue-50': isFocused
                        };
                    },
                    fetchOptions() {
                        fetch('{{route('filterMonths')}}')
                            .then(response => response.json())
                            .then(data => {
                                this.options = data;
                                const urlParams = new URLSearchParams(window.location.search);
                                const myParam = urlParams.get('index');
                                // Set default selection
                                if(myParam != undefined){
                                    this.selected = data.results[myParam];
                                    this.filter = data.results[myParam].name;
                                }
                                else if (data.results.length > 0) {
                                    this.selected = data.results[1];
                                    this.filter = data.results[1].name;
                                }
                            });


                    },
                    filteredOptions() {

                        return this.options
                            ? this.options.results.filter(option => {
                                return (option.name.toLowerCase().indexOf(this.filter) > -1)
                                    || (option.name.indexOf(this.filter) > -1)
                                    || (option.start.toLowerCase().indexOf(this.filter) > -1)
                                    || (option.end.toLowerCase().indexOf(this.filter) > -1)
                            })
                            : {}


                    },
                    onOptionClick(index) {
                        this.focusedOptionIndex = index;
                        //this.selectOption();
                        let selected = this.options.results[index];
                        window.location.href = "{{url('admin')}}?start="+selected.start+"&end="+selected.end+'&index='+index;

                        console.log(this.options.results,index,selected,"this.selectOption()");
                    },
                    selectOption() {
                        if (!this.isOpen()) {
                            return;
                        }
                        this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
                        const selected = this.filteredOptions()[this.focusedOptionIndex];

                        this.selected = selected;
                        this.filter = this.selectedName();
                        this.close();
                    },
                    focusPrevOption() {
                        if (!this.isOpen()) {
                            return;
                        }
                        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
                        if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
                            this.focusedOptionIndex--;
                        }
                        else if (this.focusedOptionIndex == 0) {
                            this.focusedOptionIndex = optionsNum;
                        }
                    },
                    focusNextOption() {
                        console.log('sdds')
                        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
                        if (!this.isOpen()) {
                            this.open();
                        }
                        if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
                            this.focusedOptionIndex = 0;
                        }
                        else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
                            this.focusedOptionIndex++;
                        }
                    }
                }

            }
        </script>

    </x-filament::card>
</x-filament::widget>
