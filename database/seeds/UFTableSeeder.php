<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UFTableSeeder extends Seeder {

    public function run() {

        DB::disableQueryLog();

        $ufs = array(
            array("uf_sigla" => "AC", "uf_descricao" => "ACRE"),
            array("uf_sigla" => "AL", "uf_descricao" => "ALAGOAS"),
            array("uf_sigla" => "AM", "uf_descricao" => "AMAZONAS"),
            array("uf_sigla" => "AP", "uf_descricao" => "AMAPA"),
            array("uf_sigla" => "BA", "uf_descricao" => "BAHIA"),
            array("uf_sigla" => "CE", "uf_descricao" => "CEARA"),
            array("uf_sigla" => "DF", "uf_descricao" => "DISTRITO FEDERAL"),
            array("uf_sigla" => "ES", "uf_descricao" => "ESPIRITO SANTO"),
            array("uf_sigla" => "GO", "uf_descricao" => "GOIAS"),
            array("uf_sigla" => "MA", "uf_descricao" => "MARANHAO"),
            array("uf_sigla" => "MG", "uf_descricao" => "MINAS GERAIS"),
            array("uf_sigla" => "MS", "uf_descricao" => "MATO GROSSO DO SUL"),
            array("uf_sigla" => "MT", "uf_descricao" => "MATO GROSSO"),
            array("uf_sigla" => "PA", "uf_descricao" => "PARA"),
            array("uf_sigla" => "PB", "uf_descricao" => "PARAIBA"),
            array("uf_sigla" => "PE", "uf_descricao" => "PERNANBUCO"),
            array("uf_sigla" => "PI", "uf_descricao" => "PIAUI"),
            array("uf_sigla" => "PR", "uf_descricao" => "PARANA"),
            array("uf_sigla" => "RJ", "uf_descricao" => "RIO DE JANEIRO"),
            array("uf_sigla" => "RN", "uf_descricao" => "RIO GRANDE DO NORTE"),
            array("uf_sigla" => "RO", "uf_descricao" => "RONDONIA"),
            array("uf_sigla" => "RR", "uf_descricao" => "RORAIMA"),
            array("uf_sigla" => "RS", "uf_descricao" => "RIO GRANDE DO SUL"),
            array("uf_sigla" => "SC", "uf_descricao" => "SANTA CATARINA"),
            array("uf_sigla" => "SE", "uf_descricao" => "SERGIPE"),
            array("uf_sigla" => "SP", "uf_descricao" => "SAO PAULO"),
            array("uf_sigla" => "TO", "uf_descricao" => "TOCANTINS"),
        );

        foreach ($ufs as $uf) {
            $this->command->info('Inserindo ufs de ' . $uf['uf_sigla']);
            DB::table('uf')->insert([
                'uf_sigla' => $uf['uf_sigla'],
                'uf_descricao' => $uf['uf_descricao'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

}
