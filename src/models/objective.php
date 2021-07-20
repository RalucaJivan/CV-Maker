<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip Objective din baza de date
class Objective extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'objective';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_cv',
        'position',
        'time',
        'company',
        'domain'
    ];
}
