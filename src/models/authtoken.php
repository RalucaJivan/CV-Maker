<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip AuthToken din baza de date
class AuthToken extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = true;
    
    //numele tabelei
    protected $table = 'authtoken';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'fk_user',
        'key',
        'created_at',
        'updated_at'
    ];
}
