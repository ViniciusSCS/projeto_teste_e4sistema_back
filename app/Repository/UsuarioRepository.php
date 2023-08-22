<?php

namespace App\Repository;

use App\Models\User;

class UsuarioRepository
{
    public function find($id)
    {
        return User::find($id);
    }

    public function list()
    {
        return User::all();
    }

    public function create($data)
    {
        return User::create([
            'nome' => $data['nome'],
            'usuario' => $data['usuario'],
            'email' => strtolower($data['email']),
            'password' => bcrypt($data['password']),
        ]);
    }
}
