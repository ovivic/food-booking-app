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

    // read one user - returns an array containing a single User entity
    function readOne(int $id)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `id` = ?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $id);

        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new User($row);

        return [$user];
    }

    function create(User $userToAdd)
    {
        // need to make the password nice

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
}