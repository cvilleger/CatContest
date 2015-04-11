<?php
error_reporting(E_ALL);
ini_set("display_error",1);

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . '..');
define('PATH_WEB', $_SERVER['DOCUMENT_ROOT']);
define('PATH_CONTROLLER', $_SERVER['DOCUMENT_ROOT'] . '../controller');
define('PATH_MODEL', $_SERVER['DOCUMENT_ROOT'] . '../model');
define('PATH_SERVICE', $_SERVER['DOCUMENT_ROOT'] . '../service');;

require_once PATH_ROOT . '/vendor/autoload.php';

define('FB_APPID', '831785973542579');
define('FB_APPSECRET', '0367e48eef2d81d799bfbaa97570715f');
define('WEBURL','https://catcontest.herokuapp.com/');

session_start();
