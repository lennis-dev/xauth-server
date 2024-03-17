<?php

require_once __DIR__ . "/../../core/Request.php";
require_once __DIR__ . "/../../core/Request/Register.php";


use \LennisDev\XAuth\Request;
use \LennisDev\XAuth\Request\Register;

$request = new Request();
Register::exec($request);
