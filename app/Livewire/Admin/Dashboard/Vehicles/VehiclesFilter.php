<?php

namespace App\Livewire\Admin\Dashboard\Vehicles;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Vehicle\Vehicle;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VehiclesFilter extends Component
{
    public $placaVehicles;
    public $vehicle;
    public $vehiclesExists = false;
    public $employeeincome;
    public $employeeincomeExists = false;

    public function render()
    {
        return view('livewire.admin.dashboard.vehicles.vehicles-filter');
    }

    public function applyFilters()
    {
        $this->reset(['vehicle', 'vehiclesExists','employeeincome','employeeincomeExists']);

        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if ($this->placaVehicles) {
            $this->vehicle = Vehicle::where('placa', $this->placaVehicles)
                ->where('setresidencial_id',$setresidencial->id)->first();

            if ($this->vehicle) {
                $this->vehiclesExists = true;

                $this->employeeincome = Employeeincome::where('vehicle_id', $this->vehicle->id)->latest()->first();
                if ($this->employeeincome) {
                    $this->employeeincomeExists = true;
                }
            }
        }

        // Dispara evento para abrir modal desde JavaScript
        $this->dispatch('openModalVehicle');
    }

     public function registerDeparture()
    {
        $exitEntry = $this->employeeincome->exitentries->first();

        if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {

            ExitEntry::create([
                'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                'goal_id' => session('current_goal'),
                'user_id' => Auth::user()->id,
                'employeeincome_id' => $this->employeeincome->id,
            ]);
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

}
