<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/UI/Master.php";
require_once __DIR__ . "/UI/Login.php";
require_once __DIR__ . "/UI/Authorize.php";
require_once __DIR__ . "/UI/Register.php";

use LennisDev\XAuth\UI\Master;
use LennisDev\XAuth\UI\Login;
use LennisDev\XAuth\UI\Authorize;
use LennisDev\XAuth\UI\Register;

class UI
{
    public static int $LOGIN_PAGE = 1;
    public static int $AUTHORIZE_PAGE = 2;
    public static int $REGISTER_PAGE = 3;

    private Login|Authorize|Register $content;

    /**
     * 
     */
    public function __construct(array $data, int $page)
    {
        $master = new Master($data["title"], $data["description"]);

        if ($page === self::$LOGIN_PAGE) {
            $login = new Login();
            $login->addAlert("You are not logged in!");
            $this->content = $login;
        } else if ($page === self::$AUTHORIZE_PAGE) {
            $this->content = new Authorize();
        } else if ($page === self::$REGISTER_PAGE) {
            $this->content = new Register();
        }


        $master->setContent($this->content);

        echo $master->render();
    }
}
