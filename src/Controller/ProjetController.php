<?php

namespace Mika\TrackerMvc\Controller;

use Mika\TrackerMvc\Model\Entity\Projet;
use Yanntyb\Controller\Model\Classes\Controller;
use Yanntyb\Manager\Model\CLasses\Manager;

class ProjetController extends Controller
{
    public function viewProjet() {
        $projets = Manager::getAllEntity("projet","user_fk = :id", [":id" => $_SESSION["userid"]]);
        foreach ($projets as $projet) {
            $projet->setItems(Manager::getAllEntity("item","projet_fk = :id", [":id" => $projet->getId()]));
        }
        $this->render("projets/projets.html.twig", [
            "projets" => $projets
        ]);
    }

    public function addProject() {
        if(isset($_POST["name"])){
            $user = Manager::getSingleEntity("user",$_SESSION['userid']);
            $project = new Projet();
            $project = $project->setId(0)->setTitle($_POST["name"])->setUser($user);
            Manager::store($project,["items"]);
        }
    }

    public function deleteProject(){
        if(isset($_POST["id"])){
            $project = Manager::getSingleEntity("projet",$_POST["id"]);
            if($project){
                Manager::deleteFromObject($project,["items"]);
            }
        }
    }
}