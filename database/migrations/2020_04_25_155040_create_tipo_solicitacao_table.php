<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('fv_ouv_tipo_solicitacao', function (Blueprint $table) {
        Schema::create('internet.fv_ouv_tipo_solicitacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome', 50);
            $table->string('descricao', 100);
            $table->string('icone', 50);
            $table->string('cor', 50);
            $table->integer('sla');
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
        // Schema::dropIfExists('fv_ouv_tipo_solicitacao');
        Schema::dropIfExists('internet.fv_ouv_tipo_solicitacao');
    }
}
