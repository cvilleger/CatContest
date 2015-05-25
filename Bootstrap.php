<?php

error_reporting(E_ALL);
ini_set("display_error",1);
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

    // Database
    /*
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'catcontest');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    */

    define('DB_TYPE', 'pgsql');
    define('DB_HOST', 'ec2-184-73-254-144.compute-1.amazonaws.com');
    define('DB_NAME', 'd2v1v9s59qbq66');
    define('DB_USERNAME', 'xjzkvstydxdowf');
    define('DB_PASSWORD', 'jT6bxwXWoee69wtN0MlE2_j2jb');


} else {
    define('FB_APPID', '831785973542579');
    define('FB_APPSECRET', '0367e48eef2d81d799bfbaa97570715f');
    define('WEBURL','https://catcontest.herokuapp.com/');
    define('DB_TYPE', 'pgsql');
    define('DB_HOST', 'ec2-184-73-254-144.compute-1.amazonaws.com');
    define('DB_NAME', 'd2v1v9s59qbq66');
    define('DB_USERNAME', 'xjzkvstydxdowf');
    define('DB_PASSWORD', 'jT6bxwXWoee69wtN0MlE2_j2jb');
}

require_once PATH_ROOT . '/vendor/autoload.php';

/**
 * Autoloader 5.3+
 */
spl_autoload_register(function ($class) {
    $pregRes = preg_split('/([A-Z][^A-Z]*)/', $class, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); ///Split camelcase: if $class=='MyXMLParsingService' => gives "My X M L Parsing Service"
    $classType = end($pregRes); //return last element of an array
    include PATH_ROOT . '/' . $classType . '/' . $class .'.php';
});