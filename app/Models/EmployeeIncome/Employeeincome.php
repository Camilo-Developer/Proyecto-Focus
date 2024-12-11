<?php

namespace App\Models\EmployeeIncome;

use App\Models\Element\Element;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeeincome extends Model
{
    use HasFactory;

    protected $table = 'employeeincomes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admission_date',
        'departure_date',
        'nota',
        'visitor_id',
    ];

    /*Relacion directa Lista*/
    public function visitor(){
        return $this->belongsTo('App\Models\Visitor\Visitor', 'visitor_id');
    }
    /*Relacion de muchos a muchos*/
    public function elements(){
        return $this->belongsToMany(Element::class);
    }
}
