<?php

namespace App\Livewire\Admin\Dashboard\Goals;

use Livewire\Component;
use App\Models\Visitor\Visitor;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DocumentFilter extends Component
{

    public $documentNumberVisitor;
    public $visitor;
    public $visitorExists = false;
    public $employeeincome;
    public $employeeincomeExists = false;
    public $selectedVehicleId = null;
    public $exitentry;


    public function render()
    {
        return view('livewire.admin.dashboard.goals.document-filter');
    }

    public function applyFilters()
    {
        $this->reset(['visitor', 'visitorExists','employeeincome','employeeincomeExists','exitentry','selectedVehicleId']);

        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if ($this->documentNumberVisitor) {
            $this->visitor = Visitor::where('document_number', $this->documentNumberVisitor)
            ->where('setresidencial_id',$setresidencial->id)->first();

            if ($this->visitor) {
                $this->visitorExists = true;

                $this->employeeincome = Employeeincome::where('visitor_id', $this->visitor->id)->latest()->first();
                if ($this->employeeincome) {
                    $this->exitentry = ExitEntry::where('visitor_id', $this->visitor->id)->where('employeeincome_id', $this->employeeincome->id)->latest()->first();
                    $this->employeeincomeExists = true;
                }
            }
        }

        // Dispara evento para abrir modal desde JavaScript
        $this->dispatch('openModalVisitor');
    }

    public function registerDeparture()
    {

        $exitEntry = $this->exitentry;


        if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {
            $vehicleIngreso = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
                ->latest()
            ->first();


            
            if ($vehicleIngreso) {
                $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
                    ->where('vehicle_id', $this->selectedVehicleId)
                    ->latest()
                ->first();
                    

                if ($vehicleSalida) {
                    $this->dispatch('alertSalida');
                    return;
                }else{

                    if($this->selectedVehicleId){
                        ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'employeeincomevehicle_id' => $vehicleIngreso->id,
                            'visitor_id' => $this->visitor->id,
                            'vehicle_id' => $this->selectedVehicleId,//id del vehiculo
                        ]);
                    }else{
                        ExitEntry::create([
                            'type_income' => 1,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'visitor_id' => $this->visitor->id,
                        ]);
                    }
                }
            }else{

                 $vehicleSalidaTwo = ExitEntry::where('vehicle_id', $this->selectedVehicleId)
                    ->latest()
                ->first();
                    

                if ($vehicleSalidaTwo) {
                    $this->dispatch('alertSalida');
                    return;
                }else{
                    if($this->selectedVehicleId){
                        ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'employeeincomevehicle_id' => $this->employeeincome->id,
                            'visitor_id' => $this->visitor->id,
                            'vehicle_id' => $this->selectedVehicleId,//id del vehiculo
                        ]);
                    }else{
                        ExitEntry::create([
                            'type_income' => 1,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'visitor_id' => $this->visitor->id,
                        ]);
                    }
                }
            }
            
            // Refrescar datos para mostrar en el modal
            $this->applyFilters();

            // Opcional: emitir un mensaje toast o cerrar modal desde JS
            $this->dispatch('departureRegistered'); // Puedes manejar esto con JS para mostrar alerta
        }
    }
    
    public function removeFilter($filter)
    {
        if ($filter === 'documentNumberVisitor') {
            $this->documentNumberVisitor = null;
        }
    }

   public function selectVehicle($vehicleId)
    {
        if ($this->selectedVehicleId === $vehicleId) {
            $this->selectedVehicleId = null;
        } else {
            $this->selectedVehicleId = $vehicleId;
        }
    }

    public function crearIngresoConValidacion()
    {
        if (!$this->visitor || !$this->selectedVehicleId) {
            return;
        }

        // Verificar si el vehículo tiene un ingreso sin salida
        $vehicleIngreso = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
            ->latest()
            ->first();

        if ($vehicleIngreso) {
            $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
                ->where('vehicle_id', $this->selectedVehicleId)
                ->latest()
                ->first();

            // Si hay ingreso pero NO hay salida, no puede volver a ingresar
            if (!$vehicleSalida) {
                $this->dispatch('alertIngresoBloqueado2');
                return;
            }
        }

        // Si no tiene ingreso activo, redirige a la ruta
        return redirect()->route('admin.employeeincomes.createIncom.vehicle', [
            'ingVi' => $this->visitor->id,
            'vehicle' => $this->selectedVehicleId,
        ]);
    }

    public function crearIngresoConValidacion2()
    {
        if (!$this->visitor || !$this->selectedVehicleId) {
            return;
        }

        $vehicleIngresoVehi = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
            ->latest()
        ->first();

        if ($vehicleIngresoVehi) {

            $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngresoVehi->id)
                ->where('vehicle_id', $this->selectedVehicleId)
                ->latest()
                ->first();


            if (!$vehicleSalida) {
                $this->dispatch('alertIngresoBloqueado');
                return;
            }
        }

        return redirect()->route('admin.employeeincomes.createIncom.vehicle', [
            'ingVi' => $this->visitor->id,
            'vehicle' => $this->selectedVehicleId,
        ]);
    }



    public function SalidaValidation()
    {
        $vehicleIngreso = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
            ->latest()
        ->first();

        if ($vehicleIngreso) {
            $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
                ->where('vehicle_id', $this->selectedVehicleId)
                ->latest()
            ->first();

            if ($vehicleSalida) {
                $this->dispatch('alertSalida');
                return;
            }
        }else{
            $vehicleSalidaTwo = ExitEntry::where('vehicle_id', $this->selectedVehicleId)
                ->latest()
            ->first();

            if ($vehicleSalidaTwo) {
                $this->dispatch('alertSalida');
                return;
            }
        }

       
$url = route('admin.employeeincomes.createExit', [
    'employeeincome' => $this->employeeincome->id,
]);

$url .= '?ingVi=' . $this->visitor->id . '&vehicle=' . $this->selectedVehicleId . '&iden=p';

return redirect($url);


    }

}
