<?php

namespace App\Models\Element;

use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
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
        return $this->belongsToMany(Employeeincome::class,'element_has_employeeincome');
    }

    /*Relacion de muchos a muchos*/
    public function exitentries(){
        return $this->belongsToMany(ExitEntry::class,'exit_entry_has_element');
    }
}
