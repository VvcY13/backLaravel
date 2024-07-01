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
        Schema::create('quejasyreclamos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_personal');
            $table->enum('asunto',['Quejas', 'Sugerencias', 'Opiniones']);
            $table->string('comentario');
            $table->timestamps();
            $table->foreign('id_personal')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
