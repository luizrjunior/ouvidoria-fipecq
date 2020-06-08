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
        $this->call(TipoSolicitanteTableSeeder::class);
        $this->call(TpOuvidoriaTableSeeder::class);
        $this->call(SituacaoTableSeeder::class);
        $this->call(CanalAtendimentoTableSeeder::class);
    }
}
