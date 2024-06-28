<?php
namespace Acl\Auth\Http\Middleware;

use Acl\Auth\Models\Usuario;
use Acl\Auth\Models\Permissao;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class PermissoesMiddleware
{
    public static function setPermissoes(): void
    {
        //VERIFICA SE TEM A TABELA DE PERMISSÕES
        if (!Schema::hasTable('permissoes')) {
            return;
        }

        // LISTA TODAS AS PERMISSÕES
        $permissoes = Permissao::all();

        // VERIFICA SE O USUÁRIO TEM PERMISSÃO DE ADMINISTRADOR
        Gate::define('administrador', function(Usuario $usuario) {
            if(@session('user')['orgao_atual'] && @session('user')['permissoes'][session('user')['orgao_atual']]['administrador']) {
                return true;
            }
            return false;
        });

        // VERIFICA SE O USUÁRIO TEM OUTRAS PERMISSÕES
        if($permissoes) {
            foreach ($permissoes as $permissao) {
                Gate::define($permissao->id, function(Usuario $usuario) use ($permissao) {
                    if(
                        Gate::allows('administrador') ||
                        @session('user')['orgao_atual'] && @session('user')['permissoes'][session('user')['orgao_atual']][$permissao->id]
                    ) {
                        return true;
                    }
                    return false;
                });

                //TIPO CRUD
                if($permissao->tipo_crud == 'S') {
                    for($i=1;$i<=4;$i++) {
                        Gate::define($permissao->id . '.' . $i , function(Usuario $usuario) use ($permissao, $i) {

                            if(
                                Gate::allows('administrador') ||
                                @session('user')['orgao_atual'] && @session('user')['permissoes'][session('user')['orgao_atual']][$permissao->id . '.' . $i ]
                            ) {
                                return true;
                            }
                            return false;
                        });
                    }
                }
            }
        }
    }
}