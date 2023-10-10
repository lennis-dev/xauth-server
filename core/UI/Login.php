<?php

namespace LennisDev\XAuth\UI;

class Login
{
    private array $alerts = [];

    public function render(): string
    {
        $this->preRender();
        $login = file_get_contents(__DIR__ . "/../../assets/html/login.html");
        $alerts = "";
        foreach ($this->alerts as $a) {
            $alerts .= '<div class="alert">' . $a . '</div>';
        }
        $login = str_replace("[alerts]", $alerts, $login);
        return $login;
    }
    public function addAlert(string $alert)
    {
        $this->alerts[] = $alert;
    }

    private function preRender()
    {
    }
}
