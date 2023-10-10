<?php

namespace LennisDev\XAuth;

require __DIR__ . "/../core/Token.php";
require __DIR__ . "/../core/GenToken.php";

use \LennisDev\XAuth\Token;
use \LennisDev\XAuth\GenToken;


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
        if (!isset($this->requestData["auth"]["username"]))
            $this->error("Username not set");
        else if (!isset($this->requestData["auth"]["password"]))
            $this->error("Password not set");
        else {
            $username = $this->requestData["auth"]["username"];
            $password = $this->requestData["auth"]["password"];
            $user = new User($username);
            if (!$user->exists())
                $this->error("User does not exist");
            else if (!$user->checkPassword(
                $password,
                $this->requestData["auth"]["time"]
            )) $this->error("Password is incorrect");
            else {
                $token = new GenToken([
                    "username" => $username,
                    "created" => time(),
                    "expire" => time() + 3600
                ]);
                $token->addScope("authorize");
                $token->sign();
                $this->return(true, [
                    "token" => $token->getToken()
                ]);
            }
        }
    }

    function authorize()
    {
        $this->checkAuth();
        if (!$this->token->hasScope("authorize")) {
            $this->error("Token does not have authorize scope");
            return;
        }
        if (!isset($this->requestData["scopes"]))
            $this->error("Scopes not set");
        else {
            $token = new GenToken([
                "username" => $this->token->user->getUsername(),
                "expire" => time() + 3600
            ]);
            foreach ($this->requestData["scopes"] as $scope) {
                $token->addScope($scope);
            }
            $token->sign();
            $this->return(true, [
                "token" => $token->getToken()
            ]);
        }
    }

    function identify()
    {
        $this->checkAuth();
        if (!$this->token->hasScope("identify")) {
            $this->error("Token does not have identify scope");
            return;
        }
        $this->return(true, [
            "username" => $this->token->user->getUsername()
        ]);
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
}
