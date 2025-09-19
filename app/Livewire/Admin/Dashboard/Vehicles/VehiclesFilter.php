<?php

namespace App\Livewire\Admin\Dashboard\Vehicles;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Unit\Unit;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VehiclesFilter extends Component
{
    public $placaVehicles;
    public $vehicle;
    public $visitor;

    public $vehiclesExists = false;
    public $employeeincome;
    public $employeeincomeExists = false;

    public $selectedVisitorId = null;
    public $selectedVisitorIds = []; 

    public $exitentry;

    public $showUnitModal = false;  
    public $visitorUnits = [];       
    public $selectedUnit = null; 

    public function render()
    {
        return view('livewire.admin.dashboard.vehicles.vehicles-filter');
    }

    public function applyFilters()
    {
        $this->reset(['vehicle', 'vehiclesExists','employeeincome','employeeincomeExists','exitentry','selectedVisitorId','selectedVisitorIds']);

        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if ($this->placaVehicles) {
            $this->vehicle = Vehicle::where('placa', $this->placaVehicles)
                ->where('setresidencial_id',$setresidencial->id)->first();

            if ($this->vehicle) {
                $this->vehiclesExists = true;

                $this->employeeincome = Employeeincome::whereHas('vehicles', function ($query) {
                        $query->where('vehicles.id', $this->vehicle->id);
                    })
                    ->with(['vehicles', 'visitors'])
                    ->latest()
                ->first();

                if ($this->employeeincome) {

                     $this->exitentry = ExitEntry::whereHas('vehicles', function ($query) {
                            $query->where('vehicles.id', $this->vehicle->id);
                        })
                        ->with(['vehicles', 'visitors'])
                        ->latest()
                    ->first();


                   if ($this->exitentry && $this->employeeincome->id === $this->exitentry->employeeincome_id) {
                        // Se queda con la salida encontrada
                    } else {
                        $this->exitentry = null;
                    }


                    $this->employeeincomeExists = true;
                }
            }
        }

        // Dispara evento para abrir modal desde JavaScript
        $this->dispatch('openModalVehicle');
    }

    public function toggleVisitor($visitorId)
    {
        if (in_array($visitorId, $this->selectedVisitorIds)) {
            // quitar visitante si ya estaba seleccionado
            $this->selectedVisitorIds = array_diff($this->selectedVisitorIds, [$visitorId]);
        } else {
            // agregar visitante
            $this->selectedVisitorIds[] = $visitorId;
        }
    }


    public function registerDeparture()
{
    $exitEntry = $this->exitentry;

    if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {

        $exitEntry = ExitEntry::create([
                    'type_income' => 2,
                    'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                    'goal_id' => session('current_goal'),
                    'user_id' => Auth::user()->id,
                    'employeeincome_id' => $this->employeeincome->id,
                ]);

        foreach ($this->selectedVisitorIds as $visitorId) {

            $visitorIngreso = Employeeincome::whereHas('visitors', function ($q) use ($visitorId) {
                    $q->where('visitors.id', $visitorId);
                })
                ->with(['vehicles', 'visitors']) 
                ->latest()
            ->first();


            if ($visitorIngreso) {
                
                $exitEntry->vehicles()->attach(
                    $this->vehicle->id,
                    ['visitor_id' => $visitorId] 
                );
            }
        }

        $this->applyFilters();
        $this->dispatch('departureRegistered');
    }
}




    public function createIncomeVisiOnly()
    {
        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();


        $this->visitor = Visitor::where('id', $this->selectedVisitorIds[0])
                ->where('setresidencial_id',$setresidencial->id)
            ->first();

        $units = $this->visitor->units; 

       if ($units->count() === 1) {
            $unit = $units->first()->load('agglomeration');

                $employeeIncome = Employeeincome::create([
                    'type_income'       => 2,
                    'admission_date'    => now(),
                    'unit_id'           => $unit->id,
                    'setresidencial_id' => $unit->agglomeration?->setresidencial_id,
                    'agglomeration_id'  => $unit->agglomeration_id,
                    'goal_id'           => session('current_goal'),
                    'user_id'           => auth()->id(),
                    'nota'           => null,
                ]);

            foreach ($this->selectedVisitorIds as $visitorId) {
                $employeeIncome->vehicles()->attach(
                    $this->vehicle->id,
                    ['visitor_id' => $visitorId] 
                );
            }

            $this->dispatch('incomeRegistered'); 
            $this->applyFilters();

        } elseif ($units->count() > 1) {

            $this->visitorUnits = $units;
            $this->showUnitModal = true;
        } else {
            $this->dispatch('alert', message: 'ESTE VISITANTE NO TIENE UNIDADES ASOCIADAS.');
        }
    }

