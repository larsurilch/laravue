<?php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Usuario;

class CustomAccessTokenController extends AccessTokenController
{
    public function issueUserToken(ServerRequestInterface $request)
    {
        $httpRequest = request();

        if($httpRequest->grant_type == 'password') {
            $usuario = Usuario::where('email', $httpRequest->username)
                ->where('ativo', 1)
                ->first();

            if($usuario == NULL) {
                return response()->json([
                    'status' => 'negative',
                    'message' => message('MSG006')
                ]);
            }

            foreach ($usuario->perfil->acoes as $acao) {
                if(strpos($acao->metodo, '|') !== false) {
                    $pipe = explode('|', $acao->metodo);
                    $acoes[] = $pipe[0];
                    $acoes[] = $pipe[1];
                } else {
                    $acoes[] = $acao->metodo;
                }
            }

            Cache::add('acoes_' .  $usuario->id, $acoes, 120);

            return $this->issueToken($request);
        }
    }
}
