<?php

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/src/vendor/autoload.php';

session_start();

$settings = require_once __DIR__ . '/src/configs/configs.php';
$app = new \Slim\App($settings);

require_once __DIR__ . '/src/core/init.php';
require_once __DIR__ . '/src/core/controllers.php';
require_once __DIR__ . '/src/core/routes.php';

//importul modelelor
require_once __DIR__ . '/src/models/authtoken.php';
require_once __DIR__ . '/src/models/cv.php';
require_once __DIR__ . '/src/models/education.php';
require_once __DIR__ . '/src/models/experience.php';
require_once __DIR__ . '/src/models/interests.php';
require_once __DIR__ . '/src/models/objective.php';
require_once __DIR__ . '/src/models/skills.php';
require_once __DIR__ . '/src/models/statement.php';
require_once __DIR__ . '/src/models/user.php';

try {
    $app->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
} catch (\Slim\Exception\NotFoundException $e) {
} catch (Exception $e) {
}
