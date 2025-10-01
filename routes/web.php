<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

      // Formulario para editar roles/permiso de un usuario
    Route::get('users/{user}/roles-permissions', [UserController::class, 'editRoles'])
        ->name('users.roles.edit');

    // Guardar cambios
    Route::put('users/{user}/roles-permissions', [UserController::class, 'updateRoles'])
        ->name('users.roles.update');
    
    Route::get('bitacora', [UserController::class, 'bitacora'])->name('bitacora.index');


    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


    Route::resource('books', BookController::class)->only('index');
});
