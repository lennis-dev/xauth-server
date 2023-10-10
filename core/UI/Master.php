<?php

namespace LennisDev\XAuth\UI;

require_once __DIR__ . "/Login.php";
require_once __DIR__ . "/Authorize.php";

use LennisDev\XAuth\UI\Login;
use LennisDev\XAuth\UI\Authorize;
use LennisDev\XAuth\UI\Register;

class Master
{
    private string|null $title;
    private string|null $description;
    private Login|Authorize|Register $content;

    public function __construct(string|null $title = null, string|null $description = null)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setContent(Login|Authorize|Register $content): void
    {
        $this->content = $content;
    }

    public function render(): string
    {
        $master = file_get_contents(__DIR__ . "/../../assets/html/master.html");
        $master = str_replace("[title]", $this->title, $master);
        $master = str_replace("[description]", $this->description, $master);

        $master = str_replace("[content]", $this->content->render(), $master);

        return $master;
    }
}
