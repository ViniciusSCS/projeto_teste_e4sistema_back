<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\{
    LoginRequest,
    UsuarioRequest,
    UsuarioUpdateRequest
};
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;

class UsuarioController extends Controller
{
    protected $service;
    protected $tokenRepository;

    public function __construct(UsuarioService $service, TokenRepository $tokenRepository)
    {
        $this->service = $service;
        $this->tokenRepository = $tokenRepository;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();

        if (Auth::attempt(['email' => strtolower($data['email']), 'password' => $data['password']])) {
            $user = Auth::user();

            if ($user->status != env("TXT_ATIVO")) {
                return ['status' => false, 'message' => 'Usuário foi deletado ou inativo!'];
            }

            $user = User::find($user->id);
            $token = $user->createToken('JWT')->plainTextToken;

            return ['status' => true, 'message' => 'Usuário logado com sucesso!', "usuario" => $user, "token" => $token];
        } else {
            return ['status' => false, 'message' => 'Usuário ou senha estão incorretos'];
        }
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return ['status' => true, 'message' => 'Usuário deslogado com sucesso!'];
    }


    public function create(UsuarioRequest $request)
    {
        $data = $request->all();

        $user = $this->service->create($data);

        return ['status' => true, "messages" => 'Usuário cadastrado com sucesso', "usuario" => $user];
    }

    public function list()
    {
        $query = $this->service->list();

        return ['status' => true, "usuarios" => $query];
    }

    public function show($id)
    {
        $user = $this->service->find($id);

        $info = ($user == NULL
            ? ['status' => false, 'message' => 'Usuário não encotrado']
            : ['status' => true, 'message' => 'Usuário encontrado', "user" => $user]
        );

        return $info;
    }

    public function update(UsuarioUpdateRequest $request, $id)
    {
        $user = $this->service->find($id);
        $data = $request->all();

        $userUpdate = $this->service->update($data, $id);

        $user->update($data);

        return ['status' => true, 'message' => 'Usuário atualizado com sucesso.', "usuario" => $user];
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        if ($id == $user->id) {
            dd('usuário não pode ser excluido');
        } else {
            $data = [
                'status' => env("TXT_INATIVO"),
                'deleted_at' => now()
            ];

            $user = User::find($id);

            $user->update($data);

            $user->tokens()->where('tokenable_id', '=', $id)->delete();

            return ['status' => true, 'message' => 'Usuário deletado com sucesso!', "usuario" => $user];
        }
    }
}
