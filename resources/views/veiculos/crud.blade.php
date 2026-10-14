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
                    <form method="post" action="{{ route('veiculo.update', ['veiculo' => $edit->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                @else
                    <form method="post" action="{{ route('veiculo.store') }}" enctype="multipart/form-data">
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
                            <label for="valor_diaria">Valor da Diária (R$)</label>
                            <input type="text" class="form-control" id="valor_diaria" name="valor_diaria"
                                value="{{ $edit->valor_diaria ?? old('valor_diaria') }}">
                            @if ($errors->has('valor_diaria'))
                                <span style="color: red;">{{ $errors->first('valor_diaria') }}</span>
                            @endif
                        </div>
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

                <div class="form-group">
                    <label for="fotos">Fotos do veículo</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fotos" name="fotos[]" multiple accept="image/*">
                        <label class="custom-file-label" for="fotos">Escolha as fotos</label>
                    </div>
                    <small class="form-text text-muted">Você pode selecionar várias imagens.</small>
                </div>
                    <div class="mb-3" id="fotos-wrapper" style="{{ (isset($edit->id) && $edit->fotos->count()) ? '' : 'display:none;' }}">
                <label>Fotos do veículo:</label>
                <div class="d-flex flex-wrap" id="fotos-container">
                    @if(isset($edit->id))
                        @foreach($edit->fotos as $foto)
                            <div class="position-relative mr-2 mb-2 foto-item {{ $foto->capa ? 'foto-capa' : '' }}"
                                data-id="{{ $foto->id }}"
                                style="border: 3px solid {{ $foto->capa ? '#007bff' : 'transparent' }}; border-radius: 6px; cursor:pointer;">
                                <img src="{{ asset('storage/' . $foto->caminho) }}" alt="Foto" width="100" style="object-fit:cover;">
                                <button type="button" class="btn btn-danger btn-sm btn-foto-delete" style="position:absolute;top:2px;right:2px;padding:0 6px;line-height:1;">&times;</button>
                                @if($foto->capa)
                                    <span class="badge badge-primary" style="position:absolute;bottom:2px;left:2px;">Capa</span>
                                @endif
                            </div>
                        @endforeach
                    @endif
             </div>
    <small class="form-text text-muted">Clique em uma foto para definir como capa do catálogo.</small>
</div>
                        <small class="form-text text-muted">Clique em uma foto para definir como capa do catálogo.</small>
                    </div>
            

        </div> <!-- fecha form-group -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="{{ route('veiculo.index') }}" class="btn btn-secondary">Voltar</a>
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

        // ===== Máscaras dos campos =====
        $('#renavam').mask('00000000000');
        $('#ano_fabricacao').mask('0000');
        $('#valor_diaria').mask('#.##0,00', { reverse: true });
        
        $('#chassi').on('input', function() {
            let valor = $(this).val().toUpperCase();
            valor = valor.replace(/[^A-HJ-NPR-Z0-9]/g, '');
            let unico = '';
            for (let i = 0; i < valor.length; i++) {
                if (!unico.includes(valor[i])) {
                    unico += valor[i];
                }
            }
            unico = unico.substr(0, 17);
            $(this).val(unico);
        });

        $('#placa').on('input', function() {
            let valor = $(this).val().toUpperCase();
            valor = valor.replace(/[^A-Z0-9]/g, '');
            $(this).val(valor.substr(0, 7));
        });

        // ===== Fotos: seleção e preview =====
        var fotosAcumuladas = [];

        document.getElementById('fotos').addEventListener('change', function () {
            fotosAcumuladas = fotosAcumuladas.concat(Array.from(this.files));

            var dataTransfer = new DataTransfer();
            fotosAcumuladas.forEach(function (file) {
                dataTransfer.items.add(file);
            });
            this.files = dataTransfer.files;

            atualizarLabelEPreview(fotosAcumuladas);
        });

        function atualizarLabelEPreview(files) {
            var label = document.querySelector('.custom-file-label');
            label.innerText = files.length > 0
                ? files.map(function (f) { return f.name; }).join(', ')
                : 'Escolha as fotos';

            var container = document.getElementById('fotos-container');
            var wrapper = document.getElementById('fotos-wrapper');

            container.querySelectorAll('.foto-novo').forEach(function (el) { el.remove(); });

            files.forEach(function (file, index) {
                var reader = new FileReader();
                reader.onload = function (ev) {
                    var item = document.createElement('div');
                    item.className = 'position-relative mr-2 mb-2 foto-item foto-novo';
                    item.dataset.index = index;
                    item.style.border = '3px solid transparent';
                    item.style.borderRadius = '6px';

                    var img = document.createElement('img');
                    img.src = ev.target.result;
                    img.width = 100;
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '6px';
                    img.alt = file.name;

                    var btnRemover = document.createElement('button');
                    btnRemover.type = 'button';
                    btnRemover.className = 'btn btn-danger btn-sm btn-foto-delete';
                    btnRemover.innerHTML = '&times;';
                    btnRemover.style.cssText = 'position:absolute; top:2px; right:2px; padding:0 6px; line-height:1;';

                    item.appendChild(img);
                    item.appendChild(btnRemover);
                    container.appendChild(item);
                };
                reader.readAsDataURL(file);
            });

            wrapper.style.display = container.children.length > 0 ? 'block' : 'none';
        }

        function removerFotoDaSelecao(index) {
            fotosAcumuladas.splice(index, 1);

            var dataTransfer = new DataTransfer();
            fotosAcumuladas.forEach(function (file) {
                dataTransfer.items.add(file);
            });
            document.getElementById('fotos').files = dataTransfer.files;

            atualizarLabelEPreview(fotosAcumuladas);
        }

        // ===== Fotos: apagar (nova ou já salva) =====
        $(document).on('click', '.btn-foto-delete', function() {
            var $item = $(this).closest('.foto-item');

            if ($item.hasClass('foto-novo')) {
                removerFotoDaSelecao(parseInt($item.data('index'), 10));
                return;
            }

            if(!confirm('Deseja realmente apagar esta foto?')) return;
            var fotoId = $item.data('id');
            $.ajax({
                url: '/fotos/' + fotoId,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success) {
                        $item.remove();
                    }
                }
            });
        });

        // ===== Fotos: definir capa (apenas já salvas) =====
        $(document).on('click', '.foto-item img', function() {
            var $item = $(this).closest('.foto-item');

            if ($item.hasClass('foto-novo')) return;

            var fotoId = $item.data('id');
            $.ajax({
                url: '/fotos/' + fotoId + '/capa',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success) {
                        $('.foto-item').css('border', '3px solid transparent').removeClass('foto-capa');
                        $item.css('border', '3px solid #007bff').addClass('foto-capa');
                        $('.foto-item .badge-primary').remove();
                        $item.append('<span class="badge badge-primary" style="position:absolute;bottom:2px;left:2px;">Capa</span>');
                    }
                }
            });
        });

    });
    </script>
@stop