<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Voucher;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $voucher = Voucher::query()->where("code", $data["voucher_code"])->first();
        // dd($voucher);
        if (!$voucher) {
            $data["voucher_code"] = null;
            $data["discount"] = 0;
            return $data;
        } else {
            $total_amount_after_discount = $data["total_amount"] - ($data["total_amount"] * ($voucher->discount / 100));
            $data["total_amount"] = $total_amount_after_discount;
            $data["discount"] = $voucher->discount;
            $voucher->kuota = $voucher->kuota - 1;
            $voucher->save();
            return $data;
        }
    }
}
