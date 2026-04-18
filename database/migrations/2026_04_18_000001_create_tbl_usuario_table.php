<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('acceso', 50)->unique();
            $table->string('secreto', 255);
            $table->tinyInteger('estado')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_usuario');
    }
};
