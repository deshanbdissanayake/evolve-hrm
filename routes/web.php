<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndustryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BranchController;

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



    // industry
Route::get('/industries', [IndustryController::class, 'index'])->name('industries.index');
Route::post('/industries/create', [IndustryController::class, 'create'])->name('industries.create');
Route::put('/industries/update/{id}', [IndustryController::class, 'update'])->name('industries.update');
Route::get('/industries/edit', [IndustryController::class, 'edit'])->name('industries.edit');
Route::delete('/industries/delete/{id}', [IndustryController::class, 'delete'])->name('industries.delete');
Route::get('/industries/{id}', [IndustryController::class, 'show'])->name('industries.show');

 // company
 Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
 Route::post('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
 Route::put('/companies/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
 Route::get('/companies/edit', [CompanyController::class, 'edit'])->name('companies.edit');
 Route::delete('/companies/delete/{id}', [CompanyController::class, 'delete'])->name('companies.delete');
 Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');

 // country
 Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
 Route::post('/countries/create', [CountryController::class, 'create'])->name('countries.create');
 Route::put('/countries/update/{id}', [CountryController::class, 'update'])->name('countries.update');
 Route::get('/countries/edit', [CountryController::class, 'edit'])->name('countries.edit');
 Route::delete('/countries/delete/{id}', [CountryController::class, 'delete'])->name('countries.delete');
 Route::get('/countries/{id}', [CountryController::class, 'show'])->name('countries.show');

 // country
 Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
 Route::post('/currencies/create', [CurrencyController::class, 'create'])->name('currencies.create');
 Route::put('/currencies/update/{id}', [CurrencyController::class, 'update'])->name('currencies.update');
 Route::get('/currencies/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
 Route::delete('/currencies/delete/{id}', [CurrencyController::class, 'delete'])->name('currencies.delete');
 Route::get('/currencies/{id}', [CurrencyController::class, 'show'])->name('currencies.show');

 // provinces
 Route::get('/provinces', [ProvinceController::class, 'index'])->name('provinces.index');
 Route::post('/provinces/create', [ProvinceController::class, 'create'])->name('provinces.create');
 Route::put('/provinces/update/{id}', [ProvinceController::class, 'update'])->name('provinces.update');
 Route::get('/provinces/edit', [ProvinceController::class, 'edit'])->name('provinces.edit');
 Route::delete('/provinces/delete/{id}', [ProvinceController::class, 'delete'])->name('provinces.delete');
 Route::get('/provinces/{id}', [ProvinceController::class, 'show'])->name('provinces.show');

 // city
 Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
 Route::post('/cities/create', [CityController::class, 'create'])->name('cities.create');
 Route::put('/cities/update/{id}', [CityController::class, 'update'])->name('cities.update');
 Route::get('/cities/edit', [CityController::class, 'edit'])->name('cities.edit');
 Route::delete('/cities/delete/{id}', [CityController::class, 'delete'])->name('cities.delete');
 Route::get('/cities/{id}', [CityController::class, 'show'])->name('cities.show');
 


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

    Route::get('/currencies', function () {
        return view('company/currencies/currencies_add');
    })->name('currencies.index');


});



require __DIR__.'/auth.php';
