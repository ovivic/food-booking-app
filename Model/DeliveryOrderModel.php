<?php


class DeliveryOrderModel extends Database
{
    private const TABLE_NAME = "delivery_order";

    public function create(DeliveryOrder $deliveryOrder)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET restaurant_id=:restaurantId, user_id=:userId, address=:address, total=:total, date=:date";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":restaurantId", $deliveryOrder->getRestaurantId());
        $stmt->bindParam(":userId", $deliveryOrder->getUserId());
        $stmt->bindParam(":address", $deliveryOrder->getAddress());
        $stmt->bindParam(":total", $deliveryOrder->getTotal());
        $stmt->bindParam(":date", $deliveryOrder->getDateString());

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

    public function readAllByProperty(string $propertyName,  $propertyValue)
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE `" . $propertyName . "` = ?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $propertyValue);

        $stmt->execute();

        $orderEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $order = new DeliveryOrder($row);

                array_push($orderEntities, $order);
            }
        }

        return $orderEntities;
    }
}