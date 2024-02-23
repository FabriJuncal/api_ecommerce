<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
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
// Se definen las rutas que no estarán protegidas por Sanctum, ya que no son requeridas.
// En esta instancia recien se obtendrá el API TOKEN para poder acceder a las rutas protegidas por Sanctum.
Route::post('auth/register',[AuthController::class, 'create']);
Route::post('auth/login',[AuthController::class, 'loginAdmin']);
Route::post('auth/login-ecommerce',[AuthController::class, 'loginEcommerce']);
Route::post('auth/forgot-password',[AuthController::class, 'sendResetLink']);

Route::middleware(['auth:sanctum'])->group(function(){
    // Endpoint que se encarga de obtener los datos del usuario logeado
    Route::get('auth/me', [AuthController::class, 'me']);

    /* ENDPOINTS PARA ROLES */
    Route::post('rol/create',[RolesController::class, 'store']);
    Route::get('rol/all',[RolesController::class, 'index']);
    Route::post('rol/update/{id}',[RolesController::class, 'update']);
    Route::delete('rol/delete/{id}',[RolesController::class, 'destroy']);

    /* ENDPOINTS PARA USUARIO ADMINISTRADOR */
    Route::post('admin/register',[UserController::class, 'store']);
    Route::get('admin/all',[UserController::class, 'index']);
    Route::put('admin/update/{id}',[UserController::class, 'update']);
    Route::delete('admin/delete/{id}',[UserController::class, 'destroy']);

    /* ENDPOINTS PARA CATEGORIAS */
    Route::get('products/categories/all',[CategoriesController::class, 'index']);
    Route::post('products/categories/add',[CategoriesController::class, 'store']);
    Route::post('products/categories/update/{id}',[CategoriesController::class, 'update']);
    Route::delete('products/categories/delete/{id}',[CategoriesController::class, 'destroy']);



    /* ENDPOINTS PARA VARIACIONES DEL PRODUCTO */
    Route::get('products/variations/all',[CategoriesController::class, 'index']);
    Route::post('products/variations/add',[CategoriesController::class, 'store']);
    Route::post('products/variations/update/{id}',[CategoriesController::class, 'update']);
    Route::delete('products/variations/delete/{id}',[CategoriesController::class, 'destroy']);


    // Endpoint que se encarga de subir las imagenes al servidor
    Route::post('/upload-image', [ImagenController::class, 'store']);
    // Endpoint que se encarga de eliminar las imagenes del servidor
    Route::post('/delete-image', [ImagenController::class, 'destroy']);
});
