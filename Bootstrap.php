<?php
session_start();

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/..');
define('PATH_WEB', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PATH_CONTROLLER', $_SERVER['DOCUMENT_ROOT'] . '/../controller');
define('PATH_MODEL', $_SERVER['DOCUMENT_ROOT'] . '/../model');
define('PATH_SERVICE', $_SERVER['DOCUMENT_ROOT'] . '/../service');;

if($_SERVER['HTTP_HOST'] === 'localhost'){

    // Facebook
    define('FB_APPID', '833099383411238');
    define('FB_APPSECRET', 'b2ebce8739519354843579e32ccc271b');
    define('WEBURL','http://localhost/');

    error_reporting(E_ALL);
    ini_set("display_error",1);
} else {
    define('FB_APPID', '831785973542579');
    define('FB_APPSECRET', '0367e48eef2d81d799bfbaa97570715f');
    define('WEBURL','https://catcontest.herokuapp.com/');
}

require_once PATH_ROOT . '/vendor/autoload.php';
require_once PATH_SERVICE . '/FacebookAuthService.php';