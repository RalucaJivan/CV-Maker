<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;

class ApiCVController extends App implements IApiController
{
    public function getAction($request, $response, $args){
        //preiau id-ul din link // /api/cv/get/{id}
        $id = $args['id'];

        
        $apiKey = explode(" ", $request->getHeader("Authorization")[0])[1];

        //preiau id-ul userului din tabela AuthToekn prin fk_user
        //practic fk_user trebuie sa fie la fel ca pk_id din tabela User
        $userId = AuthToken::where('key','=',$apiKey)->first()->fk_user;


        //preiau cv-ul din baza de date
        $cvObject = CV::where([['pk_id','=',$id],['fk_user','=',$userId]])->first();

        //verific daca exista un cv cu id-ul respectiv
        if(is_null($cvObject)){
            //cv-ul este null, deci returnez mesaj de eroare
            return $response->withJson([
                "message" => "Invalid id",
                'status' => 400
            ], 400);
        }

        //returnez cv-ul gasit, daca ajunge aici, 
        //inseamna ca id-ul este valid si exista un cv cu acel id
        return $response->withJson($cvObject, 200);
    }

    public function getAllAction($request, $response, $args){
        //returnez toate CV-urile din baza de date

        $apiKey = explode(" ", $request->getHeader("Authorization")[0])[1];

        //preiau id-ul userului din tabela AuthToekn prin fk_user
        //practic fk_user trebuie sa fie la fel ca pk_id din tabela User
        $userId = AuthToken::where('key','=',$apiKey)->first()->fk_user;

        return $response->withJson(CV::where("fk_user",'=',$userId)->get());
    }

    public function createAction($request, $response, $args){
        //adaug body-ul ca si variabila locala prin metoda getParsedBody
        $parsedBody = $request->getParsedBody();

        //verific daca numele cv-ului a fost trimis prin body
        if(!isset($parsedBody['cv_name'])){

            //numele nu a fost trimis, deci returnez mesaj de eroare
            return $response->withJson([
                "message" => "Invalid data",
                'status' => 400
            ], 400);
        }

        //headerul de authentificare o sa fie Bearer <key>
        //cu functia explode separ in 2 Bearer de <key> si preiau doar <key> care are
        //index-ul 1
        $apiKey = explode(" ", $request->getHeader("Authorization")[0])[1];


        //preiau id-ul userului din tabela AuthToekn prin fk_user
        //fk_user trebuie sa fie la fel ca pk_id din tabela User
        $userId = AuthToken::where('key','=',$apiKey)->first()->fk_user;

        //inserez in baza de date si preiau obiectul inserat ca sa il returnez
        //ca si raspuns
        $returnedObject = CV::create([
            'fk_user' => $userId,
            'display_name' => $parsedBody['cv_name']
        ]);

        //returnez obiectul creat
        return $response->withJson($returnedObject);
    }

    public function editAction($request, $response, $args){
        //adaug body-ul ca si variabila locala prin metoda getParsedBody
        $parsedBody = $request->getParsedBody();

        //verificare daca toate chestiled in body is trimise
        if(!isset($parsedBody['email_contact']) ||
            !isset($parsedBody['phone']) ||
            !isset($parsedBody['adress']) ||
            !isset($parsedBody['contry']) || 
            !isset($parsedBody['name'])){
                
                //nu exista un parametru, deci returnez eroare
                return $response->withJson([
                    "message" => "Invalid data",
                    'status' => 400
                ], 400);
            }

        //preiau id-ul intr-o variabila din parametrii linkului // /api/cv/edit/{id}
        $id = $args['id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$id)->first();

        //verific daca exista un cv cu id-ul respectiv
        if(is_null($cvObject)){
            //cv-ul este null, deci returnez mesaj de eroare
            return $response->withJson([
                "message" => "Invalid id"
            ], 400);
        }

        //actualizez datele
        CV::where('pk_id','=',$id)->update([
            'name' => $parsedBody['name'],
            'email_contact' => $parsedBody['email_contact'],
            'phone' => $parsedBody['phone'],
            'adress' => $parsedBody['adress'],
            'country' => $parsedBody['contry']
        ]);

        //returnez mesaj de success
        return $response->withJson([
            'message' => "Success update",
            'status' => 200
        ], 200);

    }

    public function deleteAction($request, $response, $args){
        //preiau id-ul intr-o variabila din parametrii linkului // /api/cv/edit/{id}
        $id = $args['id'];

        //caut in baza de date cv-ul cu id-ul respectiv
        $cvObject = CV::where('pk_id','=',$id)->first();

        //verific daca exista un cv cu id-ul respectiv
        if(is_null($cvObject)){
            //cv-ul este null, deci returnez mesaj de eroare
            return $response->withJson([
                "message" => "Invalid id"
            ], 400);
        }

        
    }
}