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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->date('fecha_ingreso');
            $table->date('fecha_estimada_entrega')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->decimal('monto_total', 10, 2)->default(0);
            $table->text('descripcion')->nullable();
            $table->decimal('monto_mantenimiento', 10, 2)->default(0);
            $table->decimal('monto_adicional', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
