<?php
// header('Access-Control-Allow-Origin: http://localhost:3000');

use App\Http\Controllers\Api\PrototypeController;
use App\Http\Controllers\Auth\UserController;
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

// Get/Show all prototypes 
Route::get('/', [PrototypeController::class, 'index'])
                ->middleware('guest');

// Get/Show all prototypes in a gallery 
Route::get('/gallery', [PrototypeController::class, 'gallery'])
                ->middleware('guest');
                

// Get/Show single prototype 
Route::get('/prototypes/{prototype}', [PrototypeController::class, 'show'])
                ->middleware('guest');

// Store prototype data
Route::post('/prototypes/create', [PrototypeController::class, 'store'])
                // ->middleware('auth')
                ->name('create');   
                

// Get/Show all users                 
Route::get('/users', [UserController::class, 'index'])
                ->middleware('guest')
                ->name('users.user');                

// Get/Show single user g                
Route::get('/users/{user}', [UserController::class, 'show'])
                ->middleware('guest')
                ->name('users.user');

// Register a user                 
// Route::post('/register', [UserController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('register');
             

                