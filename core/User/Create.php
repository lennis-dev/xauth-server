<?php

namespace LennisDev\XAuth\User;

require_once __DIR__ . "../User.php";

class Create extends \LennisDev\XAuth\User
{
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
