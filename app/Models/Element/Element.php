<?php

namespace App\Models\Element;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $table = 'elements';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'contractoremployee_id',
    ];

    /*Relacion directa Lista*/
    public function contractoremployee(){
        return $this->belongsTo('App\Models\ContractorEmployee\Contractoremployee', 'contractoremployee_id');
    }

    /*Relacion inversa Lista*/
    public function elemententries(){
        return $this->hasMany('App\Models\ElementEntry\Elemententry', 'element_id');
    }
}
