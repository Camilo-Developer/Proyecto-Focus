<?php

namespace App\Models\Visitor;

use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'document_number',
        'confirmation',
        'imagen',
        'state_id',
        'type_user_id',
        'company_id',
    ];

    /*Relacion directa Lista*/
    public function state(){
        return $this->belongsTo('App\Models\State\State', 'state_id');
    }
    /*Relacion directa Lista*/
    public function typeuser(){
        return $this->belongsTo('App\Models\Typeuser\Typeuser', 'state_id');
    }
    /*Relacion directa Lista*/
    public function company(){
        return $this->belongsTo('App\Models\Company\Company', 'state_id');
    }

    /*Relacion inversa Lista*/
    public function employeeincomes(){
        return $this->hasMany('App\Models\EmployeeIncome\Employeeincome', 'visitor_id');
    }

     /*Relacion inversa Lista*/
     public function vehicles(){
        return $this->hasMany('App\Models\Vehicle\Vehicle', 'visitor_id');
    }

    /*Relacion de muchos a muchos*/
    public function units(){
        return $this->belongsToMany(Unit::class);
    }
}
