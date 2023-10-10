<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/core/UI.php";

use LennisDev\XAuth\UI;

$ui = new UI([
    "title" => "XAuth",
    "description" => "XAuth is a simple authentication system for your website."
], UI::$AUTHORIZE_PAGE);
