<?php

namespace App\Models\ContractorEmployee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractoremployee extends Model
{
    use HasFactory;

    protected $table = 'contractoremployees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'state_id',
        'contractor_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion directa Lista*/
    public function contractor(){
        return $this->belongsTo('App\Models\Contractor\Contractor', 'contractor_id');
    }

    /*Relacion inversa Lista*/
    public function elements(){
        return $this->hasMany('App\Models\Element\Element', 'contractoremployee_id');
    }

    /*Relacion inversa Lista*/
    public function employeeincomes(){
        return $this->hasMany('App\Models\EmployeeIncome\Employeeincome', 'contractoremployee_id');
    }

}
