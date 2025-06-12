<?php

namespace App\Livewire\Admin\Dashboard\Goals;

use Livewire\Component;
use App\Models\Visitor\Visitor;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
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

    public function render()
    {
        return view('livewire.admin.dashboard.goals.document-filter');
    }

    public function applyFilters()
    {
        $this->reset(['visitor', 'visitorExists','employeeincome','employeeincomeExists']);

        $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if ($this->documentNumberVisitor) {
            $this->visitor = Visitor::where('document_number', $this->documentNumberVisitor)
            ->where('setresidencial_id',$setresidencial->id)->first();

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
        $exitEntry = $this->employeeincome->exitentries->first();

        if ($this->employeeincome && $this->employeeincomeExists && $exitEntry === null) {

            ExitEntry::create([
                'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                'goal_id' => session('current_goal'),
                'user_id' => Auth::user()->id,
                'employeeincome_id' => $this->employeeincome->id,
            ]);
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
