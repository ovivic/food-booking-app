<?php


class AddressModel extends Database
{
    private const TABLE_NAME = "address";

    public function getClientAddress($entityId): ?Address
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE for_restaurant=0 AND entity_id=?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $entityId);

        $stmt->execute();

        // get retrieved row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Address($row);
        }

        return null;
    }

    public function getRestaurantAddress($entityId): ?Address
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE for_restaurant=1 AND entity_id=?";

        // prepare query statement
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(1, $entityId);

        $stmt->execute();

        // get retrieved row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Address($row);
        }

        return null;
    }

}