<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip CV din baza de date
class CV extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'cv';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_user',
        'cv_name',
        'display_name',
        'email_contact',
        'phone',
        'adress',
        'country',
        'name'
    ];
}
