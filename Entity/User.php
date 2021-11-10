<?php


class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $username;
    private string $password;
    private string $salt;
    private string $type;

    // need checks that the user data array is the correct shape
    // need to implement the is new user flag
    // or i create new constructor for different params for that
    public function __construct($userDataArray, $isExistingRecord = true)
    {

        if($isExistingRecord)
        {
            $this->id = $userDataArray["id"];
            $this->name = $userDataArray["name"];
            $this->email = $userDataArray["email"];
            $this->username = $userDataArray["username"];
            $this->password = $userDataArray["password"];
            $this->salt = $userDataArray["salt"];
            $this->type = $userDataArray["type"];
        }
        else
        {
            $this->name = htmlspecialchars((strip_tags($userDataArray["name"])));
            $this->email = htmlspecialchars((strip_tags($userDataArray["email"])));
            $this->username = htmlspecialchars((strip_tags($userDataArray["username"])));

            $this->setSalt(UserUtil::generateSaltFromUserProfile($userDataArray["username"]));
            $this->setPassword(htmlspecialchars((strip_tags($userDataArray["password"]))));

            // all users created for now are clients
            $this->type = 1;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = UserUtil::addSaltToPassword($this->getSalt(), $password);
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt(string $salt): User
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return User
     */
    public function setType(string $type): User
    {
        $this->type = $type;
        return $this;
    }

    /**
     * custom serialization for the object
     */
    public function getSerialization()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "salt" => $this->getSalt(),
            "type" => $this->getType()
        ];
    }

}