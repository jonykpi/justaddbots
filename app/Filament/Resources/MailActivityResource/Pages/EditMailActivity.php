<?php

namespace App\Filament\Resources\MailActivityResource\Pages;

use App\Filament\Resources\MailActivityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailActivity extends EditRecord
{
    protected static string $resource = MailActivityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
