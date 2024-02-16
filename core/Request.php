<?php

namespace LennisDev\XAuth;

require __DIR__ . "/../core/Token.php";

use \LennisDev\XAuth\Token;

class Request
{
    protected array $requestData = [];
    protected bool $active = false;
    protected \LennisDev\XAuth\Token|null $token = null;

    function __construct()
    {
        $this->requestData = json_decode(file_get_contents("php://input"), true);
        $this->token = new Token($this->requestData["token"]);
    }
    function exec($function)
    {
        return $function($this->requestData);
    }

    function checkAuth(): bool
    {
        $this->token = new Token($this->requestData["token"]);
        if (!$this->token->checkVerify() || !$this->token->checkExpire() || !$this->checkApplication($_SERVER["SERVER_NAME"])) {
            $this->error("Token is invalid");
            return false;
        } else {
            return true;
        }
    }

    function checkApplication($serverName): bool
    {
        if ($this->token->getApplication() == $serverName) {
            return true;
        } else {
            return false;
        }
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
