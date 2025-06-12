<?php

namespace App\Models\ExitEntry;

use App\Models\Element\Element;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Goal\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitEntry extends Model
{
    use HasFactory;

    protected $table = 'exit_entries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_date',
        'nota',
        'goal_id',
        'user_id',
        'employeeincome_id',
    ];

    /*Relacion directa Lista*/
    public function goal(){
        return $this->belongsTo(Goal::class, 'goal_id');
    }

    /*Relacion directa Lista*/
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /*Relacion directa Lista*/
    public function employeeincome(){
        return $this->belongsTo(Employeeincome::class, 'employeeincome_id');
    }

    /*Relacion de muchos a muchos*/
    public function elements(){
        return $this->belongsToMany(Element::class,'exit_entry_has_element')->withPivot('id','imagen', 'nota');
    }
}
