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
        Schema::create('internet.FV_OUV_SUB_CLASSIFICACAO', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->string('DESCRICAO', 100);
            $table->boolean('STATUS');

            $table->unsignedBigInteger('CLASSIFICACAO_ID');
            $table->foreign('CLASSIFICACAO_ID')
                ->references('ID')
                ->on('FV_OUV_CLASSIFICACAO')
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
        Schema::dropIfExists('internet.FV_OUV_SUB_CLASSIFICACAO');
    }
}
