<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'endereco',
        'user_id'
    ];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function telefone()
    {
        return $this->hasMany(Telefone::class, 'pessoa_id', 'id');
    }
}
