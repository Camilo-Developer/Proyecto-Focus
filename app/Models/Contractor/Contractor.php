<?php

namespace App\Models\Contractor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $table = 'contractors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'phone',
        'nit',
        'address',
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

    /*Relacion inversa Lista*/
    public function contractoremployees(){
        return $this->hasMany('App\Models\ContractorEmployee\Contractoremployee', 'contractor_id');
    }
}
