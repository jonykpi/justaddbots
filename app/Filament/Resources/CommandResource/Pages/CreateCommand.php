<?php

namespace App\Filament\Resources\CommandResource\Pages;

use App\Filament\Resources\CommandResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateCommand extends CreateRecord
{
    protected static string $resource = CommandResource::class;
    public function mount(): void
    {
        Cache::set('folder_id',request()->folder_id);
        parent::mount(); // TODO: Change the autogenerated stub
    }
    protected function afterCreate(): void
    {
        $this->record->folder_id = Cache::get('folder_id');
        $this->record->save();
        //$this->data['folder_id'] = Cache::get('folder_id');
       // dd($this->data);
    }
    protected function getRedirectUrl(): string
    {
        return route('filament.resources.commands.index',['folder_id'=>Cache::get('folder_id')]);
    }

}
