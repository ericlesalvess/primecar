<?php
            use Illuminate\Support\Facades\Auth;
            use Illuminate\Support\Facades\Route;
            use App\Http\Controllers\HomeController;
            use App\Http\Controllers\ClienteController;
            use App\Http\Controllers\VeiculoController;
            use App\Http\Controllers\CatalogoController;
            use App\Http\Controllers\LocacaoController;
            use App\Http\Controllers\FluxoCaixaController;
            
            Route::get('/', function () {
                return view('auth/login');
            });
            
            // Rotas de autenticação (login, registro etc.)
            Auth::routes();
            
           Route::middleware(['auth'])->group(function () {

                Route::get('/home', [HomeController::class, 'index'])
                    ->name('home');
                    //->middleware('permission:acessar dashboard');

                Route::resource('cliente', ClienteController::class);
                    //->middleware('permission:acessar cliente');

                Route::resource('veiculo', VeiculoController::class);
                    //->middleware('permission:acessar veiculo');

                Route::resource('catalogo', CatalogoController::class);
                    //->middleware('permission:acessar catalogo');

                Route::resource('locacao', LocacaoController::class);
                    //->middleware('permission:acessar locacao');

                Route::get('/fluxo-caixa/relatorios', [FluxoCaixaController::class, 'relatorios'])->name('fluxo-caixa.relatorios');
            
                Route::resource('fluxo-caixa', FluxoCaixaController::class)->except(['show']);
                      //->middleware('permission:acessar Fluxo de Caixa');

                


                Route::get('/veiculos/{id}', [\App\Http\Controllers\VeiculoController::class, 'show'])->name('veiculos.show');
                Route::delete('/fotos/{id}', [\App\Http\Controllers\FotoController::class, 'destroy'])->name('fotos.destroy');
                Route::post('/fotos/{id}/capa', [\App\Http\Controllers\FotoController::class, 'definirCapa']);
                Route::delete('/locacoes/apagar-todas', [\App\Http\Controllers\LocacaoController::class, 'apagarTodas'])->name('locacao.apagarTodas');

            }
    );




