@extends('adminlte::page')

@section('title', 'Cadastro de Clientes')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Cadastro de Clientes</h3>
        </div>
        <div class="card-body"s>
            <div class="form-group">

                @if (isset($edit->id))
                    <form method="post" action="{{ route('cliente.update', ['cliente' => $edit->id]) }}">
                        @csrf
                        @method('PUT')
                    @else
                        <form method="post" action="{{ route('cliente.store') }}">
                            @csrf
                @endif

                <div class="row">
                    <div class="col-sm-10">
                        <label for="nome">Cliente<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder=""
                            value="{{ $edit->nome ?? old('nome') }}">
                        @if ($errors->has('nome'))
                            <span style="color: red;">
                                {{ $errors->first('nome') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-2">
                        <label for="cpf">CPF<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder=""
                            value="{{ $edit->cpf ?? old('cpf') }}">
                            <div class="invalid-feedback"> CPF inválido!</div>
                        @if ($errors->has('cpf'))
                            <span style="color: red;">
                                {{ $errors->first('cpf') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="cep">CEP<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder=""
                            value="{{ $edit->cep ?? old('cep') }}">
                        <div class="invalid-feedback" id="cep-feedback">CEP inválido!</div>
                        @if ($errors->has('cep'))
                            <span style="color: red;">
                                {{ $errors->first('cep') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder=""
                            value="{{ $edit->logradouro ?? old('logradouro') }}">
                        @if ($errors->has('logradouro'))
                            <span style="color: red;">
                                {{ $errors->first('logradouro') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="numero">Número<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder=""
                            value="{{ $edit->numero ?? old('numero') }}">
                        @if ($errors->has('numero'))
                            <span style="color: red;">
                                {{ $errors->first('numero') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="complemento">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" placeholder=""
                            value="{{ $edit->complemento ?? old('complemento') }}">
                        @if ($errors->has('complemento'))
                            <span style="color: red;">
                                {{ $errors->first('complemento') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder=""
                            value="{{ $edit->bairro ?? old('bairro') }}">
                        @if ($errors->has('bairro'))
                            <span style="color: red;">
                                {{ $errors->first('bairro') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder=""
                            value="{{ $edit->cidade ?? old('cidade') }}">
                        @if ($errors->has('cidade'))
                            <span style="color: red;">
                                {{ $errors->first('cidade') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="uf">UF</label>
                        <input type="text" class="form-control" id="uf" name="uf" placeholder=""
                            value="{{ $edit->uf ?? old('uf') }}">
                        @if ($errors->has('uf'))
                            <span style="color: red;">
                                {{ $errors->first('uf') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="celular">Celular<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="celular" name="celular" placeholder=""
                            value="{{ $edit->celular ?? old('celular') }}">
                            <div class="invalid-feedback"> Celular inválido!</div>
                        @if ($errors->has('celular'))
                            <span style="color: red;">
                                {{ $errors->first('celular') }}
                            </span>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <label for="email">E-mail<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" placeholder=""
                            value="{{ $edit->email ?? old('email') }}">
                        @if ($errors->has('email'))
                            <span style="color: red;">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        <br>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="{{ route('cliente.index') }}" type="button" class="btn btn-secondary">Voltar</a>
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
            // Máscara para CPF
        $('#cpf').mask('000.000.000-00');

      

        // Máscara para celular (formato dinâmico)
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        };
        var spOptions = {
        onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
             }
        };
        $('#celular').mask(SPMaskBehavior, spOptions);
        });

              // Validação de CPF e Celular
        $('#cpf').on('blur', function () {
         const valor = $(this).val();
         const isValid = valor.length === 14 || valor.length === 0; // Permite campo vazio sem erro
        $(this).toggleClass('is-invalid', !isValid);
    });

    $('#celular').on('blur', function () {
        const valor = $(this).val().replace(/\D/g, '');
        const isValid = (valor.length >= 10 && valor.length <= 11) || valor.length === 0; // Permite campo vazio
     $(this).toggleClass('is-invalid', !isValid);
    });

    // Remove a classe de erro ao digitar
    $('#cpf, #celular').on('input', function() {
    $(this).removeClass('is-invalid');
     });

    // Impede envio com erros
    $('#form').on('submit', function(e) {
        const cpf = $('#cpf').val();
        const cel = $('#celular').val().replace(/\D/g, '');
        let hasError = false;

        if (cpf.length !== 14) {
            $('#cpf').addClass('is-invalid');
            hasError = true;
        }

        if (cel.length < 10 || cel.length > 11) {
            $('#celular').addClass('is-invalid');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });

        
         // Máscara para CEP
    $('#cep').mask('00000-000');

// Consulta ViaCEP ao sair do campo
$('#cep').on('blur', function () {
    var cep = $(this).val().replace(/\D/g, '');

    if (cep.length !== 8) {
        $('#cep').addClass('is-invalid'); // Aplica Bootstrap erro visual
        $('#cep-feedback').text('CEP inválido!'); // Exibe mensagem no feedback do campo
        return;
    } else {
        $('#cep').removeClass('is-invalid'); // Remove erro visual quando válido
        $('#cep-feedback').text('');
    }

    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/", function (data) {
        if (!("erro" in data)) {
            $('#cep').removeClass('is-invalid'); // Remove erro visual
            $('#logradouro').val(data.logradouro);
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.localidade);
            $('#uf').val(data.uf);
        } else {
            $('#cep').addClass('is-invalid');
            $('#cep-feedback').text('CEP não encontrado.');
        }
    }).fail(function () {
        $('#cep').addClass('is-invalid');
        $('#cep-feedback').text('Erro ao consultar o CEP.');
    });
});

// Remove erro ao começar a digitar
$('#cep').on('input', function() {
    $(this).removeClass('is-invalid');
    $('#cep-feedback').text('');
});
     
    </script>
@stop
