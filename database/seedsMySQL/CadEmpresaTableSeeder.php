<?php

use Illuminate\Database\Seeder;

class CadEmpresaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->command->info('Inserindo Empresa (Institutora): FBN - FUNDACAO BIBLIOTECA NACIONAL');
        DB::table('cad_empresa')->insert([
            'nome' => 'FBN - FUNDACAO BIBLIOTECA NACIONAL'
        ]);
        
        $this->command->info('Inserindo Empresa (Institutora): ANBENE - ASSOC NACIONAL DOS BENEFICIADOS PELA LEI 8878/94');
        DB::table('cad_empresa')->insert([
            'nome' => 'ANBENE - ASSOC NACIONAL DOS BENEFICIADOS PELA LEI 8878/94'
        ]);

        $this->command->info('Inserindo Empresa (Institutora): ACI - ASSOCIACAO DOS CORRETORES DE IMOVEIS DO DF');
        DB::table('cad_empresa')->insert([
            'nome' => 'ACI - ASSOCIACAO DOS CORRETORES DE IMOVEIS DO DF'
        ]);

        $this->command->info('Inserindo Empresa (Institutora): IPJB - INST PESQUISA JARDIM BOTANICO');
        DB::table('cad_empresa')->insert([
            'nome' => 'IPJB - INST PESQUISA JARDIM BOTANICO'
        ]);

        $this->command->info('Inserindo Empresa (Institutora): INPI - INSTITUTO NACIONAL DA PROPRIEDADE INDUSTRIAL');
        DB::table('cad_empresa')->insert([
            'nome' => 'INPI - INSTITUTO NACIONAL DA PROPRIEDADE INDUSTRIAL'
        ]);
    }

}
