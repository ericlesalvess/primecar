@extends('adminlte::page')

@section('title', isset($edit->id) ? 'Editar Lançamento' : 'Novo Lançamento')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ isset($edit->id) ? 'Editar Lançamento' : 'Novo Lançamento' }}</h3>
        </div>
        <div class="card-body">
            <div class="form-group">

                @if (isset($edit->id))
                    <form method="post" action="{{ route('fluxo-caixa.update', $edit->id) }}">
                        @csrf
                        @method('PUT')
                @else
                    <form method="post" action="{{ route('fluxo-caixa.store') }}">
                        @csrf
                @endif

                <div class="row">
                    <div class="col-sm-4">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo_lancamento" name="tipo">
                            <option value="entrada" {{ (isset($edit->tipo) && $edit->tipo == 'entrada') ? 'selected' : '' }}>Entrada</option>
                            <option value="saida" {{ (isset($edit->tipo) && $edit->tipo == 'saida') ? 'selected' : '' }}>Saída</option>
                        </select>
                        @if ($errors->has('tipo'))
                            <span style="color: red;">{{ $errors->first('tipo') }}</span>
                        @endif
                    </div>

                    <div class="col-sm-4">
                        <label for="categoria_financeira_id">Categoria</label>
                        <select class="form-control categoria-select" id="categoria_entrada" name="categoria_financeira_id"
                            style="{{ (!isset($edit->tipo) || $edit->tipo == 'entrada') ? '' : 'display:none;' }}">
                            <option value="">Selecione</option>
                            @foreach ($categoriasEntrada as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ (isset($edit->categoria_financeira_id) && $edit->categoria_financeira_id == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>

                        <select class="form-control categoria-select" id="categoria_saida" name="categoria_financeira_id"
                            style="{{ (isset($edit->tipo) && $edit->tipo == 'saida') ? '' : 'display:none;' }}">
                            <option value="">Selecione</option>
                            @foreach ($categoriasSaida as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ (isset($edit->categoria_financeira_id) && $edit->categoria_financeira_id == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('categoria_financeira_id'))
                            <span style="color: red;">{{ $errors->first('categoria_financeira_id') }}</span>
                        @endif
                    </div>

                    <div class="col-sm-4">
                        <label for="valor">Valor (R$)</label>
                        <input type="text" class="form-control" id="valor" name="valor"
                            value="{{ $edit->valor ?? old('valor') }}">
                        @if ($errors->has('valor'))
                            <span style="color: red;">{{ $errors->first('valor') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="data">Data</label>
                        <input type="date" class="form-control" id="data" name="data"
                            value="{{ isset($edit->data) ? \Carbon\Carbon::parse($edit->data)->format('Y-m-d') : old('data', date('Y-m-d')) }}">
                        @if ($errors->has('data'))
                            <span style="color: red;">{{ $errors->first('data') }}</span>
                        @endif
                    </div>

                    <div class="col-sm-8">
                        <label for="descricao">Descrição (opcional)</label>
                        <input type="text" class="form-control" id="descricao" name="descricao"
                            value="{{ $edit->descricao ?? old('descricao') }}">
                        @if ($errors->has('descricao'))
                            <span style="color: red;">{{ $errors->first('descricao') }}</span>
                        @endif
                    </div>
                </div>

        </div> <!-- fecha form-group -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="{{ route('fluxo-caixa.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
        </form>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {

            // Máscara de valor monetário: digita só números, formata como 1.234,56
            $('#valor').mask('#.##0,00', { reverse: true });

            // Alterna qual <select> de categoria aparece, conforme o <select> de tipo.
            // Sem isso, o usuário poderia escolher tipo "saida" mas categoria de
            // "entrada" (ou vice-versa), já que os dois selects têm o MESMO name
            // (categoria_financeira_id) — só um deles fica visível e é enviado de fato,
            // porque o outro escondido tem seu value ignorado no submit se usarmos
            // "disabled" nele. Por isso desabilitamos o que está oculto.
            function alternarCategoria() {
                var tipo = $('#tipo_lancamento').val();

                if (tipo === 'entrada') {
                    $('#categoria_entrada').show().prop('disabled', false);
                    $('#categoria_saida').hide().prop('disabled', true);
                } else {
                    $('#categoria_saida').show().prop('disabled', false);
                    $('#categoria_entrada').hide().prop('disabled', true);
                }
            }

            // Roda uma vez ao carregar a página (pra já vir certo se for edição)
            alternarCategoria();

            // E roda de novo toda vez que o usuário mudar o tipo manualmente
            $('#tipo_lancamento').on('change', alternarCategoria);

        });
    </script>
@stop