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
        // Schema::create('fv_ouv_sub_classificacao', function (Blueprint $table) {
        Schema::create('internet.fv_ouv_sub_classificacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('descricao', 100);
            $table->boolean('status');

            $table->unsignedBigInteger('classificacao_id');
            $table->foreign('classificacao_id')
                ->references('id')
                ->on('fv_ouv_classificacao')
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
        Schema::dropIfExists('fv_ouv_sub_classificacao');
        // Schema::dropIfExists('internet.fv_ouv_sub_classificacao');
    }
}
