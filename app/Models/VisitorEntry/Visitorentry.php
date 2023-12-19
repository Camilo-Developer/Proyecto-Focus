<?php

namespace App\Models\VisitorEntry;

use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitorentry extends Model
{
    use HasFactory;

    protected $table = 'visitorentries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admission_date',
        'departure_date',
        'visit_type',
        'note',
        'unit_id',
        'state_id',
    ];

    /*Relacion directa Lista*/
    public function unit(){
        return $this->belongsTo('App\Models\Unit\Unit', 'unit_id');
    }

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }

    /*Relacion de muchos a muchos*/
    public function visitors(){
        return $this->belongsToMany(Visitor::class);
    }
}
