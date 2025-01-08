<?php

namespace App\Filament\Resources\InputFieldResource\Pages;

use App\Filament\Resources\InputFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInputFields extends ListRecords
{
    protected static string $resource = InputFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
