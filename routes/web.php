<?php

            use Illuminate\Support\Facades\Route;
            use App\Http\Controllers\HomeController;
            use App\Http\Controllers\ClienteController;
            use App\Http\Controllers\VeiculoController;
            use App\Http\Controllers\CatalogoController;
            use App\Http\Controllers\LocacaoController;
            
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

});


            
           
