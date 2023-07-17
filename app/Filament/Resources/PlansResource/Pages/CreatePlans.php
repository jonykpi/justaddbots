<?php

namespace App\Filament\Resources\PlansResource\Pages;

use App\Filament\Resources\PlansResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlans extends CreateRecord
{
    protected static string $resource = PlansResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.resources.plans.index');
    }
}
