<?php

namespace App\Middlewares;

use App\App;
use App\Models\AuthToken;


class ApiMiddleware extends App{
    public function __invoke($request, $response, $next){
        //verific daca headerul de Authorization este setat in request
        if(sizeof($request->getHeader("Authorization")) > 0){

            //daca este il preiau
            $headerResult = $request->getHeader("Authorization")[0];

            //preiau valoarea intreaga in formatul Bearer <key> si il fac array
            $arr = explode(" ", $headerResult);
            
            //verific daca site-ul array-ului este oke si 
            //ca s-a trimis Bearer ca si inceput de header
            if(sizeof($arr) != 2 || $arr[0] != 'Bearer'){

                //daca nu s-a trimis ii returnez mesaj de unauthorized
                return $response->withJson([
                    "status" => 401,
                    "error_message" => "Unauthorized"
                ], 401);
            }

            //preiau key-ul si il verific in baza de date
            $apikey = $arr[1];
            $result = AuthToken::where("key","=", $apikey)->first();

            if(!is_null($result)){

                //verific si timp-ul key-ul sa vad daca o expirat
                if(time() - strtotime($result->created_at) > $this->settings['token_expiry']){
                    return $response->withJson([
                        "status" => 401,
                        "error_message" => "Unauthorized"
                    ], 401);
                }
                else{
                    //daca este oke atunci trec mai departe sa execut
                    //codul din controller
                    return $next($request, $response);
                }
            }
            else{
                return $response->withJson([
                    "status" => 401,
                    "error_message" => "Unauthorized"
                ], 401);
            }
        }

        return $response->withJson([
            "status" => 401,
            "error_message" => "Unauthorized"
        ], 401);
    }
}