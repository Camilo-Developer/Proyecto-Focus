<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Companies\CompaniesCreateRequest;
use App\Models\Company\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.companies.index')->only('index');
        $this->middleware('can:admin.companies.create')->only('create', 'store');
        $this->middleware('can:admin.companies.edit')->only('edit', 'update');
        $this->middleware('can:admin.companies.show')->only('show');
        $this->middleware('can:admin.companies.destroy')->only('destroy');
    }
 
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index',compact('companies'));
    }


    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(CompaniesCreateRequest $request)
    {
        Company::create($request->all());
        return redirect()->route('admin.companies.index')->with('success','LA EMPRESA FUE CREADA CORRECTAMENTE.');
    }


    public function show(Company $company)
    {
        return view('admin.companies.show',compact('company'));
    }


    public function edit(Company $company)
    {
        return view('admin.companies.edit',compact('company'));
    }


    public function update(CompaniesCreateRequest $request, Company $company)
    {
        $company->update($request->all());
        return redirect()->route('admin.companies.index')->with('edit','LA EMPRESA FUE EDITADA CORRECTAMENTE.');
    }


    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('delete','LA EMPRESA FUE ELIMINADA CORRECTAMENTE.');
    }
}
