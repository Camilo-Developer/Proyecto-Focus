<?php

namespace App\Http\Controllers\Admin\Goals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Goals\GoalsCreateRequest;
use App\Http\Requests\Admin\Goals\GoalsUpdateRequest;
use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.goals.index')->only('index');
        $this->middleware('can:admin.goals.edit')->only('edit', 'update');
        $this->middleware('can:admin.goals.show')->only('show');
        $this->middleware('can:admin.goals.create')->only('create', 'store');
        $this->middleware('can:admin.goals.destroy')->only('destroy');
    } 

    public function index()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $goals = Goal::all();
        $states = State::all();
        $setresidencials = Setresidencial::where('state_id', 1)->get();
        return view('admin.goals.index',compact('goals','states','setresidencials'));
    }

    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }


        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $setresidencials = Setresidencial::where('state_id', 1)->get();

            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [3]);
            })->where('state_id',1)->get();

            return view('admin.goals.create',compact('states','setresidencials','users'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {

            $states = State::all();
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [3]);
            })->where('state_id',1)
            ->whereHas('setresidencials', function ($query) use ($setresidencials) {
                $query->whereIn('setresidencials.id', $setresidencials->pluck('id'));
            })
            ->get();

            return view('admin.goals.create',compact('states','setresidencials','users'));
        }
    }
    
    public function store(GoalsCreateRequest $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $goal = Goal::create($request->all());
        $goal->users()->sync($request->users); 
        return redirect()->route('admin.goals.index')->with('success','LA PORTERIA SE CREO CORRECTAMENTE');
    }

   
   
    public function edit(Goal $goal)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->can('admin.permission.administrator')) {

            $states = State::all();
            $setresidencials = Setresidencial::where('state_id', 1)
                ->orWhere(function ($query) use ($goal) {
                    $query->where('state_id', 2)
                        ->whereHas('goals', function ($q) use ($goal) {
                            $q->where('setresidencial_id', $goal->setresidencial_id);
                        });
                })
            ->get();

            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [3]);
            })
            ->where(function ($query) use ($goal) {
                $query->where('state_id', 1) 
                    ->orWhere(function ($subQuery) use ($goal) {
                        $subQuery->where('state_id', 2)
                            ->whereHas('goals', function ($q) use ($goal) {
                                $q->where('goal_id', $goal->id);
                            });
                    });
            })
            ->get();
        
        
            $users_all = $goal->users->pluck('id')->toArray();

            return view('admin.goals.edit',compact('goal','states','setresidencials','users','users_all'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {
            
            $states = State::all();

            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->orWhere(function ($query) use ($goal) {
                $query->where('state_id', 2)
                    ->whereHas('goals', function ($q) use ($goal) {
                        $q->where('setresidencial_id', $goal->setresidencial_id);
                    });
            })
            ->get();
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [3]);
            })
            ->where(function ($query) use ($goal) {
                $query->where('state_id', 1) 
                    ->orWhere(function ($subQuery) use ($goal) {
                        $subQuery->where('state_id', 2)
                            ->whereHas('goals', function ($q) use ($goal) {
                                $q->where('goal_id', $goal->id);
                            });
                    });
            })
            ->get();
        
            $users_all = $goal->users->pluck('id')->toArray();

            return view('admin.goals.edit',compact('goal','states','setresidencials','users','users_all'));
        }
    }

    public function show(Goal $goal)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        return view('admin.goals.show',compact('goal'));
    }
    
    public function update(GoalsUpdateRequest $request,Goal $goal)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $goal->update($request->all());
        $goal->users()->sync($request->users); 

        return redirect()->route('admin.goals.index')->with('edit','LA PORTERIA SE EDITO CORRECTAMENTE');
    }

    
    public function destroy(Goal $goal)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        try {
            $goal->delete();
            return redirect()->route('admin.goals.index')->with('delete','LA PORTERIA SE ELIMINO CORRECTAMENTE');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.goals.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            // Otros errores
            return redirect()->route('admin.goals.index')->with('info', 'OCURRIO UN ERROR AL INTENTAR ELIMINAR LA PORTERIA.');
        }
    }
}
