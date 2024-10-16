<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndustryController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:super-admin|admin']], function() {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);



    // Display all students
Route::get('/industries', [IndustryController::class, 'index'])->name('industries.index');
Route::post('/industries/create', [IndustryController::class, 'create'])->name('industries.create');
Route::put('/industries/update/{id}', [IndustryController::class, 'update'])->name('industries.update');
Route::get('/industries/edit', [IndustryController::class, 'edit'])->name('industries.edit');
Route::delete('/industries/delete/{id}', [IndustryController::class, 'delete'])->name('industries.delete');
Route::get('/industries/{id}', [IndustryController::class, 'show'])->name('industries.show');

 // Display all students
 Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
 Route::post('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
 Route::put('/companies/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
 Route::get('/companies/edit', [CompanyController::class, 'edit'])->name('companies.edit');
 Route::delete('/companies/delete/{id}', [CompanyController::class, 'delete'])->name('companies.delete');
 Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');


});

//views only - Desh(2024-10-16)
Route::group(['middleware' => ['role:super-admin|admin']], function() {
    Route::get('/company', function () {
        return view('company/company_info');
    })->name('company.index');


    Route::get('/location', function () {
        return view('location/index');
    })->name('location.index');


    Route::get('/branch', function () {
        return view('company/branch/index');
    })->name('branch.index');
    Route::get('/department', function () {
        return view('company/department/index');
    })->name('department.index');
    Route::get('/division', function () {
        return view('company/division/index');
    })->name('division.index');
    Route::get('/station', function () {
        return view('company/station/index');
    })->name('station.index');

});



require __DIR__.'/auth.php';
