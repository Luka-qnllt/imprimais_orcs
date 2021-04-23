@extends('adminlte::page')

@section('content')
    <h2 class="page-title">Orçamentos</h2>
    <form>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search-pagamento">Pagamento</label>
                                    <select id="search-pagamento" class="form-control search-reset">
                                        <option value="">Todos</option>
                                        <option value="PG">Pago</option>
                                        <option value="PD" selected>Pendente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search-status">Status</label>
                                    <select  id="search-status" class="form-control">
                                        <option value="" selected>Todos</option>
                                        <option value="5">Não Iniciado</option>
                                        <option value="4">Aguardando Aprovação</option>
                                        <option value="3">Em Andamento</option>
                                        <option value="2">Concluído</option>
                                        <option value="1">Entregue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search-prioridade">Prioridade</label>
                                    <select  id="search-prioridade" class="form-control">
                                        <option value="" selected>Todos</option>
                                        <option value="1">Alta</option>
                                        <option value="2">Média</option>
                                        <option value="3">Baixa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search-inicio">Data de Início</label>
                                    <input  type="date" id="search-inicio" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="btn-search" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                <button type="button" id="btn-clean-seach" class="btn btn-danger"><i class="fa fa-times"></i> Limpar</button>
                            </div>
                            <div class="col-md-6">
                                <div class="badge badge-danger">Pendentes: <span id="pendentes"></span></div>
                                <div class="badge badge-success">Recebido: <span id="recebido"></span></div>
                                <div class="badge badge-warning">A Receber: <span id="receber"></span></div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="open-modal-orc" class="btn btn-success float-right"><i class="fa fa-plus"></i> Novo</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="table-orc" class="table table-sm table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nota</th>
                                                <th>Pedido</th>
                                                <th>Solicitante</th>
                                                <th>Início</th>
                                                <th>Status</th>
                                                <th>Valor</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="orcs-wrap"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="modal fade" class="modal-xl" aria-modal="true" id="modal-orc">
        <div class="modal-dialog modal-xxl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Orçamento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-orc">
                        <input type="hidden" name="id">
                        <div class="row">

                            <!-- ROW -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="responsavel">Responsável</label>
                                    <input type="text" class="form-control" name="responsavel">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inicio">Início</label>
                                    <input type="date" class="form-control" name="inicio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="previsao">Previsão</label>
                                    <input type="text" class="form-control" name="previsao">
                                </div>
                            </div>

                            <!-- ROW -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="solicitante">Solicitante</label>
                                    <input type="text" class="form-control" name="solicitante">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prioridade">Prioridade</label>
                                    <select class="form-control" name="prioridade">
                                        <option value="1">Alta</option>
                                        <option value="2" selected>Média</option>
                                        <option value="3">Baixa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="5" selected>Não Iniciado</option>
                                        <option value="4">Aguardando Aprovação</option>
                                        <option value="3">Em Andamento</option>
                                        <option value="2">Concluído</option>
                                        <option value="1">Entregue</option>
                                    </select>
                                </div>
                            </div>

                            <!-- ROW -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pedido">Pedido</label>
                                    <input type="text" class="form-control" name="pedido">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nota_fiscal">Nota Fiscal</label>
                                    <input type="text" class="form-control" name="nota_fiscal">
                                </div>
                            </div>

                            <!-- ROW -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control" name="telefone">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valor_total">Valor Total</label>
                                    <input type="text" class="form-control money" name="valor_total">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pagamento">Pagamento</label>
                                    <select class="form-control" name="pagamento">
                                        <option value="PD" selected>Pendente</option>
                                        <option value="PG">Pago</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 bg-light">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ítem</th>
                                                <th style="width: 10em;">Qtd.</th>
                                                <th style="width: 10em;">Valor Un.</th>
                                                <th>Total <span id="total-itens"></span></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="itens-wrap">
                                        </tbody>
                                        <tfooter class="bg-light">
                                            <tr>
                                                <td></td>
                                                <td><input type="text" id="new-item-item" class="form-control item-reset"></td>
                                                <td><input type="number" id="new-item-qtd" class="form-control item-reset"></td>
                                                <td><input type="text" id="new-item-valor-un" class="form-control money item-reset"></td>
                                                <td></td>
                                                <td><i class="fa fa-plus text-primary mt-2 hover" id="btn-add-item"></i></td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="obs">Observações</label>
                                <textarea name="obs" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-right">
                <button  type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-orc" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="{{ @mix('/js/dashboards/orcamentos.js') }}"></script>
@stop