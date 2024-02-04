<?php

namespace App\Livewire\Admin\Units;

use App\Models\Agglomeration\Agglomeration;
use App\Models\State\State;
use App\Models\Unit\Unit;
use Livewire\Component;

class UnitsFilter extends Component
{
    public $nameUnit;
    public $stateUnit;
    public $agglomerationUnit;
    public $filtrosAvanzadosAbiertosUnit = false;

    public function render()
    {
        $states = State::all();
        $agglomerations = Agglomeration::all();
        $units = Unit::query()
            ->when($this->nameUnit, function ($query){
                $query->where('name',  'like', '%' .$this->nameUnit . '%');
            })
            ->when($this->stateUnit, function ($query) {
                $query->where('state_id', $this->stateUnit);
            })
            ->when($this->agglomerationUnit, function ($query) {
                $query->where('agglomeration_id', $this->agglomerationUnit);
            })
            ->get();

        return view('livewire.admin.units.units-filter',compact('states', 'agglomerations', 'units'));
    }

    public function applyFilters()
    {
        $this->filtrosAvanzadosAbiertosUnit = false; // O puedes guardar el estado actual, según tus necesidades
    }
    public function toggleAdvancedFilters()
    {
        $this->filtrosAvanzadosAbiertosUnit = !$this->filtrosAvanzadosAbiertosUnit;
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameUnit':
                $this->nameUnit = null;
                break;
            case 'stateUnit':
                $this->stateUnit = null;
                break;
            case 'agglomerationUnit':
                $this->agglomerationUnit = null;
                break;
        }
    }
}
