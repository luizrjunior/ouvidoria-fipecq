<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet.FV_OUV_INSTITUTORA', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->string('DESCRICAO', 100);
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
        Schema::dropIfExists('internet.FV_OUV_INSTITUTORA');
    }
}
