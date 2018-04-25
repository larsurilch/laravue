<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Cache;

class UsuariosController extends Controller
{
    private $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function index(Request $request)
    {
        $perfil = $email = $ativo = '';
        $column = 'usuarios.email';
        $direction = 'asc';
        $per_page = 30;

        if($request->has('per_page')) {
            $per_page = $request->input('per_page');
        }

        if($request->has('direction')) {
            $direction = $request->input('direction');
        }

        if($request->has('column')) {
            $column = $request->input('column');
        }

        $usuarios = $this->usuario->orderBy($column, $direction)
            ->join('perfis', 'perfis.id', '=', 'usuarios.perfil_id')
            ->select('usuarios.id', 'usuarios.email', 'perfis.descricao AS perfil', 'usuarios.ativo', 'usuarios.created_at',
                'usuarios.updated_at');

        if($request->has('perfil')) {
            $usuarios = $usuarios->where('perfis.descricao', 'LIKE', "%". $request->input('perfil') ."%");
            $perfil = $request->input('perfil');
        }

        if($request->has('email')) {
            $usuarios = $usuarios->where('usuarios.email', 'LIKE', "%". $request->input('email') ."%");
            $email = $request->input('email');
        }

        if($request->has('ativo')) {
            $usuarios = $usuarios->where('usuarios.ativo', '=', $request->input('ativo'));
            $ativo = $request->input('ativo');
        }

        $usuarios = $usuarios->paginate($per_page);

        $response = [
            'usuarios' => $usuarios,
            'params' => [
                'total' => $usuarios->total(),
                'per_page' => $usuarios->perPage(),
                'current_page' => $usuarios->currentPage(),
                'last_page' => $usuarios->lastPage(),
                'next_page_url' => $usuarios->nextPageUrl(),
                'prev_page_url' => $usuarios->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'perfil' => $perfil,
                'email' => $email,
                'ativo' => $ativo
            ]
        ];

        return response()->json($response);
    }

    public function store(UsuarioRequest $request)
    {
        $inputs = $request->all();
        $this->usuario->create($inputs);
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG001')
        ]);
    }

    public function show($id)
    {
        $usuario = $this->usuario->find($id);

        if(count($usuario) > 0)
            return response()->json($usuario);

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function update(UsuarioRequest $request, $id)
    {
        $inputs = $request->all();
        $query = $this->usuario->where('id', $id);

        if(isset($inputs['senha'])) {
            $inputs['senha'] = bcrypt($inputs['senha']);
        }

        $query->update($inputs);

        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG002')
        ]);
    }

    public function destroy($id)
    {
        try {
            $usuario = $this->usuario->find($id);
            $usuario->delete();

            return response()->json([
                'success' => true,
                'status' => 'positive',
                'message' => message('MSG003')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'negative',
                'message' => message('MSG005 ')
            ]);
        }
    }

    public function authenticated()
    {
        $auth = auth()->user();
        $acl = [];

        foreach ($auth->perfil->acoes as $acao) {
            if(strpos($acao->metodo, '|') !== false) {
                $pipe = explode('|', $acao->metodo);
                $acl[] = $pipe[0];
                $acl[] = $pipe[1];
            } else {
                $acl[] = $acao->metodo;
            }
        }

        $usuario = [
            'id' => $auth->id,
            'perfil_id' => $auth->perfil_id,
            'email' => $auth->email,
            'acl' => $acl
        ];

        return response()->json($usuario);
    }

    public function logout(Request $request)
    {
        if(Cache::has('acoes_' . $request->id)) {
            Cache::forget('acoes_' . $request->id);
        }

        return response()->json([
            'status' => 'positive',
            'message' => message('MSG007')
        ]);
    }
}
