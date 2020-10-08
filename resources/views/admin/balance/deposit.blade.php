@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Fazer Recarga</h1>

    <ol>
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Depositar</a></li>
    </ol>
@stop
@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Fazer Recarga</h3>
        </div>
        <div class="box-body">
            <form action=" {{route('deposit.store')}} " method="POST">
                {!! csrf_field()!!}
                <div class="form-group">
                    <input type="text" placeholder="Valor Recarga" class="form-control" name="value">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Recarregar</button>
                </div>
            </form>
        </div>
    </div>
@stop