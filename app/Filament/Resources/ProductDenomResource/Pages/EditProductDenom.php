<?php

namespace App\Filament\Resources\ProductDenomResource\Pages;

use App\Filament\Resources\ProductDenomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductDenom extends EditRecord
{
    protected static string $resource = ProductDenomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
