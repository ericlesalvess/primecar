@extends('adminlte::page')

@section('title', 'Cadastro de Veículos')

@section('content_header')
    <h1>Catálogo</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Veículos</h3>
        </div>

        <div class="card-body">
            {{-- <div>
                <a href="{{ route('veiculo.create') }}" type="button" class="btn btn-primary" style="width:80px;">Novo</a>
            </div>
            <br> --}}
            <table class="table table-bordered table-striped dataTable dtr-inline" id="veiculo-table" style="font-size: 15px;">
                <thead>
                    <tr>
                        <th style="width: 15%">Modelo</th>
                        <th style="width: 10%">Marca</th>
                        <th style="width: 10%">Ano</th>
                        <th style="width: 10%">Cor</th>
                        <th style="width: 10%">Combustível</th>
                        <th style="width: 50%">Obs.</th>
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
                language: {
                    "url": "{{ asset('js/pt-br.json') }}"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('veiculo.index') }}",
                columns: [
                    {
                        data: 'modelo',
                        name: 'modelo'
                    },
                    {
                        data: 'marca',
                        name: 'marca'
                    },
            
                    {
                        data: 'ano_fabricacao',
                        name: 'ano_fabricacao',
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

                ]
            });
        });
    </script>
@stop

