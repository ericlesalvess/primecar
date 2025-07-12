@extends('adminlte::page')

@section('title', 'Catálogo de Veículos')

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
                    <div class="col-md-4 mb-4 d-flex justify-content-center">
                        <div class="card card-catalogo shadow w-100">
                            @php
                                // Busca a foto marcada como capa, se não houver pega a primeira
                                $fotoCapa = $veiculo->fotos->where('capa', true)->first() ?? $veiculo->fotos->first();
                            @endphp
                            @if($fotoCapa)
                                <img src="{{ asset('storage/' . $fotoCapa->caminho) }}" class="card-img-top card-img-catalogo" alt="Foto do veículo">
                            @else
                                <img src="{{ asset('img/sem-foto.png') }}" class="card-img-top card-img-catalogo" alt="Sem foto">
                            @endif
                            <div class="card-body d-flex flex-column">
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
                                <div class="mt-auto">
                                    <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#carroModal{{ $veiculo->id }}">Ver detalhes</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal com carrossel estilizado e classes customizadas -->
                    <div class="modal fade" id="carroModal{{ $veiculo->id }}" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-veiculo-detalhe">
                          <div class="modal-header modal-header-veiculo">
                            <h5 class="modal-title text-veiculo-nome">{{ $veiculo->modelo }} - {{ $veiculo->marca }}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                              <span>&times;</span>
                            </button>
                          </div>
                          <div class="modal-body modal-body-veiculo row">
                            <div class="col-md-7">
                              <div id="carousel{{ $veiculo->id }}" class="carousel slide">
                                <div class="carousel-inner">
                                  @foreach($veiculo->fotos as $key => $foto)
                                  <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $foto->caminho) }}" class="d-block w-100 carousel-veiculo-img" alt="Foto {{ $key+1 }}">
                                  </div>
                                  @endforeach
                                </div>
                                @if($veiculo->fotos->count() > 1)
                                  <a class="carousel-control-prev" href="#carousel{{ $veiculo->id }}" data-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
                                  </a>
                                  <a class="carousel-control-next" href="#carousel{{ $veiculo->id }}" data-slide="next">
                                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
                                  </a>
                                @endif
                              </div>
                            </div>
                            <div class="col-md-5">
                              <ul class="list-group list-group-flush text-veiculo-info">
                                <li class="list-group-item"><i class="fas fa-id-card mr-2 text-primary"></i><strong>Placa:</strong> {{ $veiculo->placa }}</li>
                                <li class="list-group-item"><i class="fas fa-calendar-alt mr-2 text-primary"></i><strong>Ano:</strong> {{ $veiculo->ano_fabricacao }}</li>
                                <li class="list-group-item"><i class="fas fa-palette mr-2 text-primary"></i><strong>Cor:</strong> {{ $veiculo->cor }}</li>
                                <li class="list-group-item"><i class="fas fa-gas-pump mr-2 text-primary"></i><strong>Combustível:</strong> {{ $veiculo->tipo_combustivel }}</li>
                                <li class="list-group-item"><i class="fas fa-flag mr-2 text-primary"></i><strong>Origem:</strong> {{ $veiculo->origem == 0 ? 'Nacional' : 'Importado' }}</li>
                                <li class="list-group-item"><i class="fas fa-info-circle mr-2 text-primary"></i><strong>Observações:</strong> {{ $veiculo->observacoes }}</li>
                              </ul>
                            </div>
                          </div>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/catalogo-veiculos.css') }}">
    
    
@stop

@section('js')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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

