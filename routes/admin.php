<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Admin\Roles\RolesController;


Route::get('/dashboard',[DashboardController::class,'index'])->middleware('can:admin.dashboard')->name('admin.dashboard');
Route::resource('/states', StatesController::class)->names('admin.states');
Route::resource('/roles', RolesController::class)->names('admin.roles');
