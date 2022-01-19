@extends('adminlte::page')

@section('content')
    <h2 class="page-title"><i class="fa fa-cogs"></i> Configurações</h2>

    <div class="row">
        <div class="col-md-3 hover" data-toggle="modal" data-target="#modal-alter-password">
            <div class="card card-primary">
                <div class="card-header" ></div>
                <div class="card-body text-center">
                    <i class="fa fa-lock fa-lg text-secondary" style="font-size: 2em;"></i>
                    <h3 class="text-secondary">Alterar Senha</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 hover" data-toggle="modal" data-target="#modal-alter-login">
            <div class="card card-primary">
                <div class="card-header" ></div>
                <div class="card-body text-center">
                    <i class="fa fa-user fa-lg text-secondary" style="font-size: 2em;"></i>
                    <h3 class="text-secondary">Alterar Login</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                @if($errors->any())
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-12">
                        <div class="alert-danger p-2 m-4"><strong>{{ $errors->first() }}</strong></div>
                    </div>
                </div>
                @endif
                    
                    @foreach( $parametros as $param )
                        <form method="POST" action="/params/update/{{ $param->id }}">
                            <div class="row mb-2">
                                <div class="col-2">
                                    <input name="operacao" type="text" class="form-control" value="{{$param->operacao}}" readonly>
                                </div>
                                <div class="col-2">
                                    <input name="atributo" type="text" class="form-control" value="{{$param->atributo}}" readonly>
                                </div>
                                <div class="col-7">
                                    <input name="valor" type="text" class="form-control" value="{{$param->valor}}">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="float-left btn btn-outline-success"><i class="far fa-check-circle"></i></button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" class="modal-md" aria-modal="true" id="modal-alter-password">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alterar Senha</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-alter-password">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="confirm_password">Confirme a Senha</label>
                                    <input type="password" class="form-control" id="confirm_password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-right">
                <button  type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-alter-password" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" class="modal-md" aria-modal="true" id="modal-alter-login">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alterar Login: <b>{{ Auth::user()->login }}</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-alter-login">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="login">Login</label>
                                    <input type="text" class="form-control" id="login">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-right">
                <button  type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-alter-login" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="{{ @mix('/js/dashboards/config.js') }}"></script>
@stop