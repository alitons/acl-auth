<?php
namespace Acl\Auth\Http\Controllers;

use Acl\Auth\Http\Requests\AutenticacaoRequest;
use Illuminate\Http\Request;

class AutenticacaoController extends Controller
{
    public function index(AutenticacaoRequest $request)
    {
        // VERIFICA SE JÁ ESTÁ LOGADO
        if(auth()->check() && @$request->callback) {
            return redirect()->route('dashboard');
        }

        return redirect(env('ACL_URL') . '/login/sistema?return=' . env('ACL_SLUG'));
    }

    public function logout()
    {
        auth()->logout();

        session([
            'user' => null
        ]);

        setcookie('SSO-USER-ACL', '', time() - 3600, "/");

        return redirect(env('ACL_URL') . '/logout/sistema?return=' . env('ACL_SLUG'));
    }

}
