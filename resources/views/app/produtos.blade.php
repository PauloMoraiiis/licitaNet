@extends('layouts.app')

@section('content')
    <listar_produtos-component" csrf_token='{{ @csrf_token() }}'></listarProdutos-component>
@endsection
