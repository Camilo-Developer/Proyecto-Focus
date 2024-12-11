<?php

namespace App\Models\Vehicle;

use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'plate',
        'state_id',
        'visitor_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion directa Lista*/
    public function visitor(){
        return $this->belongsTo('App\Models\Visitor\Visitor', 'visitor_id');
    }

    /*Relacion de muchos a muchos*/
    public function units(){
        return $this->belongsToMany(Unit::class);
    }
}
