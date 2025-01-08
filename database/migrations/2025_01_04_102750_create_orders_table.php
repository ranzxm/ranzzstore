<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("order_trx_id")->unique();
            $table->string("phone_number")->unique();
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->unsignedInteger("total_amount");
            $table->string("voucher_code")->nullable();
            $table->decimal("discount_percent")->nullable();
            $table->boolean("is_paid");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
