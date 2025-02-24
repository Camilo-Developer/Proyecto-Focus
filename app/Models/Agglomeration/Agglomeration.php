<?php

namespace App\Models\Agglomeration;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agglomeration extends Model
{
    use HasFactory;

    protected $table = 'agglomerations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'type_agglomeration',
        'state_id',
        'setresidencial_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    /*Relacion directa Lista*/
    public function setresidencial(){
        return $this->belongsTo(Setresidencial::class, 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function employeeincomes(){
        return $this->hasMany(Employeeincome::class, 'agglomeration_id');
    }

    /*Relacion Inversa Lista*/
    public function units(){
        return $this->hasMany(Unit::class, 'agglomeration_id');
    }
}
