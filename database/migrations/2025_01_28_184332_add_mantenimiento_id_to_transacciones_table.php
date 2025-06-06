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
        Schema::table('transacciones', function (Blueprint $table) {
            $table->unsignedBigInteger('venta_id')->nullable()->change(); // Hacer que venta_id sea nulleable
            $table->unsignedBigInteger('mantenimiento_id')->nullable(); // Agregar columna mantenimiento_id
        
            $table->foreign('mantenimiento_id')->references('id')->on('mantenimientos')->onDelete('cascade'); // Agregar clave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transacciones', function (Blueprint $table) {
            if (Schema::hasColumn('transacciones', 'mantenimiento_id')) {
                $table->dropForeign(['mantenimiento_id']); // Eliminar clave foránea de mantenimiento_id
                $table->dropColumn('mantenimiento_id'); // Eliminar columna mantenimiento_id
            }
            $table->unsignedBigInteger('venta_id')->nullable(false)->change(); // Revertir venta_id a no nulleable
        });
    }
};
