<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Interests;

class ApiInterestsController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        
        //preiau id-urile trimise ca si parametru prin link
        // /api/interests/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $interest_id = $args['id'];

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

        //caut in baza de date informatia despre interestul cu id-ul respectiv
        $interestObject = Interests::where('pk_id','=',$interest_id)->first();
        
        //verific daca interestObject este null
        if(is_null($interestObject)){
            //interestObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Interest id invalid",
                'status' => 400
            ], 400);
        }

        //returnez cu success obiectul cerut
        return $response->withJson($interestObject, 200);
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
        return $response->withJson(Interests::where('fk_cv','=',$cv_id)->get());
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
        if(!isset($parsedBody['interest_name']) ||
            !isset($parsedBody['description'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //inseram informatiile despre interese in baza de date si preluam informatia
        //creata intr-o variabila
        $createdInterest = Interests::create([
            'fk_cv' => $cv_id,
            'interest_name' => $parsedBody['interest_name'],
            'description' => $parsedBody['description']
        ]);

        //returnam informatia creata ca si raspuns la request
        return $response->withJson($createdInterest, 200);

    }

    public function editAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/interests/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $interest_id = $args['id'];

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

        //caut in baza de date informatia despre interes cu id-ul respectiv
        $interestObject = Interests::where('pk_id','=',$interest_id)->first();
        
        //verific daca interestObject este null
        if(is_null($interestObject)){
            //interestObject este null, deci returnez mesaj de eroare
            return $interestObject->withJson([
                'message' => "Interest id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['interest_name']) ||
            !isset($parsedBody['description'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //preiau datele si fac update-ul in baza de date
        Interests::where('pk_id','=',$interest_id)->update([
            'interest_name' => $parsedBody['interest_name'],
            'description' => $parsedBody['description']
        ]);

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Update success",
            "status" => 200
        ], 200);
    }

    public function deleteAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/interest/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $interest_id = $args['id'];

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
        $interestObject = Interests::where('pk_id','=',$interest_id)->first();
        
        //verific daca interestObject este null
        if(is_null($interestObject)){
            //interestObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Interest id invalid",
                'status' => 400
            ], 400);
        }

        //sterg din baza de date
        Interests::where('pk_id','=',$interest_id)->delete();

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Delete success",
            "status" => 200
        ], 200);
    }
}