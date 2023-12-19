<?php

namespace App\Models\Visitor;

use App\Models\VisitorEntry\Visitorentry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'lastname',
    ];

    /*Relacion de muchos a muchos*/
    public function visitorentries(){
        return $this->belongsToMany(Visitorentry::class);
    }
}
