<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_directorio_cabs', function (Blueprint $table) {
            $table->decimal('CODI_SESION', 18, 0)->nullable(false);
            $table->decimal('CODI_PERIODO', 4, 0)->nullable(false);
            $table->datetime('FECH_PROGRAMADA');
            $table->char('CODI_ESTADO', 4);
            $table->timestamps();
            $table->primary(['CODI_SESION', 'CODI_PERIODO']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_directorio_cabs');
    }
};
