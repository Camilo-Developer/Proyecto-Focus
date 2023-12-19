<?php

namespace App\Models\EmployeeIncome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeeincome extends Model
{
    use HasFactory;

    protected $table = 'employeeincomes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admission_date',
        'departure_date',
        'contractoremployee_id',
    ];

    /*Relacion directa Lista*/
    public function contractoremployee(){
        return $this->belongsTo('App\Models\ContractorEmployee\Contractoremployee', 'contractoremployee_id');
    }
}
