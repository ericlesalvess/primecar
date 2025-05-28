@extends('adminlte::page')

@section('title', 'Cadastro de Veículos')

@section('content_header')
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Cadastro de Veículos</h3>
        </div>
        <div class="card-body">
            <div class="form-group">

                @if (isset($edit->id))
                    <form method="post" action="{{ route('veiculo.update', ['veiculo' => $edit->id]) }}">
                        @csrf
                        @method('PUT')
                @else
                    <form method="post" action="{{ route('veiculo.store') }}">
                        @csrf
                @endif

                <div class="row">
                    <div class="col-sm-10">
                        <label for="modelo">Veículo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo"
                            value="{{ $edit->modelo ?? old('modelo') }}">
                        @if ($errors->has('modelo'))
                            <span style="color: red;">{{ $errors->first('modelo') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-2">
                        <label for="marca">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca"
                            value="{{ $edit->marca ?? old('marca') }}">
                        @if ($errors->has('marca'))
                            <span style="color: red;">{{ $errors->first('marca') }}</span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="placa">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa"
                            value="{{ $edit->placa ?? old('placa') }}">
                        @if ($errors->has('placa'))
                            <span style="color: red;">{{ $errors->first('placa') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="renavam">Renavam</label>
                        <input type="number" class="form-control" id="renavam" name="renavam"
                            value="{{ $edit->renavam ?? old('renavam') }}">
                        @if ($errors->has('renavam'))
                            <span style="color: red;">{{ $errors->first('renavam') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="chassi">Chassi</label>
                        <input type="text" class="form-control" id="chassi" name="chassi"
                            value="{{ $edit->chassi ?? old('chassi') }}">
                        @if ($errors->has('chassi'))
                            <span style="color: red;">{{ $errors->first('chassi') }}</span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="ano_fabricacao">Ano de Fabricação</label>
                        <input type="number" class="form-control" id="ano_fabricacao" name="ano_fabricacao"
                            value="{{ $edit->ano_fabricacao ?? old('ano_fabricacao') }}">
                        @if ($errors->has('ano_fabricacao'))
                            <span style="color: red;">{{ $errors->first('ano_fabricacao') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="cor">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor"
                            value="{{ $edit->cor ?? old('cor') }}">
                        @if ($errors->has('cor'))
                            <span style="color: red;">{{ $errors->first('cor') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="tipo_combustivel">Combustível</label>
                        <select class="form-control" id="tipo_combustivel" name="tipo_combustivel">
                            <option value="">Selecione</option>
                            <option value="Gasolina" {{ (isset($edit->tipo_combustivel) && $edit->tipo_combustivel == 'Gasolina') ? 'selected' : '' }}>Gasolina</option>
                            <option value="Álcool" {{ (isset($edit->tipo_combustivel) && $edit->tipo_combustivel == 'Álcool') ? 'selected' : '' }}>Álcool</option>
                            <option value="Diesel" {{ (isset($edit->tipo_combustivel) && $edit->tipo_combustivel == 'Diesel') ? 'selected' : '' }}>Diesel</option>
                            <option value="Gás" {{ (isset($edit->tipo_combustivel) && $edit->tipo_combustivel == 'Gás') ? 'selected' : '' }}>Gás</option>
                            <option value="Flex" {{ (isset($edit->tipo_combustivel) && $edit->tipo_combustivel == 'Flex') ? 'selected' : '' }}>Flex</option>
                        </select>
                        @if ($errors->has('tipo_combustivel'))
                            <span style="color: red;">{{ $errors->first('tipo_combustivel') }}</span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="observacoes">Observações</label>
                        <input type="text" class="form-control" id="observacoes" name="observacoes"
                            value="{{ $edit->observacoes ?? old('observacoes') }}">
                        @if ($errors->has('observacoes'))
                            <span style="color: red;">{{ $errors->first('observacoes') }}</span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="origem">Origem</label>
                        <select class="form-control" name="origem" id="origem">
                            <option value="0" {{ @$edit->origem == 0 ? 'selected' : '' }}>Nacional
                            </option>
                            <option value="1" {{ @$edit->origem == 1 ? 'selected' : '' }}>Importado
                            </option>
                        </select>
                        @if ($errors->has('origem'))
                            <span style="color: red;">
                                {{ $errors->first('origem') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

        </div> <!-- fecha form-group -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary">Voltar</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Máscara para Renevam
            $('#renavam').mask('00000000000');

            //Máscara Ano Fabricação
            $('#ano_fabricacao').mask('0000');

            // Máscara para Chassi
           // $('#chassi').mask('00000000000000000');

           $('#chassi').on('input', function() {
                let valor = $(this).val().toUpperCase();
                // Remove caracteres que não sejam letras/números válidos (exclui I, O e Q)
                 valor = valor.replace(/[^A-HJ-NPR-Z0-9]/g, '');

                // Remove caracteres repetidos
                 let unico = '';
                for (let i = 0; i < valor.length; i++) {
                     if (!unico.includes(valor[i])) {
                             unico += valor[i];
                          }
                }
                // Limita a 17 caracteres
                unico = unico.substr(0, 17);
                 $(this).val(unico);
            }); 


            // Máscara para Placa
            $('#placa').on('input', function() {
                let valor = $(this).val().toUpperCase();
                // Remove caracteres não alfanuméricos
                valor = valor.replace(/[^A-Z0-9]/g, '');
                // Limita a 7 caracteres
                $(this).val(valor.substr(0, 7));
                
            });
           
            });
    </script>
@stop
