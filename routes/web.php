<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(array('middleware'=> ['auth']), function() {
    //home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');
    //user
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])
            ->name('user');
    Route::get('/user-json', [App\Http\Controllers\UserController::class, 'getUsers'])
            ->name('user.json');
    //customers
    Route::get('/customers', [App\Http\Controllers\CustomersController::class, 'index'])    
            ->name('customers');
    Route::get('/customers-json', [App\Http\Controllers\CustomersController::class, 'getCustomers'])
            ->name('customers.json');
    //service-types
    Route::get('/service-types', [App\Http\Controllers\ServiceController::class, 'indexType'])
            ->name('service.types');
    Route::get('/service-types-json', [App\Http\Controllers\ServiceController::class, 'getServiceTypes'])
            ->name('service.types.json');
    //service
    Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])
            ->name('services');
    Route::get('/services-json', [App\Http\Controllers\ServiceController::class, 'getServices'])
            ->name('service.json');

});


