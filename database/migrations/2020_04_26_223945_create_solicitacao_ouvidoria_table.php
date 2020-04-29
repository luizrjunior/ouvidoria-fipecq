<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoOuvidoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacao_ouvidoria', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('solicitacao_ouvidoria_cod');
            $table->integer('solicitacao_ouvidoria_protocolo');
            $table->string('solicitacao_ouvidoria_mensagem', 255);
            $table->string('solicitacao_ouvidoria_anexo', 255)->nullable();

            $table->unsignedBigInteger('tipo_solicitacao_cod');
            $table->foreign('tipo_solicitacao_cod')
                ->references('tipo_solicitacao_cod')
                ->on('tipo_solicitacao')
                ->onDelete('cascade');

            $table->unsignedBigInteger('solicitante_cod');
            $table->foreign('solicitante_cod')
                ->references('solicitante_cod')
                ->on('solicitante')
                ->onDelete('cascade');

            $table->unsignedBigInteger('tipo_prestador_cod')->nullable();
            $table->foreign('tipo_prestador_cod')
                ->references('tipo_prestador_cod')
                ->on('tipo_prestador')
                ->onDelete('cascade');

            $table->unsignedBigInteger('sub_classificacao_cod')->nullable();
            $table->foreign('sub_classificacao_cod')
                ->references('sub_classificacao_cod')
                ->on('sub_classificacao')
                ->onDelete('cascade');

            $table->unsignedBigInteger('assunto_cod')->nullable();
            $table->foreign('assunto_cod')
                ->references('assunto_cod')
                ->on('assunto')
                ->onDelete('cascade');

            $table->unsignedBigInteger('canal_atendimento_cod')->nullable();
            $table->foreign('canal_atendimento_cod')
                ->references('canal_atendimento_cod')
                ->on('canal_atendimento')
                ->onDelete('cascade');
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
        Schema::dropIfExists('solicitacao_ouvidoria');
    }
}
