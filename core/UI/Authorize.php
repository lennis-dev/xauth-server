<?php

namespace LennisDev\XAuth\UI;

class Authorize
{

    public function render(): string
    {
        $authorize = file_get_contents(__DIR__ . "/../../assets/html/authorize.html");

        return $authorize;
    }
}
