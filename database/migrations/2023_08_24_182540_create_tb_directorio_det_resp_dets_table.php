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
        Schema::create('tb_directorio_det_resp_dets', function (Blueprint $table) {
            $table->decimal('CODI_SESION', 18, 0)->nullable();
            $table->decimal('CODI_PERIODO', 4, 0)->nullable();
            $table->smallInteger('NUME_SECUEN')->nullable();
            $table->integer('CODI_AREA')->nullable();
            $table->integer('CODI_DOCU_SUSTENTO')->nullable();
            $table->integer('CODI_DO_SGD')->nullable();
            $table->string('DESC_DOCUMENTO', 250)->nullable();
            $table->text('DESC_COMENTARIO')->nullable();
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
        Schema::dropIfExists('tb_directorio_det_resp_dets');
    }
};
