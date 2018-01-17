<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProprietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 150);
            $table->string('tipo', 2);
            $table->string('documento', 25);
            $table->string('fone_principal', 18);
            $table->string('endereco', 150);
            $table->string('complemento', 80)->nullable();
            $table->string('bairro', 60);
            $table->string('cep', 10)->nullable();
            $table->integer('estado_id')->unsigned();
            $table->integer('cidade_id')->unsigned();
            $table->timestamps();

            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('restrict');
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proprietarios');
    }
}
