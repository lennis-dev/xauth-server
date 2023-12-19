<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/core/UI.php";
require_once __DIR__ . "/core/Config.php";

use LennisDev\XAuth\UI;

if ($_SERVER["REQUEST_URI"] == "/register") {
    $ui = new UI([
        "title" => "XAuth - Register",
        "description" => "XAuth is a simple authentication system for your website."
    ], UI::$REGISTER_PAGE);
    exit;
} else if ($_SERVER["REQUEST_URI"] == "/authorize") {
    $ui = new UI([
        "title" => "XAuth - Authorize",
        "description" => "XAuth is a simple authentication system for your website."
    ], UI::$AUTHORIZE_PAGE);
    exit;
} else if ($_SERVER["REQUEST_URI"] == "/login") {
    $ui = new UI([
        "title" => "XAuth - Login",
        "description" => "XAuth is a simple authentication system for your website."
    ], UI::$LOGIN_PAGE);
    exit;
}
