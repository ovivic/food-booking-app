<?php


class MenuItemModel extends Database
{
    private const TABLE_NAME = "menu_item";

    public function readAllForRestaurant($restaurantId)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `restaurant_id`=?";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $restaurantId);

        $stmt->execute();

        $menuItemEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $menuItem = new MenuItem($row);

                array_push($menuItemEntities, $menuItem);
            }
        }

        return $menuItemEntities;
    }

    public function create(MenuItem $menuItem)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET restaurant_id=:restaurantId, name=:name, price=:price";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":restaurantId", $menuItem->getRestaurantId());
        $stmt->bindParam(":name", $menuItem->getName());
        $stmt->bindParam(":price", $menuItem->getPrice());

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function update(MenuItem $menuItem)
    {
        $query = "UPDATE " . self::TABLE_NAME . " SET restaurant_id=:restaurantId, name=:name, price=:price WHERE id=:id";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":id", $menuItem->getId());
        $stmt->bindParam(":restaurantId", $menuItem->getRestaurantId());
        $stmt->bindParam(":name", $menuItem->getName());
        $stmt->bindParam(":price", $menuItem->getPrice());

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}