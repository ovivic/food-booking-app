<?php


class AddressModel extends Database
{
    private const TABLE_NAME = "address";

    public function getClientAddress($entityId): ?Address
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE for_restaurant=0 AND entity_id=?";

        // prepare query statement
        $stmt = $this->connection->prepare($query);
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
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $entityId);

        $stmt->execute();

        // get retrieved row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Address($row);
        }

        return null;
    }

    public function create(Address $address)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . " SET entity_id=:entityId, for_restaurant=:forRestaurant, street=:street, town=:town, county=:county, post_code=:postCode";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":entityId", $address->getEntityId());
        $stmt->bindParam(":forRestaurant", $address->getForRestaurant());
        $stmt->bindParam(":street", $address->getStreet());
        $stmt->bindParam(":town", $address->getTown());
        $stmt->bindParam(":county", $address->getCounty());
        $stmt->bindParam(":postCode", $address->getPostCode());

        if($stmt->execute()){
            return true;
        }

        return false;
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

            return new Address($row);
        }

        return null;
    }

    public function updateRecord(Address $address)
    {
        $query = "UPDATE " . self::TABLE_NAME . " SET entity_id=:entityId, for_restaurant=:forRestaurant, street=:street, town=:town, county=:county, post_code=:postCode WHERE id=:id";

        // prepare query
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":id", $address->getId());
        $stmt->bindParam(":entityId", $address->getEntityId());
        $stmt->bindParam(":forRestaurant", $address->getForRestaurant());
        $stmt->bindParam(":street", $address->getStreet());
        $stmt->bindParam(":town", $address->getTown());
        $stmt->bindParam(":county", $address->getCounty());
        $stmt->bindParam(":postCode", $address->getPostCode());

        if($stmt->execute()){
            return true;
        }

        return false;
    }

}