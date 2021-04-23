<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    Auth\LoginController,
    OrcamentoController,
    ConfigController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/orcamentos');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/do', [LoginController::class, 'login'])->name('login.do');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/orcamentos', [OrcamentoController::class, 'index'])->name('orcamentos');
    Route::post('/orcamentos/ajax/save', [OrcamentoController::class, 'save']);
    Route::post('/orcamentos/ajax/list', [OrcamentoController::class, 'filter']);
    Route::post('/orcamentos/ajax/get/{orcamento}', [OrcamentoController::class, 'get']);
    Route::post('/orcamentos/ajax/update/{orcamento}', [OrcamentoController::class, 'update']);
    Route::post('/orcamentos/ajax/delete/{orcamento}', [OrcamentoController::class, 'delete']);
    Route::post('/orcamentos/ajax/delete-item/{item}', [OrcamentoController::class, 'deleteItem']);

    Route::get('/orcamentos/restorage', [OrcamentoController::class, 'restorage']);
    
    Route::get('/config', [ConfigController::class, 'index'])->name('config');
    Route::post('/user/change-pass', [ConfigController::class, 'changePass']);
    Route::post('/user/change-login', [ConfigController::class, 'changeLogin']);

});


