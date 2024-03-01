<?php

namespace App\Livewire\Admin\Vehicles;

use App\Models\State\State;
use App\Models\Vehicle\Vehicle;
use Livewire\Component;

class VehiclesFilter extends Component
{
    public $plateVehicles;
    public $ownerVehicles;
    public $statesVehicles;

    public function render()
    {
        $states = State::all();
        $vehicles = Vehicle::query()
            ->when($this->plateVehicles, function ($query){
                $query->where('plate',  'like', '%' .$this->plateVehicles . '%');
            })
            ->when($this->ownerVehicles, function ($query){
                $query->where('owner',  'like', '%' .$this->ownerVehicles . '%');
            })
            ->when($this->statesVehicles, function ($query) {
                $query->where('state_id', $this->statesVehicles);
            })
            ->get();

        return view('livewire.admin.vehicles.vehicles-filter',compact('states','vehicles'));
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
