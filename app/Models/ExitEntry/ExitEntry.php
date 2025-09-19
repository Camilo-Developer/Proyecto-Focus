<?php

namespace App\Models\ExitEntry;

use App\Models\Element\Element;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Goal\Goal;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitEntry extends Model
{
    use HasFactory;

    protected $table = 'exit_entries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_income',
        'departure_date',
        'nota',
        'goal_id',
        'user_id',
        'employeeincome_id',
        'employeeincomevehicle_id',
        'visitor_id',
        'vehicle_id',
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
    public function visitor(){
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }

    /*Relacion directa Lista*/
    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /*Relacion directa Lista*/
    public function employeeincome(){
        return $this->belongsTo(Employeeincome::class, 'employeeincome_id');
    }

    /*Relacion directa Lista*/
    public function employeeincomevehcile(){
        return $this->belongsTo(Employeeincome::class, 'employeeincomevehicle_id');
    }

    /*Relacion de muchos a muchos*/
    public function elements(){
        return $this->belongsToMany(Element::class,'exit_entry_has_element')->withPivot('id','imagen', 'nota');
    }


    /*Relacion de muchos a muchos*/
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class,'exit_entries_has_vehicles_has_visitors')->withPivot('id','visitor_id');
    }

    /*Relacion de muchos a muchos*/
    public function visitors(){
        return $this->belongsToMany(Visitor::class,'exit_entries_has_vehicles_has_visitors')->withPivot('id','vehicle_id');
    }
}
