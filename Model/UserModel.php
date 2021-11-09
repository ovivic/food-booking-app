<?php

require "Database.php";

class UserModel extends Database
{
    private const TABLE_NAME = "user";

    // read products
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

    function readOne()
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `id` = ?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->salt = $row['salt'];
        $this->type = $row['type'];
    }

    function create()
    {
        // need to make the password nice

        $query = "INSERT INTO " . self::TABLE_NAME . " SET name=:name, email=:email, username=:username, password=:password, salt=:salt, type=:type";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $this->name = htmlspecialchars((strip_tags($this->name)));
        $this->email = htmlspecialchars((strip_tags($this->email)));
        $this->username = htmlspecialchars((strip_tags($this->username)));
        $this->password = htmlspecialchars((strip_tags($this->password)));
        $this->salt = htmlspecialchars((strip_tags($this->salt)));
        $this->type = htmlspecialchars((strip_tags($this->type)));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":salt", $this->salt);
        $stmt->bindParam(":type", $this->type);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}