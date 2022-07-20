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
            'cidade_id' => 'required|exists:cidades,id',
            'nome' => 'required',
            'cod' => 'required|unique:produtos,cod,'.$this->id.'|numeric',
            'valor' => 'required|numeric',
            'estoque' => 'required|numeric'
            
        ];
    }

    //Retorno das validações
    public function feedback() { 
        return [
            'cidade_id.exists' => 'Cidade informada não encontrada', 
            'required' => 'O campo :attribute é obrigatório',
            'numeric' => 'O campo :attribute deve ser um número',
            'cod.unique' => 'Já existe um produto com esse código cadastrado'
        ];
    }

    public function cidade() {

        return $this->belongsTo('App\Models\Cidade');
    }
}
