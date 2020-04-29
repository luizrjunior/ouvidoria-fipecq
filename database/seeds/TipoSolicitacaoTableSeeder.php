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
        DB::table('tipo_solicitacao')->insert([
            'tipo_solicitacao_nome' => "RECLAMAÇÃO",
            'tipo_solicitacao_descricao' => "Relatar insatisfação com ações e serviços prestados",
            'tipo_solicitacao_icone' => "far fa-thumbs-down",
            'tipo_solicitacao_cor' => "warning",
            'tipo_solicitacao_sla' => 1,
            'tipo_solicitacao_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitacao')->insert([
            'tipo_solicitacao_nome' => "SUGESTÃO",
            'tipo_solicitacao_descricao' => "Propor ações úties para melhoria da gestão",
            'tipo_solicitacao_icone' => "far fa-comment-alt",
            'tipo_solicitacao_cor' => "info",
            'tipo_solicitacao_sla' => 1,
            'tipo_solicitacao_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitacao')->insert([
            'tipo_solicitacao_nome' => "ELOGIO",
            'tipo_solicitacao_descricao' => "Propor ações úties para melhoria da gestão",
            'tipo_solicitacao_icone' => "far fa-thumbs-up",
            'tipo_solicitacao_cor' => "success",
            'tipo_solicitacao_sla' => 1,
            'tipo_solicitacao_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitacao')->insert([
            'tipo_solicitacao_nome' => "SOLICITAÇÃO",
            'tipo_solicitacao_descricao' => "Requerer informações ou esclarecimento de dúvidas",
            'tipo_solicitacao_icone' => "far fa-hand-point-up",
            'tipo_solicitacao_cor' => "secondary",
            'tipo_solicitacao_sla' => 1,
            'tipo_solicitacao_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        DB::table('tipo_solicitacao')->insert([
            'tipo_solicitacao_nome' => "DENÚNCIA",
            'tipo_solicitacao_descricao' => "Apontar falhas na gestão ou no atendimento recebido",
            'tipo_solicitacao_icone' => "fas fa-bullhorn",
            'tipo_solicitacao_cor' => "danger",
            'tipo_solicitacao_sla' => 1,
            'tipo_solicitacao_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
