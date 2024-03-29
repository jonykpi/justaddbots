<?php

namespace App\Filament\Resources\DynamicPromptResource\Pages;

use App\Filament\Resources\DynamicPromptResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateDynamicPrompt extends CreateRecord
{
    public function mount(): void
    {
        Cache::set('folder_id',request()->folder_id);
        parent::mount(); // TODO: Change the autogenerated stub
    }

    public function getRedirectUrl(): string
    {
        return route('filament.resources.dynamic-prompts.index',['folder_id'=>Cache::get('folder_id')]); // TODO: Change the autogenerated stub
    }

    protected static string $resource = DynamicPromptResource::class;
}
