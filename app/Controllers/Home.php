<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index():string
    {
        return $this->twig->render("home");
    }

    public function product():string
    {
        return $this->twig->render("product");
    }
}
