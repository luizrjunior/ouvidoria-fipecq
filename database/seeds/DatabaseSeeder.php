<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UFTableSeeder::class);
        $this->call(TipoSolicitanteTableSeeder::class);
        $this->call(TipoSolicitacaoTableSeeder::class);
    }
}
