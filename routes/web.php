<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;


Route::post('/login', [LoginController::class, 'loginUser'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () { return view('dashboard.dash');});
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('/permissions/add', [PermissionController::class, 'addPermission'])->name('permissions.add');




