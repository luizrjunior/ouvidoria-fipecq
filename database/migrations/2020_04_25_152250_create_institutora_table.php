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
        Schema::create('institutora', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('institutora_cod');
            $table->string('institutora_descricao', 100);
            $table->boolean('institutora_status');
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
        Schema::dropIfExists('institutora');
    }
}
