<?php

use Illuminate\Database\Seeder;

class SituacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacaoes = [
            [
                'nome' => "Nova", 
                'descricao' => "Quando a demanda foi inserida no sistema, mas ainda não foi tratada.", 
                'cor' => 'success', 
                'status' => true
            ],
            [
                'nome' => "Em Análise", 
                'descricao' => "Quando a demanda já foi visualizada e está em análise pelo órgão competente.", 
                'cor' => 'info', 
                'status' => true
            ],
            [
                'nome' => "Concluída", 
                'descricao' => "Quando a Ouvidoria considera a demanda resolvida pelo órgão competente.", 
                'cor' => 'danger', 
                'status' => true
            ],
        ];

        foreach ($situacaoes as $situacao) {
            $this->command->info('Inserindo Situação: ' . $situacao['nome']);
            DB::table('fv_ouv_situacao')->insert([
                'nome' => $situacao['nome'],
                'descricao' => $situacao['descricao'],
                'cor' => $situacao['cor'],
                'status' => $situacao['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
    
}
