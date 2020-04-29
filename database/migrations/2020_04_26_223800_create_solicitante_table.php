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
        Schema::create('solicitante', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('solicitante_cod');
            $table->string('solicitante_nome', 120);
            $table->string('solicitante_cpf', 15);
            $table->string('solicitante_email', 120);
            $table->string('solicitante_telefone', 15)->nullable();
            $table->string('solicitante_celular', 15);
            $table->string('solicitante_uf', 2);
            $table->string('solicitante_cidade', 120);

            $table->unsignedBigInteger('institutora_cod');
            $table->foreign('institutora_cod')
                ->references('institutora_cod')
                ->on('institutora')
                ->onDelete('cascade');
                
            $table->unsignedBigInteger('tipo_solicitante_cod');
            $table->foreign('tipo_solicitante_cod')
                ->references('tipo_solicitante_cod')
                ->on('tipo_solicitante')
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
        Schema::dropIfExists('solicitante');
    }
}
