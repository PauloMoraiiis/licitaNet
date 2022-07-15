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
            $table->integer('cod');
            $table->string('nome');
            $table->decimal('valor', 2);
            $table->integer('estoque');
            $table->timestamps();
            $table->foreign('cidade_id')->references('id')->on('cidades'); //Usa o id da tabela cidades como tabela estrangeira na coluna cidades_id
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
