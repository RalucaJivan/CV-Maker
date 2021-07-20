<?php

namespace App\Controllers;


use App\App;

class SetupController extends App
{
    public function generateSchema($request, $response, $args){
        $resp = $this->databaseBuilder->createSchema();
        
        if($resp){
            return $response->withJson(['message' => 'Success']);
        }
        else{
            return $response->withJson(['message' => 'Fail']);
        }
    }
}