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
        Schema::create('tb_directorio_det_resps', function (Blueprint $table) {
            $table->decimal('CODI_SESION', 18, 0)->notNull();
            $table->decimal('CODI_PERIODO', 4, 0)->notNull();
            $table->smallInteger('NUME_SECUEN')->notNull();
            $table->integer('CODI_AREA')->notNull();
            $table->integer('CODI_DOCU_SUSTENTO')->nullable();
            $table->integer('CODI_DO_SGD')->nullable();
            $table->string('DESC_DOCUMENTO', 250)->nullable();
            $table->string('DESC_COMENTARIO', 250)->nullable();
            $table->integer('CODI_ESTADO')->nullable();
            $table->primary(['CODI_SESION', 'CODI_PERIODO', 'NUME_SECUEN', 'CODI_AREA']);
            $table->foreign(['CODI_SESION', 'CODI_PERIODO', 'NUME_SECUEN'])->references(['CODI_SESION', 'CODI_PERIODO', 'NUME_SECUEN'])->on('tb_directorio_dets');
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
        Schema::dropIfExists('tb_directorio_det_resps');
    }
};
