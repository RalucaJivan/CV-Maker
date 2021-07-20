<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Objective;

class ApiObjectiveController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        
        //preiau id-urile trimise ca si parametru prin link
        // /api/objective/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $objective_id = $args['id'];

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

        //caut in baza de date informatia despre obiectivul cu id-ul respectiv
        $objectiveObject = Objective::where('pk_id','=',$objective_id)->first();
        
        //verific daca objectiveObject este null
        if(is_null($objectiveObject)){
            //objectiveObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Objective id invalid",
                'status' => 400
            ], 400);
        }

        //returnez cu success obiectul cerut
        return $response->withJson($objectiveObject, 200);
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
        return $response->withJson(Objective::where('fk_cv','=',$cv_id)->first());
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
        if(!isset($parsedBody['position']) ||
            !isset($parsedBody['time']) || 
            !isset($parsedBody['company']) ||
            !isset($parsedBody['domain'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //inseram informatiile despre obiective in baza de date si preluam informatia
        //creata intr-o variabila
        $createdObjective = Objective::create([
            'fk_cv' => $cv_id,
            'position' => $parsedBody['position'],
            'time' => $parsedBody['time'],
            'company' => $parsedBody['company'],
            'domain' => $parsedBody['domain']
        ]);

        //returnam informatia creata ca si raspuns la request
        return $response->withJson($createdObjective, 200);

    }

    public function editAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/objective/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $objective_id = $args['id'];

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

        //caut in baza de date informatia despre obiectivul cu id-ul respectiv
        $objectiveObject = Objective::where('pk_id','=',$objective_id)->first();
        
        //verific daca objectiveObject este null
        if(is_null($objectiveObject)){
            //objectiveObject este null, deci returnez mesaj de eroare
            return $objectiveObject->withJson([
                'message' => "Objective id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['position']) ||
            !isset($parsedBody['time']) || 
            !isset($parsedBody['company']) ||
            !isset($parsedBody['domain'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //preiau datele si fac update-ul in baza de date
        Objective::where('pk_id','=',$objective_id)->update([
            'position' => $parsedBody['position'],
            'time' => $parsedBody['time'],
            'company' => $parsedBody['company'],
            'domain' => $parsedBody['domain']
        ]);

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Update success",
            "status" => 200
        ], 200);
    }

    public function deleteAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/objective/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $objective_id = $args['id'];

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
        $objectiveObject = Objective::where('pk_id','=',$objective_id)->first();
        
        //verific daca objectiveObject este null
        if(is_null($objectiveObject)){
            //objectiveObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Object id invalid",
                'status' => 400
            ], 400);
        }

        //sterg din baza de date
        Objective::where('pk_id','=',$objective_id)->delete();

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Delete success",
            "status" => 200
        ], 200);
    }
}