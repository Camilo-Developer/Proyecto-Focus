<?php

namespace App\Models\ElementEntry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elemententry extends Model
{
    use HasFactory;

    protected $table = 'elemententries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admission_date',
        'departure_date',
        'note',
        'element_id',
    ];

    /*Relacion directa Lista*/
    public function element(){
        return $this->belongsTo('App\Models\Element\Element', 'element_id');
    }
}
