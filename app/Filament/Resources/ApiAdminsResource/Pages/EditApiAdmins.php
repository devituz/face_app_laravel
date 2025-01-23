<?php

namespace App\Filament\Resources\ApiAdminsResource\Pages;

use App\Filament\Resources\ApiAdminsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiAdmins extends EditRecord
{
    protected static string $resource = ApiAdminsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
