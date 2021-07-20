<?php

//Initializare controllere in containerul aplicatiei

$container['HomeController'] = function ($c) {
    return new \App\Controllers\HomeController($c);
};

$container['SetupController'] = function ($c) {
    return new \App\Controllers\SetupController($c);
};

$container['ApiAccountController'] = function ($c) {
    return new \App\Controllers\API\ApiAccountController($c);
};

$container['ApiCVController'] = function ($c) {
    return new \App\Controllers\API\ApiCVController($c);
};

$container['ApiEducationController'] = function ($c) {
    return new \App\Controllers\API\ApiEducationController($c);
};

$container['ApiExperienceController'] = function ($c) {
    return new \App\Controllers\API\ApiExperienceController($c);
};

$container['ApiInterestsController'] = function ($c) {
    return new \App\Controllers\API\ApiInterestsController($c);
};

$container['ApiObjectiveController'] = function ($c) {
    return new \App\Controllers\API\ApiObjectiveController($c);
};

$container['ApiStatementController'] = function ($c) {
    return new \App\Controllers\API\ApiStatementController($c);
};

$container['ApiSkillController'] = function ($c) {
    return new \App\Controllers\API\ApiSkillController($c);
};
