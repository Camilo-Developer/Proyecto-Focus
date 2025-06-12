<?php

namespace App\Models\EmployeeIncome;

use App\Models\Agglomeration\Agglomeration;
use App\Models\Element\Element;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeeincome extends Model
{
    use HasFactory;

    protected $table = 'employeeincomes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_income',
        'admission_date',
        'nota',
        'visitor_id',
        'setresidencial_id',
        'agglomeration_id',
        'unit_id',
        'goal_id',
        'user_id',
        'vehicle_id'
    ];

    /*Relacion directa Lista*/
    public function visitor(){
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }

    /*Relacion directa Lista*/
    public function setresidencial(){
        return $this->belongsTo(Setresidencial::class, 'setresidencial_id');
    }

    /*Relacion directa Lista*/
    public function agglomeration(){
        return $this->belongsTo(Agglomeration::class, 'agglomeration_id');
    }

    /*Relacion directa Lista*/
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /*Relacion directa Lista*/
    public function goal(){
        return $this->belongsTo(Goal::class, 'goal_id');
    }

    /*Relacion directa Lista*/
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /*Relacion directa Lista*/
    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /*Relacion inversa Lista*/
    public function exitentries(){
        return $this->hasMany(ExitEntry::class, 'employeeincome_id');
    }

    /*Relacion de muchos a muchos*/
    public function elements(){
        return $this->belongsToMany(Element::class,'element_has_employeeincome')->withPivot('id','imagen', 'nota');
    }

}
