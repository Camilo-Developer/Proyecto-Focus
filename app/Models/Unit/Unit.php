<?php

namespace App\Models\Unit;

use App\Models\Agglomeration\Agglomeration;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\State\State;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'state_id',
        'agglomeration_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    /*Relacion directa Lista*/
    public function agglomeration(){
        return $this->belongsTo(Agglomeration::class, 'agglomeration_id');
    }


    /*Relacion inversa Lista*/
    public function employeeincomes(){
        return $this->hasMany(Employeeincome::class, 'unit_id');
    }

    /*Relacion de muchos a muchos*/
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class,'unit_has_vehicle');
    }

    /*Relacion de muchos a muchos*/
    public function visitors(){
        return $this->belongsToMany(Visitor::class,'visitor_has_unit');
    }

}
