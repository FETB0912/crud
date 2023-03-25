<?php

use Illuminate\Support\Facades\Route;
//acceder al controlador
use App\Http\Controllers\EmpleadoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//CRUD
//Route::get('/empleado', function () {
    //return view('empleado.index');
//});

//vista --- controlador ----clase --metodo ----acceder
//Route::get('/empleado/create',[EmpleadoController::class,'create']);

//Acceder a todas las URLS trabajando con todos los metodos
Route::resource('empleado', EmpleadoController::class)->middleware('auth');
Auth::routes(['register'=>false,'reset'=>false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [EmpleadoController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () {
    //redirecciona al home controller al hacer middel
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');

});
