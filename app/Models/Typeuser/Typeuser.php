<?php

namespace App\Models\Typeuser;

use App\Models\Visitor\Visitor;
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
        return $this->hasMany(Visitor::class, 'type_user_id');
    }
}
