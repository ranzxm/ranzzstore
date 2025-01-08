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
        Schema::create('input_fields', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("field_type");
            $table->boolean("is_required");
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->string("label_helper")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_fields');
    }
};
