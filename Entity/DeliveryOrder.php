<?php


class DeliveryOrder
{
    private int $id;
    private int $restaurantId;
    private int $userId;

    private string $address;

    private float $total;

    private DateTime $date;

    public function __construct($orderData, $isExistingRecord = true)
    {
        if ($isExistingRecord) {
            $this->id = $orderData["id"];
        }

        $this->restaurantId = $orderData["restaurant_id"];
        $this->userId = $orderData["user_id"];
        $this->address = $orderData["address"];
        $this->total = $orderData["total"];
        $this->date = new DateTime($orderData["date"]);
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
     * @return DeliveryOrder
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
     * @return DeliveryOrder
     */
    public function setRestaurantId($restaurantId)
    {
        $this->restaurantId = $restaurantId;
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
     * @return DeliveryOrder
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed|string $address
     * @return DeliveryOrder
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return float|mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float|mixed $total
     * @return DeliveryOrder
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getDateString(): string
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @param DateTime $date
     * @return DeliveryOrder
     */
    public function setDate(DateTime $date): DeliveryOrder
    {
        $this->date = $date;
        return $this;
    }



    public function getSerialization()
    {
        return [
            "id" => $this->getId(),
            "restaurant_id" => $this->getRestaurantId(),
            "user_id" => $this->getUserId(),
            "address" => $this->getAddress(),
            "total" => $this->getTotal(),
            "date" => $this->getDateString()
        ];
    }
}