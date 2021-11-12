<?php

require "Database.php";

class UserModel extends Database
{
    private const TABLE_NAME = "user";

    // read users - returns an array of User entities
    // implement the limit here
    function listAll()
    {
        $query = "SELECT * FROM " . self::TABLE_NAME;

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $userEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $user = new User($row);

                array_push($userEntities, $user);
            }
        }

        return $userEntities;
    }

    // read one user - returns a single User
    function readOneByProperty(string $propertyName,  $propertyValue)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `" . $propertyName . "` = ?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $propertyValue);

        $stmt->execute();

        // get retrieved row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new User($row);
        }

        return null;
    }

    function create(User $userToAdd)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET name=:name, email=:email, username=:username, password=:password, salt=:salt, type=:type";

        // prepare query
        $stmt = $this->connection->prepare($query);

        // bind values
        $stmt->bindParam(":name", $userToAdd->getName());
        $stmt->bindParam(":email", $userToAdd->getEmail());
        $stmt->bindParam(":username", $userToAdd->getUsername());
        $stmt->bindParam(":password", $userToAdd->getPassword());
        $stmt->bindParam(":salt", $userToAdd->getSalt());
        $stmt->bindParam(":type", $userToAdd->getType());

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function checkUnique(User $user)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE username=:username";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":username", $user->getUsername());

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false;
        }

        return true;
    }
}