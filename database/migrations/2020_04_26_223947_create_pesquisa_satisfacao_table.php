<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesquisaSatisfacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.fv_ouv_pesquisa_satisfacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('resposta_1');
            $table->integer('resposta_2');
            $table->text('resposta_3')->nullable();

            $table->unsignedBigInteger('ouvidoria_id');
            $table->foreign('ouvidoria_id')
                ->references('id')
                ->on('fv_ouv_ouvidoria')
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
        Schema::dropIfExists('internet.fv_ouv_pesquisa_satisfacao');
    }
    
}
