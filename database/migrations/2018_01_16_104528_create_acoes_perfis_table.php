<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcoesPerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acoes_perfis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('acao_id')->unsigned();
            $table->integer('perfil_id')->unsigned();
            $table->timestamps();

            $table->foreign('acao_id')->references('id')->on('acoes');
            $table->foreign('perfil_id')->references('id')->on('perfis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acoes_perfis');
    }
}
