<?php

namespace App\Filament\Resources\CommandResource\Pages;

use App\Filament\Resources\CommandResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cache;

class ListCommands extends ListRecords
{
    protected static string $resource = CommandResource::class;
    public function mount(): void
    {

        Cache::set('folder_id',request()->folder_id);
        parent::mount(); // TODO: Change the autogenerated stub
    }

    protected function getActions(): array
    {

        return [
            Actions\CreateAction::make()->url(route('filament.resources.commands.create')."?folder_id=".Cache::get('folder_id')),
            Actions\Action::make("Back")->label('Back')->url(route('filament.resources.folders.view',Cache::get('folder_id'))),
        ];
    }
}
