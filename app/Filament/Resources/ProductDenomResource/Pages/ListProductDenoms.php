<?php

namespace App\Filament\Resources\ProductDenomResource\Pages;

use App\Filament\Resources\ProductDenomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductDenoms extends ListRecords
{
    protected static string $resource = ProductDenomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
