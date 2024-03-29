<?php

// use App\Http\Controllers\API\AuthController as APIAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IteneraireController;

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
Route::get('msg', function() {
    return 'msg fgkyub nvthijvd hfriobf ';
});


Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class,'logout']);

Route::post('itineraire', [IteneraireController::class, 'store']);
Route::get('itinerairee', [IteneraireController::class, 'index']);
Route::get('itineraires', [IteneraireController::class, 'indexAll']);

Route::get('itineraires/search', [IteneraireController::class, 'searchByTitre']);
Route::get('itineraires/filter', [IteneraireController::class, 'filter']);


Route::middleware('auth:api')->delete('itineraires/delete/{id}', [IteneraireController::class, 'destroy']);
Route::middleware('auth:api')->put('itineraires/update/{id}', [IteneraireController::class, 'update']);