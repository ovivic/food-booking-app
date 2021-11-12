<?php

require "BaseController.php";

class UserController extends BaseController
{
    public const API_READ_ALL = "/api/user/read.php";
    public const API_READ_ONE = "/api/user/read_one.php";
    public const API_CREATE = "/api/user/create.php";

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
        $decodedData = json_decode($jsonData, true);

        if (UserUtil::validateUserRegistrationFormData($decodedData)) {
            $user = new User($decodedData, false);

            // add validation for unique user

            return $this->userModel->create($user);
        } else {
            return false;
        }
    }
}