<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanalAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canal_atendimento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('canal_atendimento_cod');
            $table->string('canal_atendimento_descricao', 100);
            $table->boolean('canal_atendimento_status');
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
        Schema::dropIfExists('canal_atendimento');
    }
}
