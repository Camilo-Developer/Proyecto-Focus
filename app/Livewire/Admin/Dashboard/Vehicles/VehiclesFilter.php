<?php

namespace App\Livewire\Admin\Dashboard\Vehicles;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Vehicle\Vehicle;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VehiclesFilter extends Component
{
    public $placaVehicles;
    public $vehicle;
    public $vehiclesExists = false;
    public $employeeincome;
    public $employeeincomeExists = false;

    public $selectedVisitorId = null;
    public $exitentry;

    public function render()
    {
        return view('livewire.admin.dashboard.vehicles.vehicles-filter');
    }

    public function applyFilters()
    {
        $this->reset(['vehicle', 'vehiclesExists','employeeincome','employeeincomeExists','exitentry','selectedVisitorId']);

        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if ($this->placaVehicles) {
            $this->vehicle = Vehicle::where('placa', $this->placaVehicles)
                ->where('setresidencial_id',$setresidencial->id)->first();

            if ($this->vehicle) {
                $this->vehiclesExists = true;

                $this->employeeincome = Employeeincome::where('vehicle_id', $this->vehicle->id)
                    ->latest()
                ->first();

                if ($this->employeeincome) {
                    $this->exitentry = ExitEntry::where('vehicle_id', $this->vehicle->id)
                        ->where('employeeincomevehicle_id', $this->employeeincome->id)
                        ->latest()
                    ->first();
                    $this->employeeincomeExists = true;
                }
            }
        }

        // Dispara evento para abrir modal desde JavaScript
        $this->dispatch('openModalVehicle');
    }

    public function registerDeparture()
    {
        $exitEntry = $this->exitentry;

        if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {

            $visitorIngreso = Employeeincome::where('visitor_id', $this->selectedVisitorId)
                ->latest()
            ->first();


            if ($visitorIngreso) {
                $visitorSalida = ExitEntry::where('employeeincome_id', $visitorIngreso->id)
                    ->where('visitor_id', $this->selectedVisitorId)
                    ->latest()
                ->first();
                    
                if ($visitorSalida) {
                    $this->dispatch('alertSalida');
                    return;
                }else{
                    if($this->selectedVisitorId){
                        ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'employeeincomevehicle_id' => $visitorIngreso->id,
                            'visitor_id' => $this->selectedVisitorId,
                            'vehicle_id' => $this->vehicle->id,//id del vehiculo
                        ]);
                    }else{
                         $this->dispatch('sinVisitor');
                        return;
                    }
                }
            }else{
                $visitorSalidaTwo = ExitEntry::where('visitor_id', $this->selectedVisitorId)
                    ->latest()
                ->first();
                if ($visitorSalidaTwo) {
                    $this->dispatch('alertSalida');
                    return;
                }else{
                    if($this->selectedVisitorId){
                        ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                            'employeeincomevehicle_id' => $this->employeeincome->id,
                            'visitor_id' => $this->selectedVisitorId,
                            'vehicle_id' => $this->visitor->id,
                        ]);
                    }
                    else{
                         $this->dispatch('sinVisitor');
                        return;
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
        if ($filter === 'placaVehicles') {
            $this->placaVehicles = null;
        }
    }

    public function selectVehicle($vehicleId)
    {
        if ($this->selectedVisitorId === $vehicleId) {
            $this->selectedVisitorId = null;
        } else {
            $this->selectedVisitorId = $vehicleId;
        }
    }

    public function crearIngresoConValidacion()
    {
        if (!$this->vehicle || !$this->selectedVisitorId) {
            return;
        }

        $visitanteIngreso = Employeeincome::where('visitor_id', $this->selectedVisitorId)
            ->latest()
        ->first();

        if ($visitanteIngreso) {
            $visitorSalida = ExitEntry::where('employeeincome_id', $visitanteIngreso->id)
                ->where('visitor_id', $this->selectedVisitorId)
                ->latest()
                ->first();

            // Si hay ingreso pero NO hay salida, no puede volver a ingresar
            if (!$visitorSalida) {
                $this->dispatch('alertIngresoBloqueado2');
                return;
            }
        }

        // Si no tiene ingreso activo, redirige a la ruta
        return redirect()->route('admin.employeeincomes.createIncom.vehicle', [
            'vehicle' => $this->vehicle->id,
            'ingVi' => $this->selectedVisitorId,
            'iden' => 'V'
        ]);
    }

     public function crearIngresoConValidacion2()
    {
        if (!$this->vehicle || !$this->selectedVisitorId) {
            return;
        }

        $visitorIngreso = Employeeincome::where('visitor_id', $this->selectedVisitorId)
            ->latest()
        ->first();

        if ($visitorIngreso) {

            $visitorSalida = ExitEntry::where('employeeincome_id', $visitorIngreso->id)
                ->where('visitor_id', $this->selectedVisitorId)
                ->latest()
                ->first();


            if (!$visitorSalida) {
                $this->dispatch('alertIngresoBloqueado');
                return;
            }
        }

        return redirect()->route('admin.employeeincomes.createIncom.vehicle', [
            'ingVi' => $this->selectedVisitorId,
            'vehicle' => $this->vehicle->id,
            'iden' => 'V'
        ]);
    }



    public function SalidaValidation()
    {
        $visitorIngreso = Employeeincome::where('visitor_id', $this->selectedVisitorId)
            ->latest()
        ->first();

        if ($visitorIngreso) {
            $visitorSalida = ExitEntry::where('employeeincome_id', $visitorIngreso->id)
                ->where('visitor_id', $this->selectedVisitorId)
                ->latest()
            ->first();

            if ($visitorSalida) {
                $this->dispatch('alertSalida');
                return;
            }
        }else{
            $visitorSalidaTwo = ExitEntry::where('visitor_id', $this->selectedVisitorId)
                ->latest()
            ->first();

            if ($visitorSalidaTwo) {
                $this->dispatch('alertSalida');
                return;
            }
        }

            
        $url = route('admin.employeeincomes.createExit', [
            'employeeincome' => $this->employeeincome->id,
        ]);

        $url .= '?ingVi=' . $this->selectedVisitorId . '&vehicle=' . $this->vehicle->id . '&iden=V';

        return redirect($url);


    }
}
