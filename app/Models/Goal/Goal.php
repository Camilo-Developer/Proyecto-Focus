<?php

namespace App\Models\Goal;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';
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

    /*Relacion de muchos a muchos*/
    public function users(){
        return $this->belongsToMany(User::class,'user_has_goal');
    }
}
