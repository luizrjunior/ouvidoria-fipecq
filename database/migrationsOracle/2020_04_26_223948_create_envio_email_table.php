<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvioEmailTable extends Migration
{

    public function up()
    {
        Schema::create('internet.fv_ouv_envio_email', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('tipo_email_id');

            $table->unsignedBigInteger('ouvidoria_id')->nullable();
            $table->foreign('ouvidoria_id')
                ->references('id')
                ->on('fv_ouv_ouvidoria')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('internet.fv_ouv_envio_email');
    }
    
}
