<?php

namespace App\Models\SetResidencial;

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
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function agglomerations(){
        return $this->hasMany('App\Models\Agglomeration\Agglomeration', 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function goals(){
        return $this->hasMany('App\Models\Goal\Goal', 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function contractors(){
        return $this->hasMany('App\Models\Contractor\Contractor', 'setresidencial_id');
    }

    /*Relacion inversa Lista*/
    public function shifts(){
        return $this->hasMany('App\Models\Shifts\Shifts', 'setresidencial_id');
    }

}
