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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombreProd');
            $table->string('marcaProd');
            $table->string('presentacionProd');
            $table->decimal('precioCompraProd',8,2);
            $table->decimal('precioVentaProd',8,2);
            $table->integer('stockProd');
            $table->string('imagenProd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
