<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadBenefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_benef', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('matricula');
            $table->string('nome', 100);
            $table->string('cic', 14);
            $table->string('email', 120);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_benef');
    }
    
}
