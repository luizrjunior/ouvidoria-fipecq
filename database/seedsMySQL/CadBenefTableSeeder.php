<?php

use Illuminate\Database\Seeder;

class CadBenefTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->command->info('Inserindo Beneficiário: Daniel Silva');
        DB::table('cad_benef')->insert([
            'nome' => 'DANIEL LUIZ DA SILVA',
            'cic' => '88260429187',
            'email' => 'dannls@hotmail.com',
            'estado' => 'DF',
            'nocidade' => 'BRASILIA'
        ]);
        
        $this->command->info('Inserindo Beneficiário: Anna Silva de Sa');
        DB::table('cad_benef')->insert([
            'nome' => 'ANNA SILVA DE SA',
            'cic' => '31487793715',
            'email' => 'aoliveira@cetem.gov.br',
            'estado' => 'DF',
            'nocidade' => 'BRASILIA'
        ]);

        $this->command->info('Inserindo Beneficiário: Alfredo Eduardo A de Paula');
        DB::table('cad_benef')->insert([
            'nome' => 'ALFREDO EDUARDO A DE PAULA',
            'cic' => '45149194620',
            'email' => 'alfredo.eduardo@pop.com.br',
            'estado' => 'DF',
            'nocidade' => 'BRASILIA'
        ]);
    }

}
