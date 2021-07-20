<?php

namespace App\Controllers\API;

use App\App;
use App\Controllers\API\IApiController;
use App\Models\CV;
use App\Models\User;
use App\Models\AuthToken;

class ApiAccountController extends App 
{
    public function registerAction($request, $response, $args){
        
        //return $response->withJson($request->getParsedBody());

        //astea se intampla cand primesc request 
        $parsedBody = $request->getParsedBody(); 

        //verific daca am datele primite
        if(!isset($parsedBody['username']) || !isset($parsedBody['email']) || 
        !isset($parsedBody['password']) || !isset($parsedBody['confirmPassword'])){
            return $response->withJson(["message" => "Nu sunt toate datele trimise",
                                        "status" => 400], 400);
        }

        $username = $parsedBody['username'];//datele din body intra in arrayul parsedBody
        $email = $parsedBody['email'];
        $password = $parsedBody['password'];
        $confirmPassword = $parsedBody['confirmPassword'];

        // return json_encode([$username, $email, $password, $confirmPassword]); //ca sa am un response

        if ($password != $confirmPassword){
            return $response->withJson(["message" => "Cele 2 parole nu corespund",
                                        "status" => 400], 400);//returnam response de tip json 400 Bad Request
        }

        $userFromDatabase = User::where('email','=',$email)->first();

        if (!is_null($userFromDatabase)){
            return $response->withJson(["message" => "Emailul este deja folosit",
                                        'status' => 400], 400);
        }

        User::create([ //create e de la illumintate din models
            'username' => $username,
            'email' => $email, 
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return $response->withJson(['message' => "Succes",
                                    'status' => 200], 200);
    }

    public function loginAction($request, $response, $args){
        //astea se intampla cand primim request 
        $parsedBody = $request->getParsedBody(); 

        //verificam daca avem datele primite
        if(!isset($parsedBody['email']) || !isset($parsedBody['password'])){
            return $response->withJson(["message" => "Nu sunt toate datele trimise",
                                        'status' => 400], 400);
        }

        $email = $parsedBody['email'];
        $password = $parsedBody['password'];
       
        $userFromDatabase = User::where('email','=',$email)->first();
        if (is_null($userFromDatabase)){
            return $response->withJson(['message'=> "emailul nu exista",
                                        'status' => 400], 400);
        }

        // return $response->withJson($userFromDatabase); toate datele despre userul acesta

        if (!password_verify ( $password , $userFromDatabase->password)){
            return $response->withJson(['message'=> "Parola nu a fost introdusa corect",
                                        'status' => 400] , 400);
        }

        //acuma daca datele sunt corecte, urm sa le bagam in db
        $createdObject = AuthToken::create([ //create e de la laravel din models
            'fk_user' => $userFromDatabase->pk_id, //ce user este asignat la acel key
            'key' => $this->staticMethods->getRandomKey(50)
        ]);

        return $response->withJson(
            [   //returnez mesaj de succes daca token ul a fost creat cu parametrii fk_user si key-ul
                "message" => "Success",
                "key" => $createdObject->key,
                "expiry" => $this->settings['token_expiry'] //configs
            ],200);
    }
}