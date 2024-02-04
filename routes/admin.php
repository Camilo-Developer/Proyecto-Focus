<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\SetResidencials\SetresidencialsController;
use App\Http\Controllers\Admin\Agglomerations\AgglomerationsController;
use App\Http\Controllers\Admin\Contractors\ContractorsController;
use App\Http\Controllers\Admin\ContractorEmployees\ContractorEmployeesController;
use App\Livewire\Admin\ContractorEmployees\ContractorEmployeesFilter;

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('can:admin.dashboard')->name('admin.dashboard');
Route::resource('/states', StatesController::class)->names('admin.states');
Route::resource('/roles', RolesController::class)->names('admin.roles');
Route::resource('/setresidencials', SetresidencialsController::class)->names('admin.setresidencials');
Route::resource('/agglomerations', AgglomerationsController::class)->names('admin.agglomerations');
Route::resource('/contractors', ContractorsController::class)->names('admin.contractors');
Route::resource('/contractoremployees', ContractorEmployeesController::class)->names('admin.contractoremployees');
Route::get('/contractoremployees/contractor-employees-filter', ContractorEmployeesFilter::class)->name('admin.contractor-employees.contractor-employees-filter');
