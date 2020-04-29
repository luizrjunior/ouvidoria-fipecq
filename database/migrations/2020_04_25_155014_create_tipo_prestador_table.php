<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPrestadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_prestador', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('tipo_prestador_cod');
            $table->string('tipo_prestador_descricao', 100);
            $table->boolean('tipo_prestador_status');
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
        Schema::dropIfExists('tipo_prestador');
    }
}
