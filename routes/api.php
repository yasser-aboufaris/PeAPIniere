<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanteController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReservationController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 
////////////////////////////////////////////////////
Route::post('/plantes',[PlanteController::class, 'store']);
Route::get('/plantes',[PlanteController::class, 'index']);
Route::put('/plantes/{id}',[PlanteController::class, 'update']);
Route::delete('/plantes/{id}',[PlanteController::class, 'destroy']);
Route::get('plantes/{slug}', [PlanteController::class, 'showBySlug']);


////////////////////////////////////////////////////
Route::post('/categotries',[CategoryController::class, 'store']);
Route::get('/categotries',[CategoryController::class, 'index']);
Route::delete('/categotries/{id}',[CategoryController::class, 'destroy']);
Route::put('/categotries/{id}',[CategoryController::class, 'update']);

/////////////////////////////////////////////
Route::post('/plantes/reservations' , [ReservationController::class,'store']);
Route::post('plante/reservations');
Route::get('plante/reservations/{id}', [ReservationController::class,'getPlantReservations']);
Route::put('/reservations/done/{id}',[ReservationController::class, 'markAsDone']);

///////////////////////////////////////////////
// Route::get('/user/reservations/{id}');


