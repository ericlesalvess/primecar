@extends('adminlte::page')

@section('title', 'Controle de Locação')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Controle de Locação</h3>
        </div>
        <div class="card-body">
            <div class="form-group">



                @if (isset($edit->id))
                    <form method="post" action="{{ route('locacao.update', ['locacao' => $edit->id]) }}">
                        @csrf
                        @method('PUT')
                    @else
                        <form method="post" action="{{ route('locacao.store') }}">
                            @csrf
                @endif


                <div class="row">
                    <div class="col-sm-6">
                        <label for="cliente_id">Cliente</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" {{ @$edit->id ? 'readonly' : '' }}>
                            <option value="">Selecione</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ @$edit->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('cliente'))
                            <span style="color: red;">
                                {{ $errors->first('cliente') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label for="veiculo_id">Veículo</label>
                        <select class="form-control" id="veiculo_id" name="veiculo_id" {{ @$edit->id ? 'readonly' : '' }}>
                            <option value="">Selecione</option>

                            @foreach ($veiculos as $veiculo)
                                <option value="{{ $veiculo['id'] }}"
                                    {{ @$edit->veiculo_id == $veiculo['id'] ? 'selected' : '' }}>
                                    {{ $veiculo['modelo'] . ' | Cor: ' . $veiculo['cor'] . ' | Placa: ' . $veiculo['placa'] }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('veiculo_id'))
                            <span style="color: red;">
                                {{ $errors->first('veiculo_id') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="dias_locacao">Dias Locacão</label>
                        <input type="text" class="form-control" id="dias_locacao" name="dias_locacao" placeholder="" {{ @$edit->id ? 'readonly' : '' }}
                            value="{{ $edit->dias_locacao ?? old('dias_locacao') }}">
                        @if ($errors->has('dias_locacao'))
                            <span style="color: red;">
                                {{ $errors->first('dias_locacao') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="data_prevista_devolucao">Prev. Devolução</label>
                        <input type="text" class="form-control" id="data_prevista_devolucao" readonly
                            name="data_prevista_devolucao" placeholder=""
                            value="{{ $edit->data_prevista_devolucao ?? old('data_prevista_devolucao') }}">
                        @if ($errors->has('data_prevista_devolucao'))
                            <span style="color: red;">
                                {{ $errors->first('data_prevista_devolucao') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="data_devolucao">Data da Devolução</label>
                        <input type="date" class="form-control" id="data_devolucao" name="data_devolucao" placeholder=""
                            value="{{ $edit->data_devolucao ?? old('data_devolucao') }}">
                        @if ($errors->has('data_devolucao'))
                            <span style="color: red;">
                                {{ $errors->first('data_devolucao') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="{{ route('locacao.index') }}" type="button" class="btn btn-secondary">Voltar</a>
                </div>
                </form>

            </div>
        @stop

        @section('css')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @stop

        @section('js')
            <script src="{{ asset('vendor/jquery/jquery.maskedinput.min.js') }}"></script>
            <script src="{{ asset('vendor/jquery/jquery.maskMoney.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
                $(document).ready(function() {

                    // Função para somar dias úteis
                    function adicionarDiasUteis(data, dias) {
                        let contador = 0;
                        while (contador < dias) {
                            data.setDate(data.getDate() + 1);
                            // 0 = domingo, 6 = sábado
                            const diaSemana = data.getDay();
                            if (diaSemana !== 0 && diaSemana !== 6) {
                                contador++;
                            }
                        }
                        return data;
                    }

                    $('#dias_locacao').on('input', function() {
                        let dias = parseInt($(this).val());
                        if (isNaN(dias) || dias <= 0) {
                            $('#data_prevista_devolucao').val('');
                            return;
                        }

                        let dataAtual = new Date();
                        let dataFinal = adicionarDiasUteis(new Date(dataAtual), dias);

                        let dia = String(dataFinal.getDate()).padStart(2, '0');
                        let mes = String(dataFinal.getMonth() + 1).padStart(2, '0');
                        let ano = dataFinal.getFullYear();

                        $('#data_prevista_devolucao').val(`${dia}/${mes}/${ano}`);
                    });



                });
            </script>
        @stop
