<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';

    protected $fillable = ['nome', 'email', 'senha'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'senha',
    ];

    
}
