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
        Schema::create('product_promos', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("discount");
            $table->unsignedInteger("kuota");
            $table->timestamp("start")->useCurrent();
            $table->timestamp("end");
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_promos');
    }
};
