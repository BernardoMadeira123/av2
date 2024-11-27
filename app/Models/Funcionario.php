<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'documento',
        'sexo',
        'data_nascimento',
        'telefone',
        'email',
        'endereco',
        'cargo',
        'salario',
        'status',
    ];

    protected $dates = [
        'data_nascimento',
        'created_at',
        'updated_at',
    ];
}
