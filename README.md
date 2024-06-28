
# ACL Auth - Laravel

Essa pacote tem como objetivo facilitar a integração do ACL da SEAD/AC com os demais sistemas que utilizam o framework Laravel.

### 💻 Requisitos

**Laravel:** ^8.x

**Composer:** ^2.x
### 🔓 Criando uma permissão para acessar o pacote

    1. Acesse sua conta no git.ac.gov.br
    2. Clique sobre a sua foto de perfil, localizada no canto superior esquerdo da tela.
    3. Clique na opção "Preferences"
    4. No menu lateral, clique na opção "Acess Tokens"
    5. Crie um novo token de acesso clicando em "Add new token"
    6. Marque a opção "read_api" e preencha as demais informações de acordo com sua necessidade. Em sequida clique em "Create personal access token"
    7. Salve o seu token de acesso em um local seguro.

Em seu terminal local digite
 
```bash
composer config --global --auth gitlab-token.git.ac.gov.br {seu-token-gerado}
```

Em seu arquivo `composer.json` adicione:

```json
...
"repositories": [
    {
        "type": "vcs",
        "url": "git@git.ac.gov.br:sead/acl-auth"
    }
]
...
```
### 📤 Instalação

Execute no terminal

```bash
composer require sead/acl-auth
```

Esse pacote adiciona por padrão as migrations de usuário, permissões, órgãos e lotações. Caso você já tenha essas migrations **não rode o comando a baixo**.

Se for uma instalação nova do Laravel rode o comando 


```bash
php artisan vendor:publish --provider="Acl\Auth\AclAuthServiceProvider"
```

Adicione ao seu arquivo `.env`

Em desenvolvimento  a url do ACL deve ser: https://dev.sead.ac.gov.br/acl

Em Homologação a url do ACL deve ser https://homologacao.sead.ac.gov.br/acl

Em Produção a url do ACL deve ser https://acl.ac.gov.br


```php
...
ACL_URL=url-do-acl
URL_ACESSO=slug-do-seu-sistema-no-acl
...
```
Adicione ao seu arquivo de rotas `routes/web.php`.

```diff
...
+ Route::get('login', [Acl\Auth\Http\Controllers\AutenticacaoController::class, 'index'])->name('login');
...
Route::middleware('auth')->group(function () {
    ...
+    Route::get('logout', [Acl\Auth\Http\Controllers\AutenticacaoController::class, 'logout'])->name('logout');
    ...
});
```

No arquivo `config/auth.php` altere o trecho

```diff
...
'providers' => [
    'users' => [
        'driver' => 'eloquent',
-       'model' => App\Models\User::class,
+       'model' => Acl\Auth\Models\Usuario::class,
    ...
],
...
```

No Laravel 11, se preferir adiciona apenas a informação no `.env`

```php
...
AUTH_MODEL=Acl\Auth\Models\Usuario::class
...
```

No arquivo `app\Providers\AppServiceProvider.php` Adicione

```diff
...
+ use Acl\Auth\Http\Services\Autenticacao\PermissaoService;
...
public function boot(): void
{
+    PermissaoService::setPermissoes();
    ...
}

```
