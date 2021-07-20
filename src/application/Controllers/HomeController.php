<?php

namespace App\Controllers;

use App\App;

class HomeController extends App
{
    public function index($request, $response, $args){
        //returnam page ca sa stie partea de front-end pe ce pagina ne aflam
        return $this->view->render($response, "home/index.twig", ["page" => "index"]);
    }

    public function register($request, $response, $args)
    {
        return $this->view->render($response, "account/register.twig", ["page" => "register"]);
    }

    public function login($request, $response, $args)
    {
        return $this->view->render($response, "account/login.twig", ["page" => "login"]);
    }

    public function builder($request, $response, $args){
        return $this->view->render($response, "builder/index.twig", ["page" => "builder"]);
    }

    public function builderList($request, $response, $args){
        return $this->view->render($response, "builder/list.twig", ["page" => "builder/list"]);
    }

    public function builderView($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/view.twig", ["page" => "builder/view", "id" => $id]);
    }

    public function builderEditBasic($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/editBasic.twig", ["page" => "builder/editBasic", "id" => $id]); 
    }

    
    public function builderEditEducation($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/editEducation.twig", ["page" => "builder/editEducation", "id" => $id]); 
    }

    public function builderEditExperience($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/editExperience.twig", ["page" => "builder/editExperience", "id" => $id]); 
    }

    public function builderEditObjective($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/editObjective.twig", ["page" => "builder/editObjective", "id" => $id]); 
    }

    public function aboutyouEdit($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/aboutyouEdit.twig", ["page" => "builder/aboutyouEdit", "id" => $id]); 
    }

    public function skillsEdit($request, $response, $args){
        $id = $args['id'];
        return $this->view->render($response, "builder/skillsEdit.twig", ["page" => "builder/skillsEdit", "id" => $id]); 
    }
}