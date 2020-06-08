<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituacaoOuvidoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.fv_ouv_situacao_ouvidoria', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('comentario');

            $table->unsignedBigInteger('ouvidoria_id');
            $table->foreign('ouvidoria_id')
                ->references('id')
                ->on('fv_ouv_ouvidoria')
                ->onDelete('cascade');

            $table->unsignedBigInteger('situacao_id');
            $table->foreign('situacao_id')
                ->references('id')
                ->on('fv_ouv_situacao')
                ->onDelete('cascade');

            $table->unsignedBigInteger('usuario_id')->nullable();

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
        Schema::dropIfExists('internet.fv_ouv_situacao_ouvidoria');
    }
    
}
