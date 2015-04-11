<?php
error_reporting(E_ALL);
ini_set("display_error",1);

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/..');
define('PATH_WEB', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PATH_CONTROLLER', $_SERVER['DOCUMENT_ROOT'] . '/../controller');
define('PATH_MODEL', $_SERVER['DOCUMENT_ROOT'] . '/../model');
define('PATH_SERVICE', $_SERVER['DOCUMENT_ROOT'] . '/../service');;

require_once PATH_ROOT . '/vendor/autoload.php';

define('FB_APPID', '833099383411238');
define('FB_APPSECRET', 'b2ebce8739519354843579e32ccc271b');
define('WEBURL','https://catcontestdev.herokuapp.com/');

session_start();
