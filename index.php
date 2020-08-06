<?php
/**
* @authors  Gabriel Nativel-Fontaine
* @creation 08/06/2020
* @update   08/06/2020
*/

// Initialize session for a day
session_start(['cookie_lifetime' => 86400]);

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'src/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderUtils;

function load_class($class) {
    if(preg_match('#Controller#', $class)) {
        require_once('src/controllers/'. $class .'.php');
    }
    else if(preg_match('#Model#', $class)) {
        require_once('src/models/'. $class .'.php');
    }
    else if(preg_match('#View#', $class)) {
        require_once('src/views/'. $class .'.php');
    }
    else {
        if($class == 'Router' || $class == 'Film')
            require_once('src/class/'. $class .'.php');
        else
            require 'src/vendor/autoload.php';
    }
}
spl_autoload_register('load_class');

$request = Request::createFromGlobals();

$router = new Router($request);
define('ROOT', $request->getBasePath() . '/');

$router->Route($request->getPathInfo());
