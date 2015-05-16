<?php
require_once '../Bootstrap.php' ;
$FacebookAuthService = new FacebookAuthService();
$loginUrl = $FacebookAuthService->getSimpleLoginUrl();
header("location: $loginUrl" );