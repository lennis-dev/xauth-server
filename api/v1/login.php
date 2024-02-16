<?php

require_once __DIR__ . "/../../core/Request.php";
require_once __DIR__ . "/../../core/Request/Login.php";


use \LennisDev\XAuth\Request;
use \LennisDev\XAuth\Request\Login;

$request = new Request();
Login::exec($request);
