<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Education;

class ApiEducationController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        
        //preiau id-urile trimise ca si parametru prin link
        // /api/education/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $education_id = $args['id'];

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

        //caut in baza de date informatia despre educatie cu id-ul respectiv
        $educationObject = Education::where('pk_id','=',$education_id)->first();
        
        //verific daca educatiobObject este null
        if(is_null($educationObject)){
            //obiectuleducation este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Education id invalid",
                'status' => 400
            ], 400);
        }

        //returnez cu success obiectul cerut
        return $response->withJson($educationObject, 200);
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
        return $response->withJson(Education::where('fk_cv','=',$cv_id)->get());
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
        if(!isset($parsedBody['school_name']) ||
            !isset($parsedBody['adress']) ||
            !isset($parsedBody['start_year']) ||
            !isset($parsedBody['end_year']) ||
            !isset($parsedBody['section'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //inseram informatiile despre educatie in baza de date si preluam informatia
        //creata intr-o variabila
        $createdEducation = Education::create([
            'fk_cv' => $cv_id,
            'school_name' => $parsedBody['school_name'],
            'adress' => $parsedBody['adress'],
            'start_year' => $parsedBody['start_year'],
            'end_year' => $parsedBody['end_year'],
            'section' => $parsedBody['section']
        ]);

        //returnam informatia creata ca si raspuns la request
        return $response->withJson($createdEducation, 200);

    }

    public function editAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/education/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $education_id = $args['id'];

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

        //caut in baza de date informatia despre educatie cu id-ul respectiv
        $educationObject = Education::where('pk_id','=',$education_id)->first();
        
        //verific daca educatiobObject este null
        if(is_null($educationObject)){
            //obiectuleducation este null, deci returnez mesaj de eroare
            return $educationObject->withJson([
                'message' => "Education id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['school_name']) ||
            !isset($parsedBody['adress']) ||
            !isset($parsedBody['start_year']) ||
            !isset($parsedBody['end_year']) ||
            !isset($parsedBody['section'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //preiau datele si fac update-ul in baza de date
        Education::where('pk_id','=',$education_id)->update([
            'school_name' => $parsedBody['school_name'],
            'adress' => $parsedBody['adress'],
            'start_year' => $parsedBody['start_year'],
            'end_year' => $parsedBody['end_year'],
            'section' => $parsedBody['section']
        ]);

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Update success",
            "status" => 200
        ], 200);
    }

    public function deleteAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/education/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $education_id = $args['id'];

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

        //caut in baza de date informatia despre educatie cu id-ul respectiv
        $educationObject = Education::where('pk_id','=',$education_id)->first();
        
        //verific daca educatiobObject este null
        if(is_null($educationObject)){
            //obiectuleducation este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Education id invalid",
                'status' => 400
            ], 400);
        }

        //Stergere din baza de date
        Education::where('pk_id','=',$education_id)->delete();

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Delete success",
            "status" => 200
        ], 200);
    }
}