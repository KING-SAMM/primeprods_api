<?php
// header('Access-Control-Allow-Origin: http://localhost:3000');

use App\Http\Controllers\Api\PrototypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/prototypes', [PrototypeController::class, 'index'])
                ->middleware('guest');

Route::get('/gallery', [PrototypeController::class, 'gallery'])
                ->middleware('guest');

Route::get('/prototypes/{prototype}', [PrototypeController::class, 'show'])
                ->middleware('guest');
