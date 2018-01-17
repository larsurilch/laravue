<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modelo', 80);
            $table->integer('proprietario_id')->unsigned();
            $table->string('placa', 10);
            $table->integer('ano');
            $table->string('quilometragem', 45);
            $table->string('combustivel', 15);
            $table->integer('marca_id')->unsigned();
            $table->date('data_cotacao');
            $table->decimal('preco', 8, 2)->nullable();
            $table->integer('pais_id')->unsigned();
            $table->text('descricao');
            $table->timestamps();

            $table->foreign('proprietario_id')->references('id')->on('proprietarios')->onDelete('restrict');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('restrict');
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}
