<?php

use App\Http\Controllers\Api\ContatoController;
use App\Http\Controllers\Api\ExportacaoExcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(ExportacaoExcelController::class)->prefix('exportacao')->group(function () {
    Route::get('/excel', 'exportar');
});
Route::controller(ContatoController::class)->prefix('contatos')->group(function () {
    Route::get('/indicadores', 'indicadores');
    Route::get('/', 'listar');
    Route::get('/{codigo}', 'buscar');
    Route::post('/', 'criar');
    Route::put('/{codigo}', 'atualizar');
    Route::delete('/{codigo}', 'apagar');
});


