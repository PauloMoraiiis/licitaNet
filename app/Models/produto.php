<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produto extends Model
{
    use HasFactory;
    protected $fillable = ['cidade_id', 'cod', 'nome', 'valor', 'estoque'];

    //Regras de validação
    public function rules() {
        return [
            'cod' => 'required|unique:produtos,cod,'.$this->id.'',
            'cidade_id' => 'required'
        ];
    }

    //Retorno das validações
    public function feedback() { 
        return [
            'required' => 'O campo :attribute é obrigatório',
            'cod.unique' => 'Já existe um produto com esse código cadastrado'
        ];
    }
}
