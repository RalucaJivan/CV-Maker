<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Statement;

class ApiStatementController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        
        //preiau id-urile trimise ca si parametru prin link
        // /api/statement/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $statement_id = $args['id'];

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

        //caut in baza de date informatia despre statementul cu id-ul respectiv
        $statementObject = Statement::where('pk_id','=',$statement_id)->first();
        
        //verific daca statementObject este null
        if(is_null($statementObject)){
            //statementObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Statement id invalid",
                'status' => 400
            ], 400);
        }

        //returnez cu success obiectul cerut
        return $response->withJson($statementObject, 200);
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
        return $response->withJson(Statement::where('fk_cv','=',$cv_id)->get());
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
        if(!isset($parsedBody['statement_text'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //inseram informatiile despre interese in baza de date si preluam informatia
        //creata intr-o variabila
        $createdStatement = Statement::create([
            'fk_cv' => $cv_id,
            'statement_text' => $parsedBody['statement_text']
        ]);

        //returnam informatia creata ca si raspuns la request
        return $response->withJson($createdStatement, 200);

    }

    public function editAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/statement/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $statement_id = $args['id'];

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
        $statementObject = Statement::where('pk_id','=',$statement_id)->first();
        
        //verific daca statementObject este null
        if(is_null($statementObject)){
            //statementObject este null, deci returnez mesaj de eroare
            return $statementObject->withJson([
                'message' => "Statement id invalid",
                'status' => 400
            ], 400);
        }

        //salvez informatiile din body in variabila locala $parsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca toate informatile sunt trimise prin body
        if(!isset($parsedBody['statement_text'])){
            
            //una dintre informatii nu a fost trimisa deci returnam eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //preiau datele si fac update-ul in baza de date
        Statement::where('pk_id','=',$statement_id)->update([
            'statement_text' => $parsedBody['statement_text']
        ]);

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Update success",
            "status" => 200
        ], 200);
    }

    public function deleteAction($request, $response, $args){
        //preiau id-urile trimise ca si parametru prin link
        // /api/statement/{cv_id}/{id}
        $cv_id = $args['cv_id'];
        $statement_id = $args['id'];

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
        $statementObject = Statement::where('pk_id','=',$statement_id)->first();
        
        //verific daca statementObject este null
        if(is_null($statementObject)){
            //statementObject este null, deci returnez mesaj de eroare
            return $response->withJson([
                'message' => "Statement id invalid",
                'status' => 400
            ], 400);
        }

        //sterg din baza de date
        Statement::where('pk_id','=',$statement_id)->delete();

        //returnez mesajul de success
        return $response->withJson([
            "message" => "Delete success",
            "status" => 200
        ], 200);
    }
}