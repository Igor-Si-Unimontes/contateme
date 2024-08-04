<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    use HasFactory;
    protected $fillable = [
        'telefone',
        'nome',
        'email',
        'imagem',
    ];

    public function getImagemAttribute($value)
    {
        if (!$value) {
            return null;
        }
    
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
    
        return asset('storage/' . $value);
    }
    
}
