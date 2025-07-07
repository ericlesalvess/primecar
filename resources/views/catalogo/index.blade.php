@extends('adminlte::page')

@section('title', 'Cadastro de Veículos')

@section('content_header')
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
            {{-- 
            <table class="table table-bordered table-striped dataTable dtr-inline" id="veiculo-table" style="font-size: 15px;">
                <thead>
                    <tr>
                        <th style="width: 15%">Modelo</th>
                        <th style="width: 10%">Marca</th>
                        <th style="width: 10%">Origem</th>
                        <th style="width: 10%">Ano</th>
                        <th style="width: 10%">Cor</th>
                        <th style="width: 10%">Combustível</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 20%">Observação</th>
                    </tr>
                </thead>
            </table>
            --}}

            <div class="container">
                <div class="row">
                    @foreach($veiculos as $veiculo)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow">
                            @php
                                // Busca a foto marcada como capa, se não houver pega a primeira
                                $fotoCapa = $veiculo->fotos->where('capa', true)->first() ?? $veiculo->fotos->first();
                            @endphp
                            @if($fotoCapa)
                                <img src="{{ asset('storage/' . $fotoCapa->caminho) }}" class="card-img-top" alt="Foto do veículo">
                            @else
                                <img src="{{ asset('img/sem-foto.png') }}" class="card-img-top" alt="Sem foto">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $veiculo->modelo }}</h5>
                                <p class="card-text">
                                    Marca: {{ $veiculo->marca }}<br>
                                    Ano: {{ $veiculo->ano_fabricacao ?? '' }}<br>
                                    Cor: {{ $veiculo->cor }}<br>
                                    Status:
                                    @if($veiculo->saldo == 1)
                                        <span class="badge badge-success">Disponível</span>
                                    @elseif($veiculo->saldo == 0)
                                        <span class="badge badge-danger">Alugado</span>
                                    @else
                                        <span class="badge badge-secondary">Indefinido</span>
                                    @endif
                                </p>
                                <a href="#" class="btn btn-primary btn-block">Ver detalhes</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
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
                        data: 'saldo',
                        name: 'saldo',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge badge-success">Disponível</span>';
                            } else if (data == 0) {
                                return '<span class="badge badge-danger">Alugado</span>';
                            } else {
                                return data;
                            }
                        }
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

