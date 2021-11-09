<?php

require "BaseController.php";

class UserController extends BaseController
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * "/api/user/read" Endpoint - Get List of all users
     *
     * @param int $limit
     */
    // need to implement limit
    // need to sort out the bad codes and everything
    public function listAction($limit=0)
    {
        return $this->returnJsonEncodedArray($this->userModel->listAll());
    }

    // could create a Serializable interface that I can put on the objects
    private function returnJsonEncodedArray($objectArray)
    {
        $recordsArray = [];
        $recordsArray["records"] = [];

        foreach ($objectArray as $object)
        {
            array_push($recordsArray["records"], $object->getSerialization());
        }

        return json_encode($recordsArray);
    }
}