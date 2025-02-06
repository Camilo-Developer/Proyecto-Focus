<?php

namespace App\Models\Visitor;

use App\Models\Company\Company;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Typeuser\Typeuser;
use App\Models\Unit\Unit;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'document_number',
        'confirmation',
        'imagen',
        'state_id',
        'type_user_id',
        'company_id',
        'setresidencial_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }
    /*Relacion directa Lista*/
    public function typeuser(){
        return $this->belongsTo(Typeuser::class, 'type_user_id');
    }
    /*Relacion directa Lista*/
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    /*Relacion directa Lista*/
    public function setresidencial(){
        return $this->belongsTo(Setresidencial::class, 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function employeeincomes(){
        return $this->hasMany(Employeeincome::class, 'visitor_id');
    }


    /*Relacion de muchos a muchos*/
    public function units(){
        return $this->belongsToMany(Unit::class,'visitor_has_unit');
    }

    /*Relacion de muchos a muchos*/
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class,'vehicle_has_visitor');
    }
}
