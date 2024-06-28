<?php

namespace Acl\Auth\Console\Commands;

use Acl\Auth\Models\Lotacao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Lotacoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:lotacoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa as lotações do ACL.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = env('ACL_URL') . '/api/sync/lotacoes/' . env('URL_ACESSO');
        $resposta = Http::post($url);
        $dados = $resposta->json();

        foreach($dados as $lotacao) {
            Lotacao::updateOrCreate([
                'id_lotacao' => $lotacao['cod_lotacao'],
                'id_orgao' => @$lotacao['cod_orgao'] ?? null
            ],
            [
                'nome_lotacao' => @$lotacao['nome_lotacao'] ?? null,
                'sigla_lotacao' => @$lotacao['sigla_lotacao'] ?? null,
            ]);
        }

        $this->info('Lotações importadas com sucesso.');
    }
}
