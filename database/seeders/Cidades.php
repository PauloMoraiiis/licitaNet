<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Cidades extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cidades')->insert(array (
            0 =>
            array (
                'nome' => 'Uberlândia',
            ),
            1 =>
            array (
                'nome' => 'São Paulo',
            ),
            2 =>
            array (
                'nome' => 'Rio de Janeiro',
            ),
            3 =>
            array (
                'nome' => 'Curitiba',
            ),
            4 =>
            array (
                'nome' => 'Santos',
            ),
    
        ));
    }
}
