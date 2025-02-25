<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProcessController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [AuthController::class, 'login']);

Route::get('/index', [ProcessController::class, 'index']);
Route::post('/add_patient', [ProcessController::class, 'add_patient']);
Route::post('/make_visit', [ProcessController::class, 'make_visit']);