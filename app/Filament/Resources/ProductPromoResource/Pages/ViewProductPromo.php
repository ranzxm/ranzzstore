<?php

namespace App\Filament\Resources\ProductPromoResource\Pages;

use App\Filament\Resources\ProductPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductPromo extends ViewRecord
{
    protected static string $resource = ProductPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
