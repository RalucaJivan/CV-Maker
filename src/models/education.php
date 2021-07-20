<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip Education din baza de date
class Education extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'education';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_cv',
        'school_name',
        'adress',
        'start_year',
        'end_year',
        'section'
    ];
}
