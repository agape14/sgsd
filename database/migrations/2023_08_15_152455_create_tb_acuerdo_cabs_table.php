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
        Schema::create('tb_acuerdo_cabs', function (Blueprint $table) {
            $table->decimal('CODI_SESION', 18, 0)->notNull();
            $table->decimal('CODI_PERIODO', 4, 0)->notNull();
            $table->smallInteger('NUME_SECUEN')->notNull();
            $table->smallInteger('NUME_SECUEN_ACUER')->notNull();
            $table->string('DESC_ACUERDO', 250)->notNull();
            $table->primary(['CODI_SESION', 'CODI_PERIODO', 'NUME_SECUEN', 'NUME_SECUEN_ACUER']);
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
        Schema::dropIfExists('tb_acuerdo_cabs');
    }
};
