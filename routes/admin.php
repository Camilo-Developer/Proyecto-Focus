<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\SetResidencials\SetresidencialsController;
use App\Http\Controllers\Admin\Agglomerations\AgglomerationsController;
use App\Http\Controllers\Admin\Contractors\ContractorsController;
use App\Http\Controllers\Admin\ContractorEmployees\ContractorEmployeesController;
use App\Http\Controllers\Admin\Elements\ElementsController;
use App\Http\Controllers\Admin\Goals\GoalsController;
use App\Http\Controllers\Admin\Units\UnitsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Visitors\VisitorsController;

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('can:admin.dashboard')->name('admin.dashboard');
Route::resource('/states', StatesController::class)->names('admin.states');
Route::resource('/roles', RolesController::class)->names('admin.roles');
Route::resource('/setresidencials', SetresidencialsController::class)->names('admin.setresidencials');
Route::resource('/agglomerations', AgglomerationsController::class)->names('admin.agglomerations');
Route::resource('/contractors', ContractorsController::class)->names('admin.contractors');
Route::resource('/contractoremployees', ContractorEmployeesController::class)->names('admin.contractoremployees');
Route::resource('/units', UnitsController::class)->names('admin.units');
Route::resource('/users', UsersController::class)->names('admin.users');
Route::resource('/elements',ElementsController::class)->names('admin.elements');
Route::resource('/goals',GoalsController::class)->names('admin.goals');
Route::resource('/goals',VisitorsController::class)->names('admin.visitors');

