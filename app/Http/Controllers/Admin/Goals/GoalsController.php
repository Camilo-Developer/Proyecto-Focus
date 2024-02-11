<?php

namespace App\Http\Controllers\Admin\Goals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Goals\GoalsCreateRequest;
use App\Http\Requests\Admin\Goals\GoalsUpdateRequest;
use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.goals.index')->only('index');
        $this->middleware('can:admin.goals.edit')->only('edit', 'update');
        $this->middleware('can:admin.goals.create')->only('create', 'store');
        $this->middleware('can:admin.goals.destroy')->only('destroy');
    } 

    public function index()
    {
        $goals = Goal::all();
        $states = State::all();
        $setresidencials = Setresidencial::all();
        return view('admin.goals.index',compact('goals','states','setresidencials'));
    }

    
    public function store(GoalsCreateRequest $request)
    {
        Goal::create($request->all());
        return redirect()->route('admin.goals.index')->with('success','El elemento se creo con éxito');
    }

   
   
    public function edit(Goal $goal)
    {
        return view('admin.goals.index',compact('goal'));
    }

    
    public function update(GoalsUpdateRequest $request,Goal $goal)
    {
        $goal->update($request->all());
        return redirect()->route('admin.goals.index')->with('edit','El elemento se edito con éxito');
    }

    
    public function destroy(Goal $goal)

    {
        $goal->delete();
        return redirect()->route('admin.goals.index')->with('delete','El elemento se elimino con éxito');
    }
}
