<?php

namespace App\Livewire\Admin\Dashboard\Goals;

use Livewire\Component;
use App\Models\Visitor\Visitor;
use App\Models\EmployeeIncome\Employeeincome;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class DocumentFilter extends Component
{

    public $documentNumberVisitor;
    public $visitor;
    public $visitorExists = false;
    public $employeeincome;
    public $employeeincomeExists = false;

    public function render()
    {
        return view('livewire.admin.dashboard.goals.document-filter');
    }

    public function applyFilters()
    {
        $this->reset(['visitor', 'visitorExists','employeeincome','employeeincomeExists']);

        if ($this->documentNumberVisitor) {
            $this->visitor = Visitor::where('document_number', $this->documentNumberVisitor)->first();

            if ($this->visitor) {
                $this->visitorExists = true;

                $this->employeeincome = Employeeincome::where('visitor_id', $this->visitor->id)->latest()->first();
                if ($this->employeeincome) {
                    $this->employeeincomeExists = true;
                }
            }
        }

        // Dispara evento para abrir modal desde JavaScript
        $this->dispatch('openModalVisitor');
    }

     public function registerDeparture()
    {
        if ($this->employeeincome && $this->employeeincomeExists && $this->employeeincome->departure_date === null) {
            $this->employeeincome->departure_date = Carbon::now()->format('Y-m-d H:i');
            $this->employeeincome->goal2_id = session('current_goal');
            $this->employeeincome->save();

            // Refrescar datos para mostrar en el modal
            $this->applyFilters();

            // Opcional: emitir un mensaje toast o cerrar modal desde JS
            $this->dispatch('departureRegistered'); // Puedes manejar esto con JS para mostrar alerta
        }
    }
    
    public function removeFilter($filter)
    {
        if ($filter === 'documentNumberVisitor') {
            $this->documentNumberVisitor = null;
        }
    }


}
