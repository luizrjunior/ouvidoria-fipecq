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
        Schema::create('internet.FV_OUV_SOLICITACAO_OUVIDORIA', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->integer('PROTOCOLO');
            $table->string('MENSAGEM', 255);
            $table->string('ANEXO', 255)->nullable();

            $table->unsignedBigInteger('TIPO_SOLICITACAO_ID');
            $table->foreign('TIPO_SOLICITACAO_ID')
                ->references('ID')
                ->on('FV_OUV_TIPO_SOLICITACAO')
                ->onDelete('cascade');

            $table->unsignedBigInteger('SOLICITANTE_ID');
            $table->foreign('SOLICITANTE_ID')
                ->references('ID')
                ->on('FV_OUV_SOLICITANTE')
                ->onDelete('cascade');

            $table->unsignedBigInteger('TIPO_PRESTADOR_ID')->nullable();
            $table->foreign('TIPO_PRESTADOR_ID')
                ->references('ID')
                ->on('FV_OUV_TIPO_PRESTADOR')
                ->onDelete('cascade');

            $table->unsignedBigInteger('SUB_CLASSIFICACAO_ID')->nullable();
            $table->foreign('SUB_CLASSIFICACAO_ID')
                ->references('ID')
                ->on('FV_OUV_SUB_CLASSIFICACAO')
                ->onDelete('cascade');

            $table->unsignedBigInteger('ASSUNTO_ID')->nullable();
            $table->foreign('ASSUNTO_ID')
                ->references('ID')
                ->on('FV_OUV_ASSUNTO')
                ->onDelete('cascade');

            $table->unsignedBigInteger('CANAL_ATENDIMENTO_ID')->nullable();
            $table->foreign('CANAL_ATENDIMENTO_ID')
                ->references('ID')
                ->on('FV_OUV_CANAL_ATENDIMENTO')
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
        Schema::dropIfExists('internet.FV_OUV_SOLICITACAO_OUVIDORIA');
    }
}
