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
        Schema::create('tipo_solicitacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('tipo_solicitacao_cod');
            $table->string('tipo_solicitacao_nome', 50);
            $table->string('tipo_solicitacao_descricao', 100);
            $table->string('tipo_solicitacao_icone', 50);
            $table->string('tipo_solicitacao_cor', 50);
            $table->integer('tipo_solicitacao_sla');
            $table->boolean('tipo_solicitacao_status');
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
        Schema::dropIfExists('tipo_solicitacao');
    }
}
