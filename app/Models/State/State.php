<?php

namespace App\Models\State;

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
        return $this->hasMany('App\Models\User', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function setresidencials(){
        return $this->hasMany('App\Models\SetResidencial\Setresidencial', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function agglomerations(){
        return $this->hasMany('App\Models\Agglomeration\Agglomeration', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function units(){
        return $this->hasMany('App\Models\Unit\Unit', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function goals(){
        return $this->hasMany('App\Models\Goal\Goal', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function visitorentries(){
        return $this->hasMany('App\Models\VisitorEntry\Visitorentry', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function contractors(){
        return $this->hasMany('App\Models\Contractor\Contractor', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function contractoremployees(){
        return $this->hasMany('App\Models\ContractorEmployee\Contractoremployee', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function vehicles(){
        return $this->hasMany('App\Models\Vehicle\Vehicle', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function shifts(){
        return $this->hasMany('App\Models\Shifts\Shifts', 'state_id');
    }

}
