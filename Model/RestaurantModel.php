<?php


class RestaurantModel extends Database
{
    private const TABLE_NAME = "restaurant";

    public function listAll()
    {
        $query = "SELECT * FROM " . self::TABLE_NAME;

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $restaurantEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $restaurant = new Restaurant($row);

                array_push($restaurantEntities, $restaurant);
            }
        }

        return $restaurantEntities;
    }

    public function readOneByProperty($propertyName, $propertyValue)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `" . $propertyName . "` = ?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $propertyValue);

        $stmt->execute();

        // get retrieved row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Restaurant($row);
        }

        return null;
    }

    // returns the ID of the insertion, or false if problem
    public function create(Restaurant $restaurant)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET user_id=:userID, name=:name, email=:email, phone=:phone, open=:open, description=:description, dine_in=:dineIn, delivery=:delivery";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":userID", $restaurant->getUserId());
        $stmt->bindParam(":name", $restaurant->getName());
        $stmt->bindParam(":email", $restaurant->getEmail());
        $stmt->bindParam(":phone", $restaurant->getPhone());
        $stmt->bindParam(":open", $restaurant->isOpen());
        $stmt->bindParam(":description", $restaurant->getDescription());
        $stmt->bindParam(":dineIn", $restaurant->isDiningIn());
        $stmt->bindParam(":delivery", $restaurant->isDelivery());

        // need to return the ID of the restaurant
        // execute query
        if($stmt->execute()){
            return $this->connection->lastInsertId();
        }

        return false;

    }

    public function update(Restaurant $restaurant)
    {
        $query = "UPDATE " . self::TABLE_NAME . " SET user_id=:userID, name=:name, email=:email, phone=:phone, open=:open, description=:description, dine_in=:dineIn, delivery=:delivery, rating=:rating WHERE id=:id";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":id", $restaurant->getId());
        $stmt->bindParam(":userID", $restaurant->getUserId());
        $stmt->bindParam(":name", $restaurant->getName());
        $stmt->bindParam(":email", $restaurant->getEmail());
        $stmt->bindParam(":phone", $restaurant->getPhone());
        $stmt->bindParam(":open", $restaurant->isOpen());
        $stmt->bindParam(":description", $restaurant->getDescription());
        $stmt->bindParam(":dineIn", $restaurant->isDiningIn());
        $stmt->bindParam(":delivery", $restaurant->isDelivery());
        $stmt->bindParam(":rating", $restaurant->getRating());

        // need to return the ID of the restaurant
        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
}