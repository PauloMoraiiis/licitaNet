<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produto extends Model
{
    use HasFactory;
    protected $fillable = ['cidade_id', 'cod', 'nome', 'valor', 'estoque'];
}