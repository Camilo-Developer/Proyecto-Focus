<?php

namespace App\Models\State;

use App\Models\Agglomeration\Agglomeration;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    protected $primaryKey = 'id';
    protected $fillable = [
      'name',
      'type_state',
    ];


    /*Relacion inversa Lista*/
    public function users(){
        return $this->hasMany(User::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function setresidencials(){
        return $this->hasMany(Setresidencial::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function agglomerations(){
        return $this->hasMany(Agglomeration::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function units(){
        return $this->hasMany(Unit::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function goals(){
        return $this->hasMany(Goal::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function visitors(){
        return $this->hasMany(Visitor::class, 'state_id');
    }

    /*Relacion inversa Lista*/
    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'state_id');
    }

}
