<?php

namespace App\Livewire\Admin\Units;

use App\Models\Agglomeration\Agglomeration;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Unit\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UnitsFilter extends Component
{
    use WithPagination;

    public $nameUnit;
    public $stateUnit;
    public $agglomerationUnit;
    public $setresidencialUnit;
    public $filtrosAvanzadosAbiertosUnit = false;

    public function render()
    {
        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $agglomerations = Agglomeration::get();
            $setresidencials = Setresidencial::get();

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
                ->when($this->setresidencialUnit, function ($query) {
                    $query->whereHas('agglomeration.setresidencial', function ($query) {
                        $query->where('id', $this->setresidencialUnit);
                    });
                })
                ->paginate(10);
    
            return view('livewire.admin.units.units-filter',compact('states', 'agglomerations', 'units','setresidencials'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')){
            $states = State::all();

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            
            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)->get();
            $agglomerationsID = Agglomeration::where('setresidencial_id', $setresidencial->id)->pluck('id');
            
            $units = Unit::query()
                ->whereIn('agglomeration_id', $agglomerationsID)
                ->when($this->nameUnit, function ($query){
                    $query->where('name',  'like', '%' .$this->nameUnit . '%');
                })
                ->when($this->stateUnit, function ($query) {
                    $query->where('state_id', $this->stateUnit);
                })
                ->when($this->agglomerationUnit, function ($query) {
                    $query->where('agglomeration_id', $this->agglomerationUnit);
                })
                ->when($this->setresidencialUnit, function ($query) {
                    $query->whereHas('agglomeration.setresidencial', function ($query) {
                        $query->where('id', $this->setresidencialUnit);
                    });
                })
                ->paginate(10);
    
            return view('livewire.admin.units.units-filter',compact('states', 'agglomerations', 'units','setresidencials'));
        }

       
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
            case 'setresidencialUnit':
                $this->setresidencialUnit = null;
                break;
        }
    }
}
