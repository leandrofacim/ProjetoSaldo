@extends('adminlte::page')

@section('title', 'Transferir Saldo')

@section('content_header')
    <h1>Transferir</h1>

    <ol>
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
    </ol>
@stop
@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Transferir Saldo (Informe o Recebedor)</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form action=" {{route('confirm.transfer')}} " method="POST">
                {!! csrf_field()!!}

                <div class="form-group">
                    <input type="text" placeholder="Informação de quem vai receber o saque (Nome ou E-mail)" class="form-control" name="sender">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Próxima Etapa</button>
                </div>

            </form>
        </div>
    </div>
@stop