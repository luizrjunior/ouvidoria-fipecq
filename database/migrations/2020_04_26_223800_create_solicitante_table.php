<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.FV_OUV_SOLICITANTE', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->string('NOME', 120);
            $table->string('CPF', 15);
            $table->string('EMAIL', 120);
            $table->string('TELEFONE', 15)->nullable();
            $table->string('CELULAR', 15);
            $table->string('UF', 2);
            $table->string('CIDADE', 120);

            $table->unsignedBigInteger('INSTITUTORA_ID');
            $table->foreign('INSTITUTORA_ID')
                ->references('ID')
                ->on('FV_OUV_INSTITUTORA')
                ->onDelete('cascade');
                
            $table->unsignedBigInteger('TIPO_SOLICITANTE_ID');
            $table->foreign('TIPO_SOLICITANTE_ID')
                ->references('ID')
                ->on('FV_OUV_TIPO_SOLICITANTE')
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
        Schema::dropIfExists('internet.FV_OUV_SOLICITANTE');
    }
}
