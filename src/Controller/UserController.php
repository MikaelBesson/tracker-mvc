<?php

namespace Mika\TrackerMvc\Controller;

use Mika\TrackerMvc\Model\Entity\User;

use Yanntyb\Controller\Model\Classes\Controller;
use Yanntyb\Manager\Model\CLasses\Manager;

class UserController extends Controller
{
    public function inscriptionPage(string $error = null ) {
        $this->render("user/inscription.html.twig", [
            "error" => $error
        ]);
    }

    public function addUser() {
        if(isset($_POST["name"],$_POST["password"])){
            $name = $_POST["name"];
            $password = $_POST["password"];
            $check = Manager::getSingleEntity("user","name = :name" ,[":name"=>$name]);
            if(!$check) {
                $user = new User();
                $user = $user->setName($name)->setPassword($password)->setId(0);
                Manager::store($user);
                $this->loginPage();
            }
            else {
                $this->inscriptionPage("Utilisateur deja inscrit");
            }
        }
    }

    public function loginPage(string $error = null ) {
        $this->render("user/login.html.twig", [
            "error" => $error
        ]);
    }

    public function connect() {
        if(isset($_POST["name"],$_POST["password"])){
            $name = $_POST["name"];
            $password = $_POST["password"];
            $check = Manager::getSingleEntity("user","name = :name AND password = :password" ,[":name"=>$name, ":password"=>$password]);
            if($check) {
                $_SESSION["userid"] = $check->getId();
            }
        }
    }

    public function deconnect() {
        $_SESSION["userid"] = null;
        $this->loginPage();
    }

    public function testConnect() {
        if(isset($_SESSION["userid"])) {
            return $_SESSION["userid"];
        }
        else {
            return false;
        }
    }

}