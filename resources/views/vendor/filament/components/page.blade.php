@props([
    'modals' => null,
    'widgetData' => [],
])

<div {{ $attributes->class(['filament-page']) }}>
    <div class="space-y-6">
        @if ($header = $this->getHeader())
            {{ $header }}
        @elseif ($heading = $this->getHeading())
            <x-filament::header :actions="$this->getCachedActions()">
                <x-slot name="heading" class="full-w">
                    <span>
                        {{ $heading }}
                    </span>



                    @if(!empty($this->previousUrl) && !isset($this->data['parent_folder_id']) && isset($this->data['id']) && \Request::route()->getName() != "filament.resources.contents.edit")
                       <div>
                           <a href="{{route('filament.resources.bot.create',['p'=>$this->data['id']])}}" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                               Add folder
                           </a>

                           @php
                           $folder = \App\Models\Folder::find($this->data['id']);
                           @endphp

                            @if(!empty($folder->children) && count($folder->children) == 0)
                               <a href="{{route('delete.folder',['folder_id'=>$folder->id])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-danger-600 hover:bg-danger-500 focus:bg-danger-700 focus:ring-offset-primary-700 filament-page-button-action">
                                   {{__('Delete folder')}}
                               </a>
                            @endif

                       </div>

                    @endif
                    @if(!empty($this->previousUrl) && isset($this->data['parent_folder_id']))
                        <a href="{{$this->previousUrl}}" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                            Back
                        </a>
                    @endif

                </x-slot>







                @if ($subheading = $this->getSubheading())
                    <x-slot name="subheading">
                        {{ $subheading }}
                    </x-slot>
                @endif
            </x-filament::header>
        @endif

        {{ \Filament\Facades\Filament::renderHook('page.header-widgets.start') }}

        @if ($headerWidgets = $this->getVisibleHeaderWidgets())
            <x-filament::widgets
                :widgets="$headerWidgets"
                :columns="$this->getHeaderWidgetsColumns()"
                :data="$widgetData"
            />
        @endif

        {{ \Filament\Facades\Filament::renderHook('page.header-widgets.end') }}

        {{ $slot }}

        {{ \Filament\Facades\Filament::renderHook('page.footer-widgets.start') }}

        @if ($footerWidgets = $this->getVisibleFooterWidgets())
            <x-filament::widgets
                :widgets="$footerWidgets"
                :columns="$this->getFooterWidgetsColumns()"
                :data="$widgetData"
            />
        @endif

        {{ \Filament\Facades\Filament::renderHook('page.footer-widgets.end') }}

        @if ($footer = $this->getFooter())
            {{ $footer }}
        @endif
    </div>

    <form wire:submit.prevent="callMountedAction">
        @php
            $action = $this->getMountedAction();
        @endphp

        <x-filament::modal
            id="page-action"
            :wire:key="$action ? $this->id . '.actions.' . $action->getName() . '.modal' : null"
            :visible="filled($action)"
            :width="$action?->getModalWidth()"
            :slide-over="$action?->isModalSlideOver()"
            :close-by-clicking-away="$action?->isModalClosedByClickingAway()"
            display-classes="block"
            x-init="livewire = $wire.__instance"
            x-on:modal-closed.stop="if ('mountedAction' in livewire?.serverMemo.data) livewire.set('mountedAction', null)"
        >
            @if ($action)
                @if ($action->isModalCentered())
                    @if ($heading = $action->getModalHeading())
                        <x-slot name="heading">
                            {{ $heading }}
                        </x-slot>
                    @endif

                    @if ($subheading = $action->getModalSubheading())
                        <x-slot name="subheading">
                            {{ $subheading }}
                        </x-slot>
                    @endif
                @else
                    <x-slot name="header">
                        @if ($heading = $action->getModalHeading())
                            <x-filament::modal.heading>
                                {{ $heading }}
                            </x-filament::modal.heading>
                        @endif

                        @if ($subheading = $action->getModalSubheading())
                            <x-filament::modal.subheading>
                                {{ $subheading }}
                            </x-filament::modal.subheading>
                        @endif
                    </x-slot>
                @endif

                {{ $action->getModalContent() }}

                @if ($action->hasFormSchema())
                    {{ $this->getMountedActionForm() }}
                @endif

                {{ $action->getModalFooter() }}

                @if (count($action->getModalActions()))
                    <x-slot name="footer">
                        <x-filament::modal.actions :full-width="$action->isModalCentered()">
                            @foreach ($action->getModalActions() as $modalAction)
                                {{ $modalAction }}
                            @endforeach
                        </x-filament::modal.actions>
                    </x-slot>
                @endif
            @endif
        </x-filament::modal>
    </form>

    {{ $this->modal }}

    @stack('modals')
</div>
