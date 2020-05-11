<?php

use Illuminate\Database\Seeder;

class TipoSolicitacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposSolicitacaos = [
            [
                'nome' => "RECLAMAÇÃO",
                'descricao' => "Relatar insatisfação com ações e serviços prestados",
                'icone' => "far fa-thumbs-down",
                'cor' => "warning",
                'sla' => 1,
                'status' => true
            ],
            [
                'nome' => "SUGESTÃO",
                'descricao' => "Propor ações úties para melhoria da gestão",
                'icone' => "far fa-comment-alt",
                'cor' => "info",
                'sla' => 1,
                'status' => true
            ],
            [
                'nome' => "ELOGIO",
                'descricao' => "Propor ações úties para melhoria da gestão",
                'icone' => "far fa-thumbs-up",
                'cor' => "success",
                'sla' => 1,
                'status' => true
            ],
            [
                'nome' => "SOLICITAÇÃO",
                'descricao' => "Requerer informações ou esclarecimento de dúvidas",
                'icone' => "far fa-hand-point-up",
                'cor' => "secondary",
                'sla' => 1,
                'status' => true
            ],
            [
                'nome' => "DENÚNCIA",
                'descricao' => "Apontar falhas na gestão ou no atendimento recebido",
                'icone' => "fas fa-bullhorn",
                'cor' => "danger",
                'sla' => 1,
                'status' => true
            ],
        ];

        foreach ($tiposSolicitacaos as $tipoSolicitacao) {
            $this->command->info('Inserindo Tipo de Solicitação: ' . $tipoSolicitacao['nome']);
            // DB::table('fv_ouv_tipo_solicitacao')->insert([
            DB::table('internet.fv_ouv_tipo_solicitacao')->insert([
                'nome' => $tipoSolicitacao['nome'], 
                'descricao' => $tipoSolicitacao['descricao'], 
                'icone' => $tipoSolicitacao['icone'], 
                'cor' => $tipoSolicitacao['cor'], 
                'sla' => $tipoSolicitacao['sla'], 
                'status' => $tipoSolicitacao['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }

}
