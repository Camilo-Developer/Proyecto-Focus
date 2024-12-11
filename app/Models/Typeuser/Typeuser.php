<?php

namespace App\Models\Typeuser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeuser extends Model
{
    use HasFactory;

    protected $table = 'type_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

     /*Relacion inversa Lista*/
     public function visitors(){
        return $this->hasMany('App\Models\Visitor\Visitor', 'state_id');
    }
}
