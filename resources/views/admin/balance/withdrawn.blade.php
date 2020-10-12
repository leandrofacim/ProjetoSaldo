@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Fazer Retirada</h1>

    <ol>
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Retirada</a></li>
    </ol>
@stop
@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Fazer Retirada</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form action=" {{ route('withdrawn.store') }} " method="POST">
                {!! csrf_field()!!}
                <div class="form-group">
                    <input type="text" placeholder="Valor Retirada" class="form-control" name="value">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sacar</button>
                </div>
            </form>
        </div>
    </div>
@stop