    public function confirmUnitSelection()
    {
        if (!$this->selectedUnit) {
            $this->dispatch('alert', message: 'DEBES SELECCIONAR UNA UNIDAD.');
            return;
        }

        $unit = Unit::with('agglomeration')->find($this->selectedUnit);

        if (!$unit) {
            $this->dispatch('alert', message: 'UNIDAD NO ENCONTRADA.');
            return;
        }

            $employeeIncome = Employeeincome::create([
                'type_income'     => 2,
                'admission_date'  => now(),
                'unit_id'         => $this->selectedUnit,
                'setresidencial_id' => $unit->agglomeration?->setresidencial_id,
                'agglomeration_id' => $unit->agglomeration_id,
                'goal_id' => session('current_goal'),
                'user_id' => Auth::user()->id,
                'nota' => null,
            ]);
            foreach ($this->selectedVisitorIds as $visitorId) {
                $employeeIncome->vehicles()->attach(
                    $this->vehicle->id,
                    ['visitor_id' => $visitorId] 
                );
            }
          
        $this->showUnitModal = false;
        $this->dispatch('incomeRegistered');
        $this->applyFilters();
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
    if (!$this->vehicle || empty($this->selectedVisitorIds)) {
        return;
    }

    foreach ($this->selectedVisitorIds as $visitorId) {
        // Buscar el último ingreso de este visitante
        $visitanteIngreso = Employeeincome::whereHas('visitors', function ($q) use ($visitorId) {
                $q->where('visitors.id', $visitorId);
            })
            ->latest()
            ->first();

        if ($visitanteIngreso) {
            $visitorSalida = ExitEntry::where('employeeincome_id', $visitanteIngreso->id)
                ->where('visitor_id', $visitorId)
                ->latest()
                ->first();

            // Si hay ingreso pero NO hay salida, bloqueamos a este visitante
            // if (!$visitorSalida) {
            //     $this->dispatch('alertIngresoBloqueado2', ['visitor_id' => $visitorId]);
            //     return; // si quieres detener todo cuando 1 visitante está bloqueado
            // }
        }
    }

    // Si todos los visitantes seleccionados están libres para ingresar
    return redirect()->route('admin.employeeincomes.createIncom.vehicle', [
        'vehicle' => $this->vehicle->id,
        'ingVi' => implode(',', $this->selectedVisitorIds), // pasar varios IDs
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
        // $visitorIngreso = Employeeincome::where('visitor_id', $this->selectedVisitorId)
        //     ->latest()
        // ->first();

        // if ($visitorIngreso) {
        //     $visitorSalida = ExitEntry::where('employeeincome_id', $visitorIngreso->id)
        //         ->where('visitor_id', $this->selectedVisitorId)
        //         ->latest()
        //     ->first();

        //     if ($visitorSalida) {
        //         $this->dispatch('alertSalida');
        //         return;
        //     }
        // }else{
        //     $visitorSalidaTwo = ExitEntry::where('visitor_id', $this->selectedVisitorId)
        //         ->latest()
        //     ->first();

        //     if ($visitorSalidaTwo) {
        //         $this->dispatch('alertSalida');
        //         return;
        //     }
        // }
            
        $url = route('admin.employeeincomes.createExit', [
            'employeeincome' => $this->employeeincome->id,
        ]);

        $url .= '?ingVi=' . implode(',', $this->selectedVisitorIds) . '&vehicle=' . $this->vehicle->id . '&iden=V';

        return redirect($url);


    }
}
