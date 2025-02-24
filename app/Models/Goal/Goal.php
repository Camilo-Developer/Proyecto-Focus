<?php

namespace App\Models\Goal;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
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
        return $this->hasMany(Employeeincome::class, 'goal_id');
    }

    /*Relacion inversa Lista*/
    public function employeeincomes2(){
        return $this->hasMany(Employeeincome::class, 'goal2_id');
    }

    /*Relacion de muchos a muchos*/
    public function users(){
        return $this->belongsToMany(User::class,'user_has_goal');
    }
}
