<?php

namespace LennisDev\XAuth;

require_once '../../core/Request.php';

use LennisDev\XAuth\Request;

$request = new Request();
$request->identify();
