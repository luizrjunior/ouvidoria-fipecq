<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.FV_OUV_TIPO_SOLICITACAO', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->string('NOME', 50);
            $table->string('DESCRICAO', 100);
            $table->string('ICONE', 50);
            $table->string('COR', 50);
            $table->integer('SLA');
            $table->boolean('STATUS');
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
        Schema::dropIfExists('internet.FV_OUV_TIPO_SOLICITACAO');
    }
}
