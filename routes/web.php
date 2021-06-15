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
    Route::prefix('customers')->group(function () {
        Route::get('/', [App\Http\Controllers\CustomersController::class, 'index'])    
                ->name('customers');
        Route::any('/create', [App\Http\Controllers\CustomersController::class, 'create'])    
                ->name('customers');
        Route::any('/update/{id}', [App\Http\Controllers\CustomersController::class, 'update'])    
                ->name('customers');
        Route::get('/delete/{id}', [App\Http\Controllers\CustomersController::class, 'destroy'])    
                ->name('customers');
        Route::get('/json', [App\Http\Controllers\CustomersController::class, 'getCustomers'])
                ->name('customers.json');
    });

    //service-types
    Route::prefix('service-types')->group(function () {
        Route::get('/', [App\Http\Controllers\ServiceController::class, 'indexType'])    
                ->name('service.types');
        Route::any('/create', [App\Http\Controllers\ServiceController::class, 'createType'])    
                ->name('service.types');
        Route::any('/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateType'])    
                ->name('service.types');
        Route::get('/delete/{id}', [App\Http\Controllers\ServiceController::class, 'destroyType'])    
                ->name('service.types');
        Route::get('/json', [App\Http\Controllers\ServiceController::class, 'getServiceTypes'])
                ->name('service.types.json');
    });

    //service
    Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])
            ->name('services');
    Route::get('/services-json', [App\Http\Controllers\ServiceController::class, 'getServices'])
            ->name('service.json');

});


