<?php

namespace App\Models\Shifts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    use HasFactory;

    protected $table = 'shifts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
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

}
