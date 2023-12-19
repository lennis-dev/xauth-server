<?php

namespace LennisDev\XAuth;

require __DIR__ . "/../core/Token.php";
require __DIR__ . "/../core/Request/Login.php";
require __DIR__ . "/../core/Request/Authorize.php";
//require __DIR__ . "/../core/Request/Identify.php";


use \LennisDev\XAuth\Token;
use \LennisDev\XAuth\Request\Login;
use \LennisDev\XAuth\Request\Authorize;
use LennisDev\XAuth\Request\Identify;

class Request
{
    protected array $requestData = [];
    protected bool $active = false;
    protected \LennisDev\XAuth\Token|null $token = null;

    function __construct()
    {
        $this->requestData = json_decode(file_get_contents("php://input"), true);
    }
    function exec($function)
    {
        return $function($this->requestData);
    }

    function checkAuth(): bool
    {
        $this->token = new Token($this->requestData["token"]);
        if (!$this->token->checkVerify()) {
            $this->error("Token is invalid");
            return false;
        } else {
            return true;
        }
    }

    function login()
    {
        Login::exec($this);
    }

    function authorize()
    {
        Authorize::exec($this);
    }

    function identify()
    {
        Identify::exec($this);
    }
    function return($success, $data)
    {
        if ($this->active) return;
        $returnData = [
            "success" => $success,
            "data" => $data
        ];
        echo json_encode($returnData);
        $this->active = true;
    }
    function error($error)
    {
        $this->return(false, $error);
    }

    function getRequestData(): array
    {
        return $this->requestData;
    }

    function getToken(): \LennisDev\XAuth\Token|null
    {
        return $this->token;
    }
}
