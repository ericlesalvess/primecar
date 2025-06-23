@extends('adminlte::page')

@section('title', 'Cadastro de Veículos')

@section('content_header')
@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Veículos</h3>
        </div>

        <div class="card-body">
            <div>
                <a href="{{ route('veiculo.create') }}" type="button" class="btn btn-primary" style="width:80px;">Novo</a>
            </div>
            <br>
            <table class="table table-bordered table-striped dataTable dtr-inline" id="veiculo-table" style="font-size: 15px;">
                <thead>
                    <tr>
                        <th style="width: 5%">Id</th>
                        <th style="width: 10%">Modelo</th>
                        <th style="width: 5%">Marca</th>
                        <th style="width: 5%">Origem</th>
                        <th style="width: 5%">Placa</th>
                        <th style="width: 5%">Renavam</th>
                        <th style="width: 5%">Chassi</th>
                        <th style="width: 5%">Ano de Fabricação</th>      
                        <th style="width: 5%">Cor</th>
                        <th style="width: 5%">Combustível</th>
                        <th style="width: 5%">Observações</th>
                        <th style="width: 5%">Ações</th>
                    
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

            $('#veiculo-table').DataTable({
                 // Desabilita a pesquisa, paginação e informações
                searching: false,
                lengthChange: false,
                paging: false,
                info: false,

                language: {
                    "url": "{{ asset('js/pt-br.json') }}"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('veiculo.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'modelo',
                        name: 'modelo'
                    },
                    {
                        data: 'marca',
                        name: 'marca'
                    },
                    {
                         data: 'origem',
                         name: 'origem',
                        render: function (data) {
                            if (data == 0) {
                                 return '<span class="badge badge-success">Nacional</span>';
                            } else if (data == 1) {
                                return '<span class="badge 	badge bg-danger ">Importado</span>';
                             }
                                return data;
                        }
                 },
                    {
                        data: 'placa',
                        name: 'placa'
                    },
                    {
                        data: 'renavam',
                        name: 'renavam'
                    },
                    {
                        data: 'chassi',
                        name: 'chassi'
                    },
                    {
                        data: 'ano_fabricacao',
                        name: 'ano_fabricacao'
                    },
                    {
                        data: 'cor',
                        name: 'cor'
                    },
                    {
                        data: 'tipo_combustivel',
                        name: 'tipo_combustivel'
                    },
                    {
                        data: 'observacoes',
                        name: 'observacoes'
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
