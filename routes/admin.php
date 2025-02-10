<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\SetResidencials\SetresidencialsController;
use App\Http\Controllers\Admin\Agglomerations\AgglomerationsController;
use App\Http\Controllers\Admin\Companies\CompaniesController;
use App\Http\Controllers\Admin\Elements\ElementsController;
use App\Http\Controllers\Admin\Goals\GoalsController;
use App\Http\Controllers\Admin\Units\UnitsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Visitors\VisitorsController;
use App\Http\Controllers\Admin\EmployeeIncomes\EmployeeincomesController;
use App\Http\Controllers\Admin\TypeUsers\TypeUsersController;
use App\Http\Controllers\Admin\Vehicles\VehiclesController;


Route::get('/dashboard',[DashboardController::class,'index'])->middleware('can:admin.dashboard')->name('admin.dashboard');
Route::post('/change-goal', [DashboardController::class, 'changeGoal'])->name('changeGoal');
Route::resource('/states', StatesController::class)->names('admin.states');
Route::resource('/roles', RolesController::class)->names('admin.roles');
Route::resource('/setresidencials', SetresidencialsController::class)->names('admin.setresidencials');
Route::resource('/agglomerations', AgglomerationsController::class)->names('admin.agglomerations');
Route::resource('/units', UnitsController::class)->names('admin.units');
Route::resource('/users', UsersController::class)->names('admin.users');
Route::resource('/elements',ElementsController::class)->names('admin.elements');
Route::resource('/goals',GoalsController::class)->names('admin.goals');
Route::resource('/visitors',VisitorsController::class)->names('admin.visitors');
Route::resource('/employeeincomes',EmployeeincomesController::class)->names('admin.employeeincomes');
Route::resource('/vehicles',VehiclesController::class)->names('admin.vehicles');
Route::resource('/typeusers',TypeUsersController::class)->names('admin.typeusers');
Route::resource('/companies',CompaniesController::class)->names('admin.companies');

Route::post('/visitors/confirm/{id}', [VisitorsController::class, 'confirmVisitor'])->name('visitors.confirm');
Route::post('/employeeincomes/datefinisconfir/{id}', [EmployeeincomesController::class, 'dateFinisConfir'])->name('employeeincomes.datefinisconfir');
Route::post('dashboard/export-incomes', [DashboardController::class, 'exportIncomes'])->name('dashboard.exportIncomes');
