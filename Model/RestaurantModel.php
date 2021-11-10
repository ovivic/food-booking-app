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
}