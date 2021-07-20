<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip Experience din baza de date
class Experience extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'experience';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_cv',
        'company_name',
        'adress',
        'start_year',
        'end_year',
        'job_position'
    ];
}
