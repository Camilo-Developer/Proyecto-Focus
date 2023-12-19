<?php

namespace App\Models\Unit;

use App\Models\User;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'state_id',
        'agglomeration_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion directa Lista*/
    public function agglomeration(){
        return $this->belongsTo('App\Models\Agglomeration\Agglomeration', 'agglomeration_id');
    }

    /*Relacion inversa Lista*/
    public function visitorentries(){
        return $this->hasMany('App\Models\VisitorEntry\Visitorentry', 'unit_id');
    }


    /*Relacion de muchos a muchos*/
    public function users(){
        return $this->belongsToMany(User::class);
    }

    /*Relacion de muchos a muchos*/
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class);
    }

}
