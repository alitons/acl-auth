<?php
namespace Acl\Auth\Http\Services;

use Acl\Auth\Models\Usuario;
use Illuminate\Support\Facades\Http;

class AutenticacaoService
{
    static function getData(String $token): object | bool
    {
        $resposta = Http::post(env('ACL_URL') . '/api/login', [
            'token' => $token,
            'sistema' => env('ACL_SLUG')
        ]);

        $dados = $resposta->json();

        // return response()->json($dados);
        dd('PACOTE:', $resposta,$dados);

        if(isset($dados['usuario'])) {
            $permissoes = self::getPermissoes($dados);

            if(
                $permissoes['permissoes'] &&
                $permissoes['perfis'] &&
                count($permissoes['permissoes']) > 0 &&
                @$dados['usuario']['orgao_exercicio_id'] &&
                @$dados['usuario']['setor'] &&
                @$dados['usuario']['setor']['cod_lotacao']
            ) {
                $user = Usuario::updateOrCreate([
                    'cpf' => $dados['usuario']['cpf'],
                ],
                [
                    'nome' => $dados['usuario']['name'],
                    'nivel' => $dados['usuario']['nivel'],
                    'email' => $dados['usuario']['email'],
                    'email_funcional' => $dados['usuario']['email_funcional'],
                    'foto' => $dados['usuario']['foto']
                ]);

                session([
                    'user' => [
                        'perfis' => $permissoes['perfis'],
                        'permissoes' => $permissoes['permissoes'],
                        'orgao_atual' => $dados['usuario']['orgao_exercicio_id'],
                        'lotacao_atual' => $dados['usuario']['setor']['cod_lotacao'],
                    ],
                ]);

                //CRIAR O COOKIE
                setcookie('SSO-USER-ACL', $dados['usuario']['id'], time() + (86400 * 30), "/");

                auth()->loginUsingId($user->id);

                return true;
            }

            abort(403, 'Você não tem permissão para acessar este sistema.<br>Verifique se foi definida sua lotação no ACL.');
        }

        return false;
    }
}