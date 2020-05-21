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
        Schema::create('fv_ouv_solicitante', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome', 120);
            $table->string('cpf', 15);
            $table->string('email', 120);
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15);
            $table->string('uf', 2);
            $table->string('cidade', 120);

            $table->unsignedBigInteger('institutora_id')->nullable();
            // $table->foreign('institutora_id')
            //     ->references('empresa')
            //     ->on('plano.cad_empresa')
            //     ->onDelete('cascade');
                
            $table->unsignedBigInteger('tipo_solicitante_id');
            $table->foreign('tipo_solicitante_id')
                ->references('id')
                ->on('fv_ouv_tipo_solicitante')
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
        Schema::dropIfExists('fv_ouv_solicitante');
    }
}
