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

    /**
     * "/api/user/read_one" Endpoint - Get One user based on ID
     *
     * @param int $id
     */
    public function readOneAction(int $id)
    {
        return $this->returnJsonEncodedArray($this->userModel->readOne($id));
    }

    /**
     * "/api/user/create" Endpoint - Create a new user in the system
     *
     * @param $jsonData
     *
     * @return true/false if the profile had been added or not
     */
    public function createAction($jsonData): bool
    {
        if (UserUtil::validateUserRegistrationFormData($jsonData)) {
            $user = new User($jsonData, false);

            return $this->userModel->create($user);
        } else {
            return false;
        }
    }

    // could create a Serializable interface that I can put on the objects
    private function returnJsonEncodedArray($objectArray)
    {
        $recordsArray = [];
        $recordsArray["records"] = []; // this may not be necessary

        foreach ($objectArray as $object)
        {
            array_push($recordsArray["records"], $object->getSerialization());
        }

        return json_encode($recordsArray);
    }
}