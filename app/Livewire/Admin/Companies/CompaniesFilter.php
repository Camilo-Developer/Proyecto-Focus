<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CompaniesFilter extends Component
{
    use WithPagination;

    public $nameCompanies;

    public function render()
    {
        $companies = Company::query()
                    ->when($this->nameCompanies, function ($query){
                        $query->where('name',  'like', '%' .$this->nameCompanies . '%');
                    })
                ->paginate(10);
        return view('livewire.admin.companies.companies-filter',compact('companies'));
    }
    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameCompanies':
                $this->nameCompanies = null;
                break;
        }
    }
}
