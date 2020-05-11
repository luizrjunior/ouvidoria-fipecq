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
        // Schema::create('fv_ouv_canal_atendimento', function (Blueprint $table) {
        Schema::create('internet.fv_ouv_canal_atendimento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('descricao', 100);
            $table->boolean('status');
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
        // Schema::dropIfExists('fv_ouv_canal_atendimento');
        Schema::dropIfExists('internet.fv_ouv_canal_atendimento');
    }
}
