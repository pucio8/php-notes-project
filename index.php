<?php

declare( strict_types = 1 );

spl_autoload_register(function ($className) {
    $path = "src/$className.php";
    $path = str_replace(['App\\','\\'],['','/'],$path);
    require_once($path);
});

require_once('src/Utils/debug.php');

use App\Request;
use App\Exception\AppException;
use App\Controller\AbstractController;
use App\Controller\NoteController;

$configuration = require_once('config/config.php');
$request = new Request($_GET, $_POST,$_SERVER);


try {    
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();   
} catch (AppException $e){
    echo '<h1>'.'Wystąpił błąd w Aplikacji'.'</h1>';
    echo '<h3>'. 'Spróbuj pożniej'.'</h3>';
    echo $e->getMessage();
    dump($e);
} catch (\Throwable $e) {
    echo '<h1>'.'Wystąpił błąd w Aplikacji'.'</h1>';
    dump($e);
}