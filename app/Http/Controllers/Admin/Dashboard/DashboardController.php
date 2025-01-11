<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Exports\Admin\EmployeeIncomesExport\EmployeeIncomesExport;
use App\Http\Controllers\Controller;
use App\Models\SetResidencial\Setresidencial;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
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

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $countUsers = User::count();
        $countSetresidencials = Setresidencial::count();
        $countVehicles = Vehicle::count();

        return view('admin.dashboard.index',compact('countUsers','countSetresidencials','countVehicles'));
    }

    public function exportIncomes(Request $request)
    {
        // Validar las fechas
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Obtener las fechas del formulario
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Descargar el archivo Excel con los datos filtrados por fecha
        return Excel::download(new EmployeeIncomesExport($startDate, $endDate), 'exportable_ingresos.xlsx');
    }
}
