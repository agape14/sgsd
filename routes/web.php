<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TbDirectorioCabController;
use App\Http\Controllers\TbDirectorioDetController;
use App\Http\Controllers\TbDirectorioDetRespController;
use App\Http\Controllers\TbDirectorioDetRespDetController;
use App\Http\Controllers\SgdController;
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
    return view('auth/login');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::group(['prefix' => 'components', 'as' => 'components.'], function() {
        Route::get('/alert', function () {
            return view('admin.component.alert');
        })->name('alert');
        Route::get('/accordion', function () {
            return view('admin.component.accordion');
        })->name('accordion');
    });
    Route::get('/sesiondirectorio', function () {
        return view('admin.sesiondirectorio.sesiondirectorio');
    })->name('sesiondirectorio');


    //Route::get('/tbdirectoriocab', [TbDirectorioCabController::class, 'index']);
    Route::resource('tbdirectoriocab',TbDirectorioCabController::class);
    Route::get('tbldirectorio', [TbDirectorioCabController::class, 'index'])->name('tbdirectoriocab.index');
    Route::get('inicio', [TbDirectorioCabController::class, 'inicio'])->name('tbdirectoriocab.inicio');

    Route::get('tbdirectorio_show/{id}', [TbDirectorioCabController::class, 'show'])->name('tbdirectoriocab_show');
    Route::put('/tbdirectoriocab_update/{id}', [TbDirectorioCabController::class, 'update'])->name('tbdirectoriocab_update');
    Route::get('/tbdirectoriocab_delete/{id}', [TbDirectorioCabController::class, 'destroy'])->name('tbdirectoriocab_delete');

    Route::get('tbdirectorio_datos', [TbDirectorioCabController::class, 'getData'])->name('tbdirectoriocab_get');
    Route::post('tbdirectorio_registra', [TbDirectorioCabController::class, 'store'])->name('tbdirectorio_registra');

    Route::get('/search', [TbDirectorioCabController::class, 'search'])->name('search');


    Route::get('/temas/{id}/{anio}', [TbDirectorioDetController::class, 'indextemas'])->name('temas');
    Route::get('tbldirectoriodet_gettbltemas', [TbDirectorioDetController::class, 'gettbltemas'])->name('tbldirectoriodet_gettbltemas');
    Route::post('tbdirectoriodet_registra', [TbDirectorioDetController::class, 'store'])->name('tbdirectoriodet_registra');
    Route::get('tbdirectoriodet_show/{codi_sesion}/{periodo}/{numero}', [TbDirectorioDetController::class, 'show'])->name('tbdirectoriodet_show');
    Route::put('/tbdirectoriodet_update/{id}', [TbDirectorioDetController::class, 'update'])->name('tbdirectoriodet_update');
    Route::get('/tbdirectoriodet_delete/{codi_sesion}/{periodo}/{numero}', [TbDirectorioDetController::class, 'destroy'])->name('tbdirectoriodet_delete');

    Route::get('tbdirectoriodet_areas', [TbDirectorioDetRespController::class, 'getAreas'])->name('tbdirectoriodet_areas');
    Route::post('tbdirectorioresp_registra', [TbDirectorioDetRespController::class, 'store'])->name('tbdirectorioresp_registra');
    Route::get('tbdirectorioresp_gettblresp', [TbDirectorioDetRespController::class, 'gettblresponsables'])->name('tbdirectorioresp_gettblresp');
    Route::get('/tbdirectoriodetresp_delete/{codi_sesion}/{periodo}/{nrosecu}/{codarea}/{codsust}', [TbDirectorioDetRespController::class, 'destroy'])->name('tbdirectoriodetresp_delete');

    Route::get('tbdirectorioresp_gettblsustento', [TbDirectorioDetRespDetController::class, 'gettblsustentos'])->name('tbdirectorioresp_gettblsustento');
    Route::post('tbdirectoriorespdets_registra', [TbDirectorioDetRespDetController::class, 'store'])->name('tbdirectoriorespdets_registra');
    Route::get('/tbdirectoriodetrespdet_delete/{codi_sesion}/{periodo}/{nrosecu}/{codarea}/{codsust}', [TbDirectorioDetRespDetController::class, 'destroy'])->name('tbdirectoriodetrespdet_delete');
    Route::post('tbdirectoriorespdets_registrasgd', [TbDirectorioDetRespDetController::class, 'store_sgd'])->name('tbdirectoriorespdets_registrasgd');

    //Route::post('/webservice', 'WebServicesController@ReadWebService');
    Route::get('getdocumentos_for_exp_sgd', [SgdController::class, 'getdocumentoporexp'])->name('getdocumentos_for_exp_sgd');
    Route::get('getanios_sgd', [SgdController::class, 'getAnios'])->name('getanios_sgd');
});