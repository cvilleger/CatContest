<?php
session_start();

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/../');
define('PATH_WEB', $_SERVER['DOCUMENT_ROOT']);
define('PATH_SERVICE', PATH_ROOT . 'service/');

if( $_SERVER['HTTP_HOST'] === 'localhost' ){

    // Website Configuration
    define('WEBSITE_TITLE', 'CatContest Dev');

    // Facebook
    define('FB_APPID', '833099383411238');
    define('FB_APPSECRET', 'b2ebce8739519354843579e32ccc271b');
    define('WEBURL', 'http://localhost/');

    // Database
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'catcontest');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

} else {

    // Website Configuration
    define('WEBSITE_TITLE', 'CatContest - Le concours de photo de chat');

    // Facebook
    define('FB_APPID', '831785973542579');
    define('FB_APPSECRET', '0367e48eef2d81d799bfbaa97570715f');
    define('WEBURL', 'https://catcontest.herokuapp.com/');

    // Database
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    define('DB_TYPE', 'mysql');
    define('DB_HOST', $url["host"]);
    define('DB_NAME', substr($url["path"], 1));
    define('DB_USERNAME', $url["user"]);
    define('DB_PASSWORD', $url["pass"]);
}

require_once PATH_ROOT . 'vendor/autoload.php';
require_once PATH_SERVICE . 'FacebookAuthService.php';
