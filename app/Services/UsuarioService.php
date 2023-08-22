<?php

namespace App\Services;

use App\Repository\UsuarioRepository;
use Laravel\Passport\TokenRepository;

class UsuarioService
{
    protected $repository;
    protected $tokenRepository;

    public function __construct(UsuarioRepository $repository, TokenRepository $tokenRepository)
    {
        $this->repository = $repository;
        $this->tokenRepository = $tokenRepository;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create($data)
    {
        $user = $this->repository->create($data);

        $userFind = $this->find($user->id);

        $token = $userFind->createToken('JWT')->plainTextToken;

        return $user;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function update($data, $id)
    {
        if (isset($data['password'])) {
            $data = [
                'id' => $id,
                'nome' => $data['nome'],
                'usuario' => $data['usuario'],
                'email' => strtolower($data['email']),
                'password'  => bcrypt($data['password'])
            ];
        } else {
            $data = [
                'nome' => $data['nome'],
                'usuario' => $data['usuario'],
                'email' => strtolower($data['email']),
            ];
        }

        return $data;
    }
}
