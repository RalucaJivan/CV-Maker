<?php

namespace App\Helpers;

use App\App;

class DatabaseBuilder extends App
{

    //functie privata deoarece dorim sa fie accesata doar in interiorul clasei
    private function createUserTable(){

        //verificare daca tabela exista
        if($this->db->schema()->hasTable('User')){
            return;
        }

        //daca tabela nu exista, se creaza cu campurile stabilite in schema
        $this->db->schema()->create('User', function($table){
            $table->increments('pk_id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
        });
    }

    //restul functiilor functioneaza pe aceeasi structura
    private function createAuthTokenTable(){
        if($this->db->schema()->hasTable('AuthToken')){
            return;
        }

        $this->db->schema()->create('AuthToken', function($table){
            $table->increments('pk_id');
            //formatul necesar pentru foreign key
            $table->integer('fk_user')->unsigned()->nullable();
            $table->string('key');
            //functia care genereaza coloanele created_at si updated_at
            $table->timestamps();

            //functie care genereaza foreign key catre tabela user
            $table->foreign('fk_user')
                ->references('pk_id')
                ->on('User');
        });
    }

    private function createCVTable(){
        if($this->db->schema()->hasTable('CV')){
            return;
        }

        $this->db->schema()->create('CV', function($table){
            $table->increments('pk_id');
            $table->integer('fk_user')->unsigned()->nullable();
            $table->string('display_name');
            $table->string('email_contact');
            $table->string('phone');
            $table->string('cv_name');
            $table->string('adress');
            $table->string('country');
            $table->string('name');

            $table->foreign('fk_user')
                ->references('pk_id')
                ->on('User');
        });
    }

    private function createStatementTable(){
        if($this->db->schema()->hasTable('Statement')){
            return;
        }

        $this->db->schema()->create('Statement', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->longText('statement_text');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    private function createExperienceTable(){
        if($this->db->schema()->hasTable('Experience')){
            return;
        }

        $this->db->schema()->create('Experience', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->string('company_name');
            $table->string('adress');
            $table->string('start_year');
            $table->string('end_year');
            $table->string('job_position');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    private function createSkillTable(){
        if($this->db->schema()->hasTable('Skills')){
            return;
        }

        $this->db->schema()->create('Skills', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->string('skill_name');
            $table->string('description');
            $table->string('skill_type');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    private function createObjectiveTable(){
        if($this->db->schema()->hasTable('Objective')){
            return;
        }

        $this->db->schema()->create('Objective', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->string('position');
            $table->string('time');
            $table->string('company');
            $table->string('domain');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    private function createEducationTable(){
        if($this->db->schema()->hasTable('Education')){
            return;
        }

        $this->db->schema()->create('Education', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->string('school_name');
            $table->string('adress');
            $table->string('start_year');
            $table->string('end_year');
            $table->string('section');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    private function createInterestsTable(){
        if($this->db->schema()->hasTable('Interests')){
            return;
        }

        $this->db->schema()->create('Interests', function($table){
            $table->increments('pk_id');
            $table->integer('fk_cv')->unsigned()->nullable();
            $table->string('interest_name');
            $table->string('description');

            $table->foreign('fk_cv')
                ->references('pk_id')
                ->on('CV');
        });
    }

    //functia care genereaza toata schema 
    public function createSchema(){
        $this->createUserTable();
        $this->createAuthTokenTable();
        $this->createCVTable();
        $this->createStatementTable();
        $this->createExperienceTable();
        $this->createSkillTable();
        $this->createObjectiveTable();
        $this->createEducationTable();
        $this->createInterestsTable();

        return true;
    }
}