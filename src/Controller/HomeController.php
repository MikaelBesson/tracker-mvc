<?php

namespace Mika\TrackerMvc\Controller;

use Yanntyb\Controller\Model\Classes\Controller;

class HomeController extends Controller
{

    public function home()
    {
        $this->render("home.html.twig");
    }
}