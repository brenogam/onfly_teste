<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeoutOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome_solicitante',
        'destino',
        'data_ida',
        'data_volta',
    ];
}


