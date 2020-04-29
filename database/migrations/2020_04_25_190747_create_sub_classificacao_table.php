<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubclassificacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_classificacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('sub_classificacao_cod');
            $table->string('sub_classificacao_descricao', 100);
            $table->boolean('sub_classificacao_status');
            $table->unsignedBigInteger('classificacao_cod');
            $table->foreign('classificacao_cod')
                ->references('classificacao_cod')
                ->on('classificacao')
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
        Schema::dropIfExists('sub_classificacao');
    }
}
