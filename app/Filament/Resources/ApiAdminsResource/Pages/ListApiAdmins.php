<?php

namespace App\Filament\Resources\ApiAdminsResource\Pages;

use App\Filament\Resources\ApiAdminsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApiAdmins extends ListRecords
{
    protected static string $resource = ApiAdminsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
