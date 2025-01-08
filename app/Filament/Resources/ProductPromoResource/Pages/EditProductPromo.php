<?php

namespace App\Filament\Resources\ProductPromoResource\Pages;

use App\Filament\Resources\ProductPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductPromo extends EditRecord
{
    protected static string $resource = ProductPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
