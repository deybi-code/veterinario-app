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
    Schema::create('atenciones', function (Blueprint $table) {
        $table->id();
        // Relación con veterinarios (Llave foránea)
        $table->foreignId('veterinario_id')->constrained('veterinarios')->onDelete('cascade');
        $table->string('mascota');
        $table->text('diagnostico');
        $table->date('fecha');
        $table->string('imagen')->nullable(); // Guardará la ruta de la foto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencions');
    }
};
