<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Experience;

class ApiExperienceController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        
        //preiau id-urile trimise ca si parametru prin link
        // /api/experience/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $experience_id = $args['id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$cv_id)->first();

        //verific daca exista cv-ul cu id-ul respectiv;
        if(is_null($cvObject)){
            //obiectul cv este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "CV id invalid",
                'status' => 400
            ], 400);
        }

        //caut in baza de date informatia despre experienta cu id-ul respectiv
        $experienceObject = Experience::where('pk_id','=',$experience_id)->first();
        
        //verific daca experienceObject este null
        if(is_null($experienceObject)){
            //experienceObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Experience id invalid",
                'status' => 400
            ], 400);
        }

        //returnez cu success obiectul cerut
        return $response->withJson($experienceObject, 200);
    }

    public function getAllAction($request, $response, $args){
        //preiau id-ul cv-ului
        $cv_id = $args['cv_id'];
        
        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$cv_id)->first();

        //verific daca exista cv-ul cu id-ul respectiv;
        if(is_null($cvObject)){
            //obiectul cv este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "CV id invalid",
                'status' => 400
            ], 400);
        }

        //returnez lista de informatii gasite in baza de date
        return $response->withJson(Experience::where('fk_cv','=',$cv_id)->get());
    }

    public function createAction($request, $response, $args){
        //preiau id-ul cv-ului
        $cv_id = $args['cv_id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$cv_id)->first();

        //verific daca exista cv-ul cu id-ul respectiv;
        if(is_null($cvObject)){
            //obiectul cv este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "CV id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['company_name']) ||
            !isset($parsedBody['adress']) ||
            !isset($parsedBody['start_year']) ||
            !isset($parsedBody['end_year']) ||
            !isset($parsedBody['position'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //inseram informatiile despre experienta in baza de date si preluam informatia
        //creata intr-o variabila
        $createdExperience = Experience::create([
            'fk_cv' => $cv_id,
            'company_name' => $parsedBody['company_name'],
            'adress' => $parsedBody['adress'],
            'start_year' => $parsedBody['start_year'],
            'end_year' => $parsedBody['end_year'],
            'job_position' => $parsedBody['position']
        ]);

        //returnam informatia creata ca si raspuns la request
        return $response->withJson($createdExperience, 200);

    }

    public function editAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/experience/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $experience_id = $args['id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$cv_id)->first();

        //verific daca exista cv-ul cu id-ul respectiv;
        if(is_null($cvObject)){
            //obiectul cv este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "CV id invalid",
                'status' => 400
            ], 400);
        }

        //caut in baza de date informatia despre experienta cu id-ul respectiv
        $experienceObject = Experience::where('pk_id','=',$experience_id)->first();
        
        //verific daca experienceObject este null
        if(is_null($experienceObject)){
            //experienceObject este null, deci returnez mesaj de eroare
            return $experienceObject->withJson([
                'message' => "Experience id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['company_name']) ||
            !isset($parsedBody['adress']) ||
            !isset($parsedBody['start_year']) ||
            !isset($parsedBody['end_year']) ||
            !isset($parsedBody['position'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //preiau datele si fac update-ul in baza de date
        Experience::where('pk_id','=',$experience_id)->update([
            'company_name' => $parsedBody['company_name'],
            'adress' => $parsedBody['adress'],
            'start_year' => $parsedBody['start_year'],
            'end_year' => $parsedBody['end_year'],
            'job_position' => $parsedBody['position']
        ]);

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Update success",
            "status" => 200
        ], 200);
    }

    public function deleteAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/experience/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $experience_id = $args['id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$cv_id)->first();

        //verific daca exista cv-ul cu id-ul respectiv;
        if(is_null($cvObject)){
            //obiectul cv este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "CV id invalid",
                'status' => 400
            ], 400);
        }

        //caut in baza de date informatia despre experienta cu id-ul respectiv
        $experienceObject = Experience::where('pk_id','=',$experience_id)->first();
        
        //verific daca experienceObject este null
        if(is_null($experienceObject)){
            //experienceObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Experience id invalid",
                'status' => 400
            ], 400);
        }

        //sterg din baza de date
        Experience::where('pk_id','=',$experience_id)->delete();

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Delete success",
            "status" => 200
        ], 200);
    }
}