<?php
session_start();

use Mika\TrackerMvc\Controller\HomeController;
use Mika\TrackerMvc\Controller\ItemController;
use Mika\TrackerMvc\Controller\ProjetController;
use Mika\TrackerMvc\Controller\UserController;
use Yanntyb\Manager\Model\CLasses\Manager;
use Yanntyb\Router\Model\Classes\RouteAlreadyExisteException;
use Yanntyb\Router\Model\Classes\Router;

require "../vendor/autoload.php";

Manager::setup("Mika\\TrackerMvc\\Model\\Entity","timetracker","root","");

$router = new Router();
$router->makeGroupedPermission("/","/checkConnect","/checkLogin");

try {
    /*
     * user management
     */

    $router->addRoute("inscription", "/inscription", [UserController::class, "inscriptionPage"])->noGroupePermission();
    $router->addRoute("handle inscription form", "/handleInscription", [UserController::class, "addUser"])->noGroupePermission();
    $router->addRoute("login", "/", [UserController::class, "loginPage"])->noGroupePermission();
    $router->addRoute("check login", "/checkLogin", [UserController::class, "connect"])->noGroupePermission()->setAfterCallback("/project/view");
    $router->addRoute("exit", "/deconnect", [UserController::class, "deconnect"])->noGroupePermission();
    $router->addRoute("check connection", "/checkConnect", [UserController::class, "testConnect"])->noGroupePermission()->noCheckHeader();

    /*
     * project management
     */
    $router->addRoute("view project", "/project/view", [ProjetController::class, "viewProjet"]);
    $router->addRoute("add project", "/project/add", [ProjetController::class, "addProject"])->setAfterCallback("/project/view");
    $router->addRoute("delete project", "/project/delete",[ProjetController::class,"deleteProject"])->setAfterCallback("/project/view");

    /*
     * item management
     */
    $router->addRoute("supprimer un item", "/item/delete/{id}", [ItemController::class, "delete"])->setAfterCallback("/project/view");
    $router->addRoute("ajoutez un item", "/item/add",[ItemController::class,"addItem"])->setAfterCallback("/project/view");
    $router->addRoute("mettre a jour le temps","/item/update", [ItemController::class, "update"])->isAjax();
    $router->addRoute("reset le timer","/item/reset", [ItemController::class, "reset"])->isAjax();


}catch (RouteAlreadyExisteException $e){
    //ToDo deffinir une gestion erreur
}

try{
    $router->handleQuery();
}catch (ReflectionException $e){
    //ToDo deffinir une gestion erreur
}

