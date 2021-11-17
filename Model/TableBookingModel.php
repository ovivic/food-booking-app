<?php


class TableBookingModel extends Database
{
    private const TABLE_NAME = "table_booking";

    public function create(TableBooking $tableBooking)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET restaurant_id=:restaurantId, table_id=:tableId, user_id=:userId, date=:date, seats=:seats";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":restaurantId", $tableBooking->getRestaurantId());
        $stmt->bindParam(":tableId", $tableBooking->getTableId());
        $stmt->bindParam(":userId", $tableBooking->getUserId());
        $stmt->bindParam(":date", $tableBooking->getDateString());
        $stmt->bindParam(":seats", $tableBooking->getSeats());

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

        $bookingEntities = [];

        // check if there are records
        if($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $booking = new TableBooking($row);

                array_push($bookingEntities, $booking);
            }
        }

        return $bookingEntities;
    }
}