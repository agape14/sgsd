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
        Schema::create('finalidad', function (Blueprint $table) {
            $table->bigIncrements('CODI_FINALIDAD');
            $table->string('DESC_FINALIDAD',80)->notNull()->comment('Descripcion de la finalidad');
            $table->tinyInteger('ACTIVO')->nullable()->comment('1:Activo, 0: inactivo')->default(1);
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
        Schema::dropIfExists('finalidad');
    }
};
