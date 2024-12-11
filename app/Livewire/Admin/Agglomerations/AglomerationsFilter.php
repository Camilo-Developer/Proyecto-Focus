<?php

namespace App\Livewire\Admin\Agglomerations;

use App\Models\Agglomeration\Agglomeration;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AglomerationsFilter extends Component
{
    public $nameAglomeration;
    public $typeAglomeration;
    public $stateAglomeration;
    public $setresidencialAglomeration;
    public $filtrosAvanzadosAbiertosUnit = false;


    public function render()
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $states = State::all();
            $setresidencials = Setresidencial::where('state_id', 1)->get();
            $agglomerations = Agglomeration::query()
                ->when($this->nameAglomeration, function ($query){
                    $query->where('name',  'like', '%' .$this->nameAglomeration . '%');
                })
                ->when($this->typeAglomeration, function ($query){
                    $query->where('type_agglomeration',  'like', '%' .$this->typeAglomeration . '%');
                })
                ->when($this->stateAglomeration, function ($query) {
                    $query->where('state_id', $this->stateAglomeration);
                })
                ->when($this->setresidencialAglomeration, function ($query) {
                    $query->where('setresidencial_id', $this->setresidencialAglomeration);
                })
            ->get();

            return view('livewire.admin.agglomerations.aglomerations-filter',compact('agglomerations','states','setresidencials'));

        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')){

            $states = State::all();
            $setresidencials = Setresidencial::all();
            $setresidencial = Setresidencial::where('user_id',Auth::user()->id)->first();

            $aglomerations = Agglomeration::query()
                ->where('setresidencial_id', $setresidencial->id)
                ->when($this->nameAglomeration, function ($query){
                    $query->where('name',  'like', '%' .$this->nameAglomeration . '%');
                })
                ->when($this->typeAglomeration, function ($query){
                    $query->where('type_agglomeration',  'like', '%' .$this->typeAglomeration . '%');
                })
                ->when($this->stateAglomeration, function ($query) {
                    $query->where('state_id', $this->stateAglomeration);
                })
                ->when($this->setresidencialAglomeration, function ($query) {
                    $query->where('setresidencial_id', $this->setresidencialAglomeration);
                })
            ->get();

            return view('livewire.admin.agglomerations.aglomerations-filter',compact('agglomerations','states','setresidencials'));
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
            case 'nameAglomeration':
                $this->nameAglomeration = null;
                break;
            case 'typeAglomeration':
                $this->typeAglomeration = null;
                break;
            case 'stateAglomeration':
                $this->stateAglomeration = null;
                break;
            case 'setresidencialAglomeration':
                $this->setresidencialAglomeration = null;
                break;
        }
    }

}
