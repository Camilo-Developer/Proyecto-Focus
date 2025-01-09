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
        $states = State::all();
        $vehicles = Vehicle::query()
            ->when($this->plateVehicles, function ($query){
                $query->where('plate',  'like', '%' .$this->plateVehicles . '%');
            })
            ->when($this->statesVehicles, function ($query) {
                $query->where('state_id', $this->statesVehicles);
            })
            ->paginate(10);

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
