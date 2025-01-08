<?php

namespace App\Filament\Resources\ProductDenomPromoResource\Pages;

use App\Filament\Resources\ProductDenomPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductDenomPromos extends ListRecords
{
    protected static string $resource = ProductDenomPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
