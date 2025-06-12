<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Exports\Admin\EmployeeIncomesExport\EmployeeIncomesExport;
use App\Http\Controllers\Controller;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(){
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

        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $countUsers = User::whereNotIn('id', [1, 2])->count();
            $countSetresidencials = Setresidencial::count();
            $countVehicles = Vehicle::count();
            return view('admin.dashboard.index',compact('countUsers','countSetresidencials','countVehicles'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')){
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();

            $countUsers = User::whereNotIn('id', [1, 2])->whereHas('setresidencials', function ($query) use ($setresidencialIds) {
                $query->whereIn('setresidencial_id', $setresidencialIds);
            })
            ->whereHas('setresidencials')->count();

            $countGoals = Goal::whereHas('setresidencial', function ($query) use ($setresidencialIds) {
                $query->whereIn('setresidencial_id', $setresidencialIds);
            })->count();
            $countVehicles = Vehicle::where('setresidencial_id',$setresidencialIds)->count();
            return view('admin.dashboard.index',compact('countUsers','countGoals','countVehicles'));
        }
        elseif (auth()->user()->hasRole('PORTERO')){
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();

            $goals = auth()->user()->goals()->get();

            $countVehicles = Vehicle::where('setresidencial_id',$setresidencialIds)->count();

            $countVisitors = Visitor::where('setresidencial_id',$setresidencialIds)->count();

            return view('admin.dashboard.index',compact('goals','countVehicles','countVisitors'));
        }
    }

    public function exportIncomes(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new EmployeeIncomesExport($startDate, $endDate), 'exportable_ingresos.xlsx');
    }

    public function changeGoal(Request $request)
    {
        $user = auth()->user();

        if (!$user->goals()->where('goals.id', $request->goal_id)->exists()) {
            return redirect()->route('admin.dashboard')->with('error', 'NO TIENES PERMISO PARA SELECCIONAR ESTA PORTERÍA.');
        }

        session(['current_goal' => $request->goal_id]);
        session()->put('goalModalShown', true);


        return redirect()->route('admin.dashboard')->with('success', 'PORTERÍA MODIFICADA CON ÉXITO.');
    }


}
