<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\SalesController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermissionsController;
use App\Http\Livewire\AssignController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('categories', CategoriesController::class);
Route::get('products', ProductsController::class);
Route::get('coins', CoinsController::class);
Route::get('sales', SalesController::class);
Route::get('roles', RolesController::class);
Route::get('permissions', PermissionsController::class);
Route::get('assing', AssignController::class);
