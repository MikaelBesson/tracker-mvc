<?php

namespace Mika\TrackerMvc\Controller;

use Mika\TrackerMvc\Model\Entity\Item;
use Yanntyb\Manager\Model\CLasses\Manager;

class ItemController
{
    public function delete(int $id){
        $item = Manager::getSingleEntity("item",$id);
        if($item){
            Manager::deleteFromObject($item);
        }
    }

    public function addItem(){
        if(isset($_POST['name'],$_POST["projet_fk"])) {
            $projet = Manager::getSingleEntity("projet",$_POST["projet_fk"]);
            $item = new Item();
            $item = $item->setId(0)->setProjet($projet)->setTimestamp(0)->setTitle($_POST['name']);
            Manager::store($item);
        }
    }

    public function update(){
        $data = json_decode(file_get_contents("php://input"));
        $item = Manager::getSingleEntity("item",$data->id);
        $item->setTimestamp($data->time);
        Manager::update($item);

    }

    public function reset(){
        $data = json_decode(file_get_contents("php://input"));
        $item = Manager::getSingleEntity("item",$data->id);
        $item->setTimestamp("0");
        Manager::update($item);
    }
}