<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', [UserController::class, 'loadAllUser']);

Route::get('/add/user', [UserController::class, 'loadAddUserForm']);
Route::Post('/add/user', [UserController::class, 'AddUser'])->name('AddUser');

Route::get('/delete/{id}', [UserController::class, 'deleteUser']);

Route::get('/edit/{id}', [UserController::class, 'loadEditForm']);
Route::post('/edit/user', [UserController::class, 'EditUser'])->name('EditUser');
