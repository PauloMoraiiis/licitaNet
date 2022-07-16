<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cria tabela produtos
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('cidade_id'); 
            $table->integer('cod')
            ->unique()
            ->unsigned();
            $table->string('nome');
            $table->float('valor', 20, 2);
            $table->integer('estoque');
            $table->timestamps();
            $table->foreign('cidade_id') //Usa o id da tabela cidades como tabela estrangeira na coluna cidades_id
            ->unsigned()
            ->nullable()
            ->references('id')
            ->on('cidades'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Derruba tabela produtos
        Schema::dropIfExists('produtos');
    }
}
