<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOuvidoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.fv_ouv_ouvidoria', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('protocolo');
            $table->text('mensagem');
            $table->text('observacao')->nullable();
            $table->string('anexo', 255)->nullable();

            $table->unsignedBigInteger('tp_ouvidoria_id');
            $table->foreign('tp_ouvidoria_id')
                ->references('id')
                ->on('fv_ouv_tp_ouvidoria')
                ->onDelete('cascade');

            $table->unsignedBigInteger('tipo_solicitante_id');
            $table->foreign('tipo_solicitante_id')
                ->references('id')
                ->on('fv_ouv_tipo_solicitante')
                ->onDelete('cascade');

            $table->unsignedBigInteger('situacao_id');
            $table->foreign('situacao_id')
                ->references('id')
                ->on('fv_ouv_situacao')
                ->onDelete('cascade');
    
            $table->unsignedBigInteger('solicitante_id')->nullable();
            $table->foreign('solicitante_id')
                ->references('id')
                ->on('fv_ouv_solicitante')
                ->onDelete('cascade');

            $table->unsignedBigInteger('canal_atendimento_id')->nullable();
            $table->foreign('canal_atendimento_id')
                ->references('id')
                ->on('fv_ouv_canal_atendimento')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')
                ->references('id')
                ->on('fv_ouv_categoria')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('setor_id')->nullable();
            $table->foreign('setor_id')
                ->references('id')
                ->on('fv_ouv_setor')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('assunto_id')->nullable();
            $table->foreign('assunto_id')
                ->references('id')
                ->on('fv_ouv_assunto')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('classificacao_id')->nullable();
            $table->foreign('classificacao_id')
                ->references('id')
                ->on('fv_ouv_classificacao')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('sub_classificacao_id')->nullable();
            $table->foreign('sub_classificacao_id')
                ->references('id')
                ->on('fv_ouv_sub_classificacao')
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
        Schema::dropIfExists('internet.fv_ouv_ouvidoria');
    }
    
}
