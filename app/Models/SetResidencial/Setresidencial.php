<?php

namespace App\Models\SetResidencial;

use App\Models\Agglomeration\Agglomeration;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Goal\Goal;
use App\Models\State\State;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setresidencial extends Model
{
    use HasFactory;

    protected $table = 'setresidencials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'imagen',
        'address',
        'nit',
        'state_id',
    ];


    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function agglomerations(){
        return $this->hasMany(Agglomeration::class, 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function goals(){
        return $this->hasMany(Goal::class, 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function visitors(){
        return $this->hasMany(Visitor::class, 'setresidencial_id');
    }

     /*Relacion inversa Lista*/
     public function employeeincomes(){
        return $this->hasMany(Employeeincome::class, 'setresidencial_id');
    }

     /*Relacion inversa Lista*/
     public function vehicles(){
        return $this->hasMany(Vehicle::class, 'setresidencial_id');
    }

     /*Relacion de muchos a muchos*/
     public function users(){
        return $this->belongsToMany(User::class,'setresidencials_has_users');
    }

}
