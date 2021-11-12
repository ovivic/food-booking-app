<?php

require "BaseController.php";

class UserController extends BaseController
{
    public const API_READ_ALL = "/api/user/read.php";
    public const API_READ_ONE = "/api/user/read_one.php";
    public const API_CREATE = "/api/user/create.php";

    public const API_CREATE_SUCCESSFUL = 10000;
    public const API_CREATE_FAIL = 10001;

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

            // add validation for unique user
            if ($this->userModel->checkUnique($user)) {
                return $this->userModel->create($user);
            }
        }

        return false;
    }
}