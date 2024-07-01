<?php

use Carbon\Traits\Timestamp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_personal');
            $table->decimal('total',10,2);
            $table->timestamps();

            $table->foreign('id_personal')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('detalleVentas', function (Blueprint $table){
            $table->id();
            $table->bigInteger('id_venta');
            $table->bigInteger('id_producto');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->timestamps();

            $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('id_producto')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('detalleVentas');
    }
};
