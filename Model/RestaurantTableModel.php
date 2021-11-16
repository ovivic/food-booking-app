<?php


class RestaurantTableModel extends Database
{
    private const TABLE_NAME = "restaurant_table";

    public function readAllForRestaurant($restaurantId)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `restaurant_id`=?";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $restaurantId);

        $stmt->execute();

        $restTableEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $restaurantTable = new RestaurantTable($row);

                array_push($restTableEntities, $restaurantTable);
            }
        }

        return $restTableEntities;
    }

    public function create(RestaurantTable $restaurantTable)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET restaurant_id=:restaurantId, name=:name, max_seats=:maxSeats";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":restaurantId", $restaurantTable->getRestaurantId());
        $stmt->bindParam(":name", $restaurantTable->getName());
        $stmt->bindParam(":maxSeats", $restaurantTable->getMaxSeats());

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function delete($itemId)
    {
        $query = "DELETE FROM " . self::TABLE_NAME . " WHERE id=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $itemId);

        return $stmt->execute();
    }
}