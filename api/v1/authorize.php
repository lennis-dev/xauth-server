<?php

namespace LennisDev\XAuth;

require_once '../../core/Request.php';
require_once '../../core/Request/Authorize.php';

use LennisDev\XAuth\Request;
use LennisDev\XAuth\Request\Authorize;

$request = new Request();
Authorize::exec($request);
