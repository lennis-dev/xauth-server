<?php

namespace LennisDev\XAuth\UI;

class Register
{
    private array $alerts = [];

    public function render(): string
    {
        $this->preRender();
        $register = file_get_contents(__DIR__ . "/../../assets/html/register.html");
        $alerts = "";
        foreach ($this->alerts as $a) {
            $alerts .= '<div class="alert">' . $a . '</div>';
        }
        $register = str_replace("[alerts]", $alerts, $register);
        return $register;
    }
    public function addAlert(string $alert)
    {
        $this->alerts[] = $alert;
    }

    private function preRender()
    {
    }
}
