<?php

namespace App\Models\Element;

use App\Models\EmployeeIncome\Employeeincome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $table = 'elements';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

     /*Relacion de muchos a muchos*/
     public function employeeincomes(){
        return $this->belongsToMany(Employeeincome::class);
    }
}
