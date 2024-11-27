<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokensInvalidados extends Model
{
    use HasFactory;

    protected $table = 'tokens_invalidados';

    protected $fillable = ['token', 'data_expiracao'];

}
