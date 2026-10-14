@extends('adminlte::page')

@section('title', 'Lançamentos - Fluxo de Caixa')

@section('content_header')

@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lançamentos</h3>
        </div>

        <div class="card-body">
            <div>
                <a href="{{ route('fluxo-caixa.create') }}" type="button" class="btn btn-primary" style="width:80px;">Novo</a>
            </div>
            <br>
            <table class="table table-bordered table-striped dataTable dtr-inline" id="fluxo-caixa-table"
                style="font-size: 15px;">
                <thead>
                    <tr>
                        <th style="width: 10%">Data</th>
                        <th style="width: 10%">Tipo</th>
                        <th style="width: 20%">Categoria</th>
                        <th style="width: 15%">Valor</th>
                        <th style="width: 25%">Descrição</th>
                        <th style="width: 10%">Registrado por</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
@stop

@section('js')

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#fluxo-caixa-table').DataTable({
                // Diferente da tabela de Locação, aqui deixamos a paginação/busca
                // LIGADAS (não desabilitei searching/paging/info) — um controle
                // financeiro tende a acumular muitos lançamentos ao longo do tempo
                // (toda locação, toda conta de luz/água...), então faz sentido o
                // usuário conseguir paginar e filtrar.
                processing: true,
                serverSide: true,

                language: {
                    "url": "{{ asset('js/pt-br.json') }}"
                },
                ajax: "{{ route('fluxo-caixa.index') }}",
                columns: [{
                        data: 'data',
                        name: 'data'
                    },
                    {
                        data: 'tipo_formatado',
                        name: 'tipo',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'categoria_nome',
                        name: 'categoria.nome'
                    },
                    {
                        data: 'valor_formatado',
                        name: 'valor'
                    },
                    {
                        data: 'descricao',
                        name: 'descricao'
                    },
                    {
                        data: 'origin_user',
                        name: 'origin_user'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@stop