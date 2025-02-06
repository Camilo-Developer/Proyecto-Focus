<?php

namespace App\Models\Vehicle;

use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Unit\Unit;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'placa',
        'state_id',
        'setresidencial_id'
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }
    /*Relacion directa Lista*/
    public function setresidencial(){
        return $this->belongsTo(Setresidencial::class, 'setresidencial_id');
    }

    /*Relacion de muchos a muchos*/
    public function units(){
        return $this->belongsToMany(Unit::class,'unit_has_vehicle');
    }

    /*Relacion de muchos a muchos*/
    public function visitors(){
        return $this->belongsToMany(Visitor::class,'vehicle_has_visitor');
    }
}
