<?php

namespace App\Filament\Resources\ProductPromoResource\Pages;

use App\Filament\Resources\ProductPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductPromos extends ListRecords
{
    protected static string $resource = ProductPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
