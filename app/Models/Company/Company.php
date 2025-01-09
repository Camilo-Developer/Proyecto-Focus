<?php

namespace App\Models\Company;

use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

     /*Relacion inversa Lista*/
     public function visitors(){
        return $this->hasMany(Visitor::class, 'company_id');
    }
}
