<?php


class ClientsController extends BaseController
{

    public function getByID($id){
        $clientController = new UserModel();

        $arrClient = $userModel->getSpecific($table, $id);

        return json_encode($arrClient); 
    }
}