<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

//model pentru a utiliza obiectele de tip User din baza de date
class User extends Model
{
    //se seteaza pe true daca coloanele created_at si updated_at trebuie folosite
    public $timestamps = false;
    
    //numele tabelei
    protected $table = 'user';
    
    //lista de coloane
    protected $fillable = [
        'pk_id',
        'username',
        'email',
        'password'
    ];
}
