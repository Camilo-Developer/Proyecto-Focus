<?php

namespace App\Models\Agglomeration;

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
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion directa Lista*/
    public function setresidencial(){
        return $this->belongsTo('App\Models\SetResidencial\Setresidencial', 'setresidencial_id');
    }

    /*Relacion Inversa Lista*/
    public function units(){
        return $this->hasMany('App\Models\Unit\Unit', 'agglomeration_id');
    }
}
