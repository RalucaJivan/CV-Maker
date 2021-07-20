<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip Skills din baza de date
class Skills extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'skills';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_cv',
        'skill_name',
        'description',
        'skill_type'
    ];
}
