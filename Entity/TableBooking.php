<?php


class TableBooking
{
    private int $id;
    private int $restaurantId;
    private int $tableId;
    private int $userId;
    private DateTime $date;
    private int $seats;

    public function __construct($tableBookingData, $isExistingRecord = true)
    {
        if ($isExistingRecord)
        {
            $this->id = $tableBookingData["id"];
        }

        $this->restaurantId = $tableBookingData["restaurant_id"];
        $this->tableId = $tableBookingData["table_id"];
        $this->userId = $tableBookingData["user_id"];
        $this->date = new DateTime($tableBookingData["date"]);
        $this->seats = $tableBookingData["seats"];
    }

    /**
     * @return int|mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|mixed $id
     * @return TableBooking
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getRestaurantId()
    {
        return $this->restaurantId;
    }

    /**
     * @param int|mixed $restaurantId
     * @return TableBooking
     */
    public function setRestaurantId($restaurantId)
    {
        $this->restaurantId = $restaurantId;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @param int|mixed $tableId
     * @return TableBooking
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|mixed $userId
     * @return TableBooking
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return DateTime|mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getDateString()
    {
        return $this->date->format("Y-m-d");
    }

    /**
     * @param DateTime|mixed $date
     * @return TableBooking
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * @param int|mixed $seats
     * @return TableBooking
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
        return $this;
    }

    public function getSerialization() {
        return [
            "id" => $this->getId(),
            "restaurant_id" => $this->getRestaurantId(),
            "table_id" => $this->getTableId(),
            "user_id" => $this->getUserId(),
            "date" => $this->getDateString(),
            "seats" => $this->getSeats()
        ];
    }
}