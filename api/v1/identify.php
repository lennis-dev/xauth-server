<?php

namespace LennisDev\XAuth;

require_once '../../core/Request.php';
require_once '../../core/Request/Identify.php';

use LennisDev\XAuth\Request;
use LennisDev\XAuth\Request\Identify;

$request = new Request();
Identify::exec($request);
