<?php

namespace App\Livewire\Admin\Dashboard\Goals;

use Livewire\Component;
use App\Models\Visitor\Visitor;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Unit\Unit;
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



    public $showUnitModal = false;  
    public $visitorUnits = [];       
    public $selectedUnit = null; 


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
                ->where('setresidencial_id',$setresidencial->id)
            ->first();

            if ($this->visitor) {
                $this->visitorExists = true;

                 $this->employeeincome = Employeeincome::whereHas('visitors', function ($query) {
                        $query->where('visitors.id', $this->visitor->id);
                    })
                    ->with(['vehicles', 'visitors'])
                    ->latest()
                ->first();
                 //dd($this->employeeincome);

                if ($this->employeeincome) {


                    $this->exitentry = ExitEntry::whereHas('visitors', function ($query) {
                            $query->where('visitors.id', $this->visitor->id);
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

        $this->dispatch('openModalVisitor');
    }

    public function registerDeparture()
    {

        $exitEntry = $this->exitentry;


        if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {

            $ingresoVisitante = Employeeincome::whereHas('visitors', function ($query) {
                    $query->where('visitors.id', $this->visitor->id);
                })
                ->with(['vehicles', 'visitors']) 
                ->latest()
            ->first();
                            
            if ($ingresoVisitante) {
                $visitorPivot = $ingresoVisitante->visitors->first();
                $vehiclePivot = $ingresoVisitante->vehicles->first();

                $visitorId = $visitorPivot ? $visitorPivot->pivot->visitor_id : null;
                $vehicleId = $vehiclePivot ? $vehiclePivot->pivot->vehicle_id : null;

                $salidaVisitante = ExitEntry::whereHas('visitors', function ($query) use ($visitorId) {
                                        if ($visitorId) {
                                            $query->where('visitors.id', $visitorId);
                                        }
                                    })
                                    ->with(['vehicles', 'visitors'])
                                    ->latest()
                                    ->first();

                // if ($vehicleId && $vehicleId == $this->selectedVehicleId) {
                //     $salidaVehiculo = ExitEntry::whereHas('vehicles', function ($query) use ($vehicleId) {
                //                             $query->where('vehicles.id', $vehicleId);
                //                         })
                //                         ->with(['vehicles', 'visitors'])
                //                         ->latest()
                //                         ->first();

                //                         dd($salidaVehiculo);
                // } elseif ($this->selectedVehicleId) {
                //     $salidaVehiculo = ExitEntry::whereHas('vehicles', function ($query) {
                //                             $query->where('vehicles.id', $this->selectedVehicleId);
                //                         })
                //                         ->with(['vehicles', 'visitors'])
                //                         ->latest()
                //                         ->first();
                // } else {
                //     $salidaVehiculo = null;
                // }

                // if ($salidaVehiculo) {
                //     $this->dispatch('alertSalida');
                //     return;
                // }else{
                    if($this->selectedVehicleId){
                        $exitEntry = ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                        ]);
                        $exitEntry->vehicles()->attach(
                            $this->selectedVehicleId,
                            ['visitor_id' => $this->visitor->id] 
                        );
                    }else{
                        $exitEntry = ExitEntry::create([
                            'type_income' => 1,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $this->employeeincome->id,
                        ]);
                        $exitEntry->vehicles()->attach(
                            ['vehicle_id' => null], 
                            ['visitor_id' => $this->visitor->id] 
                        );
                    }
                // }
            }
            
            $this->applyFilters();

            $this->dispatch('departureRegistered'); 
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

        // $vehicleIngreso = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
        //     ->latest()
        //     ->first();

        // if ($vehicleIngreso) {
        //     $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
        //         ->where('vehicle_id', $this->selectedVehicleId)
        //         ->latest()
        //         ->first();

        //     if (!$vehicleSalida) {
        //         $this->dispatch('alertIngresoBloqueado2');
        //         return;
        //     }
        // }

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

        // $vehicleIngresoVehi = Employeeincome::where('vehicle_id', $this->selectedVehicleId)
        //     ->latest()
        // ->first();

        // if ($vehicleIngresoVehi) {

        //     $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngresoVehi->id)
        //         ->where('vehicle_id', $this->selectedVehicleId)
        //         ->latest()
        //         ->first();


        //     if (!$vehicleSalida) {
        //         $this->dispatch('alertIngresoBloqueado');
        //         return;
        //     }
        // }

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

        // if ($vehicleIngreso) {
        //     $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
        //         ->where('vehicle_id', $this->selectedVehicleId)
        //         ->latest()
        //     ->first();

        //     if ($vehicleSalida) {
        //         $this->dispatch('alertSalida');
        //         return;
        //     }
        // }else{
        //     $vehicleSalidaTwo = ExitEntry::where('vehicle_id', $this->selectedVehicleId)
        //         ->latest()
        //     ->first();

        //     if ($vehicleSalidaTwo) {
        //         $this->dispatch('alertSalida');
        //         return;
        //     }
        // }

       
        $url = route('admin.employeeincomes.createExit', [
            'employeeincome' => $this->employeeincome->id,
        ]);

        $url .= '?ingVi=' . $this->visitor->id . '&vehicle=' . $this->selectedVehicleId . '&iden=p';

        return redirect($url);


    }


    public function createIncomeVisiOnly()
    {
        $units = $this->visitor->units; 

        if ($units->count() === 1) {
            $unit = $units->first()->load('agglomeration');


            if($this->selectedVehicleId){
                $employeeIncome = Employeeincome::create([
                    'type_income'       => 2,
                    'admission_date'    => now(),
                    // 'visitor_id'        => $this->visitor->id,
                    'unit_id'           => $unit->id,
                    'setresidencial_id' => $unit->agglomeration?->setresidencial_id,
                    'agglomeration_id'  => $unit->agglomeration_id,
                    'goal_id'           => session('current_goal'),
                    'user_id'           => auth()->id(),
                    'nota'           => null,
                ]);

                 $employeeIncome->vehicles()->attach(
                    $this->selectedVehicleId,
                    ['visitor_id' => $this->visitor->id] 
                );


            }else{
                $employeeIncome = Employeeincome::create([
                    'type_income'       => 1,
                    'admission_date'    => now(),
                    'visitor_id'        => $this->visitor->id,
                    'unit_id'           => $unit->id,
                    'setresidencial_id' => $unit->agglomeration?->setresidencial_id,
                    'agglomeration_id'  => $unit->agglomeration_id,
                    'goal_id'           => session('current_goal'),
                    'user_id'           => auth()->id(),
                    'nota'           => null,
                ]);

                $employeeIncome->vehicles()->attach(
                    ['vehicle_id' => null],
                    ['visitor_id' => $this->visitor->id] 
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
            $this->dispatch('alert', message: 'Unidad no encontrada.');
            return;
        }

            if($this->selectedVehicleId){

               $employeeIncome = Employeeincome::create([
                    'type_income'     => 2,
                    'admission_date'  => now(),
                    // 'visitor_id'      => $this->visitor->id,
                    'unit_id'         => $this->selectedUnit,
                    'setresidencial_id'         => $unit->agglomeration?->setresidencial_id,
                    'agglomeration_id'         => $unit->agglomeration_id,
                    'goal_id' => session('current_goal'),
                    'user_id' => Auth::user()->id,
                    'nota'           => null,
                ]);
                $employeeIncome->vehicles()->attach(
                    $this->selectedVehicleId,
                    ['visitor_id' => $this->visitor->id]
                );
            }else{
                $employeeIncome = Employeeincome::create([
                    'type_income'     => 1,
                    'admission_date'  => now(),
                    // 'visitor_id'      => $this->visitor->id,
                    'unit_id'         => $this->selectedUnit,
                    'setresidencial_id'         => $unit->agglomeration?->setresidencial_id,
                    'agglomeration_id'         => $unit->agglomeration_id,
                    'goal_id' => session('current_goal'),
                    'user_id' => Auth::user()->id,
                    'nota'           => null,
                ]);

                $employeeIncome->vehicles()->attach(
                    ['vehicle_id' => null],
                    ['visitor_id' => $this->visitor->id]
                );
            }

        $this->showUnitModal = false;
        $this->dispatch('incomeRegistered');
        $this->applyFilters();
    }


}
