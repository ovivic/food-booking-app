<?php

require "BaseController.php";

class UserController extends BaseController
{
    public const API_READ_ALL = "/api/user/read.php";
    public const API_READ_ONE = "/api/user/read_one.php";
    public const API_CREATE = "/api/user/create.php";
    public const API_LOGIN = "/api/user/login.php";
    public const API_UPDATE = "/api/user/update.php";

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
        $userData = $this->userModel->readOneByProperty("id", $id);

        if ($userData !== null) {
            return $this->returnJsonEncodedArray([$userData]);
        }

        // TODO Handle when user cannot be found
        return false;
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

    /**
     * "/api/user/login" Endpoint - Verify if the user log in credentials are valid
     *
     * @param $jsonData
     *
     * @return true/false if the user can be logged in
     */
    public function canLogin($jsonData):?User
    {
        if (UserUtil::validateUserLoginFormData($jsonData)) {
            $user = $this->userModel->readOneByProperty("username", $jsonData["username"]);

            if ($user !== null) {
                $password = htmlspecialchars(stripslashes(trim($jsonData["password"])));
                $hashedPassword = UserUtil::addSaltToPassword($password, $user->getSalt());

                if ($hashedPassword == $user->getPassword()) {
                    return $user;
                }
            }

            return null;
        }
    }

    /**
     * "/api/user/update" Endpoint - Update a user record
     *
     * @param $jsonData
     */
    public function updateUser($jsonData)
    {
        $user = $this->userModel->readOneByProperty("id", $jsonData["id"]);

        $user->setPassword($jsonData["password"]);

        return $this->userModel->updateUserRecord($user);
    }
}