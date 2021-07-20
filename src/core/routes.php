<?php

$app->get('/setup', "SetupController:generateSchema");

$app->get("/", "HomeController:index")->setName("home");
$app->group("/account", function () use($app){
    $app->get("/login", "HomeController:login")->setName("login");
    $app->get("/register", "HomeController:register")->setName("register");
});

$app->group("/builder", function () use($app){
    $app->get("", "HomeController:builder");
    $app->get("/list", "HomeController:builderList");
    $app->get('/view/{id}', "HomeController:builderView");

    $app->group("/edit", function() use($app){
        $app->get("/basic/{id}", "HomeController:builderEditBasic");
        $app->get('/education/{id}', "HomeController:builderEditEducation");
        $app->get('/experience/{id}', "HomeController:builderEditExperience");
        $app->get('/objective/{id}', "HomeController:builderEditObjective");
        $app->get('/skills/{id}', "HomeController:skillsEdit");
        $app->get('/aboutyou/{id}', "HomeController:aboutyouEdit");
    });
});

//rutele pentru API
$app->group("/api", function () use($app){

    //rutele pentru logare si register
    $app->group("/account", function () use($app){
        $app->post('/login', "ApiAccountController:loginAction");
        $app->post('/register', "ApiAccountController:registerAction");
    });

    //rutele pentru cv_builder
    $app->group('/cv', function () use($app){
        $app->get('/get/{id}', "ApiCVController:getAction"); //returneaza informatiile generale despre cv-ul cu id-ul trimis ca si parametru
        $app->get('/getall', "ApiCVController:getAllAction"); //returneaza toate cv-urile din baza de date 
        $app->post('/create', "ApiCVController:createAction"); //ruta care creaza baza unui cv
        $app->put('/edit/{id}', "ApiCVController:editAction"); //ruta care editeaza un cv bazat pe id-ul trimis ca si parametru
        $app->delete('/delete/{id}', "ApiCVController:deleteACtion"); //ruta care sterge un cv 
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

    $app->group('/education', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiEducationController:getAction"); //returneaza informatia despre educatie cu id-ul {id} din cv-ul cu id-ul {cv_id}
        $app->get('/get/{cv_id}', "ApiEducationController:getAllAction"); //returneaza toate informatiile despre educatie care corespund cv-ului cu id-ul {cv_id}
        $app->post('/create/{cv_id}', "ApiEducationController:createAction"); //creaza o informatie despre educatie
        $app->put('/edit/{cv_id}/{id}', "ApiEducationController:editAction"); //editeaza informatia despre educatie cu id-ul {id} corespunzatoare cv-ului cu id-ul {cv_id}
        $app->delete('/delete/{cv_id}/{id}', "ApiEducationController:deleteAction"); //sterge informatia despre educatie corespunzatoare id-ului {id} din cv-ul cu id-ul {cv_id}
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

    
    $app->group('/experience', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiExperienceController:getAction");
        $app->get('/get/{cv_id}', "ApiExperienceController:getAllAction");
        $app->post('/create/{cv_id}', "ApiExperienceController:createAction");
        $app->put('/edit/{cv_id}/{id}', "ApiExperienceController:editAction");
        $app->delete('/delete/{cv_id}/{id}', "ApiExperienceController:deleteAction");
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

   
    $app->group('/interests', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiInterestsController:getAction");
        $app->get('/getAll/{cv_id}', "ApiInterestsController:getAllAction");
        $app->post('/create/{cv_id}', "ApiInterestsController:createAction");
        $app->put('/edit/{cv_id}/{id}', "ApiInterestsController:editAction");
        $app->delete('/delete/{cv_id}/{id}', "ApiInterestsController:deleteAction");
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

   
    $app->group('/objective', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiObjectiveController:getAction");
        $app->get('/get/{cv_id}', "ApiObjectiveController:getAllAction");
        $app->post('/create/{cv_id}', "ApiObjectiveController:createAction");
        $app->put('/edit/{cv_id}/{id}', "ApiObjectiveController:editAction");
        $app->delete('/delete/{cv_id}/{id}', "ApiObjectiveController:deleteAction");
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

    
    $app->group('/statement', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiStatementController:getAction");
        $app->get('/get/{cv_id}', "ApiStatementController:getAllAction");
        $app->post('/create/{cv_id}', "ApiStatementController:createAction");
        $app->put('/edit/{cv_id}/{id}', "ApiStatementController:editAction");
        $app->delete('/delete/{cv_id}/{id}', "ApiStatementController:deleteAction");
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

    
    $app->group('/skills', function() use($app){
        $app->get("/get/{cv_id}/{id}", "ApiSkillController:getAction");
        $app->get('/get/{cv_id}', "ApiSkillController:getAllAction");
        $app->post('/create/{cv_id}', "ApiSkillController:createAction");
        $app->put('/edit/{cv_id}/{id}', "ApiSkillController:editAction");
        $app->delete('/delete/{cv_id}/{id}', "ApiSkillController:deleteAction");
    })->add(new \App\Middlewares\ApiMiddleware($app->getContainer()));

});