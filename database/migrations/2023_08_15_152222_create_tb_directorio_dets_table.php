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
        Schema::create('tb_directorio_dets', function (Blueprint $table) {
            $table->decimal('CODI_SESION', 18, 0)->notNull();
            $table->decimal('CODI_PERIODO', 4, 0)->nullable(false);
            $table->smallInteger('NUME_SECUEN')->notNull();
            $table->string('DESC_TEMA', 250)->notNull();
            $table->integer('CODI_FINALIDAD')->notNull();
            $table->integer('CODI_ESTADO')->notNull();
            $table->datetime('FECH_LIMITE')->notNull();
            $table->decimal('NUME_AVANCE', 18, 4)->notNull();
            $table->string('DESC_COMENTARIO', 500)->nullable();
            $table->primary(['CODI_SESION', 'CODI_PERIODO', 'NUME_SECUEN']);
            $table->foreign(['CODI_SESION', 'CODI_PERIODO'])->references(['CODI_SESION', 'CODI_PERIODO'])->on('tb_directorio_cabs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_directorio_dets');
    }
};
