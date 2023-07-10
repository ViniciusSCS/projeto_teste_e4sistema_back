<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PessoaController,
    UsuarioController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/cadastrar', [UsuarioController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/cadastrar', [UsuarioController::class, 'create']);
        Route::post('/logout', [UsuarioController::class, 'logout']);
        Route::delete('/delete/{id}', [UsuarioController::class, 'delete']);
        Route::get('/listar', [UsuarioController::class, 'list']);
        Route::get('/editar/{id}', [UsuarioController::class, 'edit']);
        Route::get('/visualizar/{id}', [UsuarioController::class, 'edit']);
        Route::put('/atualizar/{id}', [UsuarioController::class, 'update']);
    });

    Route::prefix('pessoa')->group(function () {
        Route::post('/cadastrar', [PessoaController::class, 'create']);
        Route::get('/listar', [PessoaController::class, 'list']);
        Route::get('/editar/{id}', [PessoaController::class, 'edit']);
        Route::get('/visualizar/{id}', [PessoaController::class, 'edit']);
        Route::put('/atualizar/{id}', [PessoaController::class, 'update']);
        Route::delete('/delete/{id}', [PessoaController::class, 'delete']);
    });
});
