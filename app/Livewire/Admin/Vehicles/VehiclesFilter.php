<?php

namespace App\Livewire\Admin\Vehicles;

use App\Models\State\State;
use App\Models\Vehicle\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class VehiclesFilter extends Component
{
    use WithPagination;

    public $plateVehicles;
    public $ownerVehicles;
    public $statesVehicles;

    public function render()
    {
        if (auth()->user()->can('admin.permission.administrator')) {

            $states = State::all();
            $vehicles = Vehicle::query()
                ->when($this->plateVehicles, function ($query){
                    $query->where('placa',  'like', '%' .$this->plateVehicles . '%');
                })
                ->when($this->statesVehicles, function ($query) {
                    $query->where('state_id', $this->statesVehicles);
                })
                ->paginate(10);

            return view('livewire.admin.vehicles.vehicles-filter',compact('states','vehicles'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $states = State::all();
            $vehicles = Vehicle::query()->where('setresidencial_id', $setresidencial->id)
                ->when($this->plateVehicles, function ($query){
                    $query->where('placa',  'like', '%' .$this->plateVehicles . '%');
                })
                ->when($this->statesVehicles, function ($query) {
                    $query->where('state_id', $this->statesVehicles);
                })
                ->paginate(10);

            return view('livewire.admin.vehicles.vehicles-filter',compact('states','vehicles'));
        }
    }

    public function applyFilters()
    {
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'plateVehicles':
                $this->plateVehicles = null;
                break;
            case 'ownerVehicles':
                $this->ownerVehicles = null;
                break;
            case 'statesVehicles':
                $this->statesVehicles = null;
                break;
        }
    }
}
