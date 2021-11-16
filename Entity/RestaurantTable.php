<?php


class RestaurantTable
{
    private int $id;
    private int $restaurantId;

    private string $name;
    private int $maxSeats;

    public function __construct($jsonData, $isExistingUser = true)
    {
        if ($isExistingUser)
        {
            $this->id = $jsonData["id"];
        }

        $this->restaurantId = $jsonData["restaurant_id"];
        $this->name = $jsonData["name"];
        $this->maxSeats = $jsonData["max_seats"];
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
     * @return RestaurantTable
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
     * @return RestaurantTable
     */
    public function setRestaurantId($restaurantId)
    {
        $this->restaurantId = $restaurantId;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed|string $name
     * @return RestaurantTable
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getMaxSeats()
    {
        return $this->maxSeats;
    }

    /**
     * @param int|mixed $maxSeats
     * @return RestaurantTable
     */
    public function setMaxSeats($maxSeats)
    {
        $this->maxSeats = $maxSeats;
        return $this;
    }

    public function getSerialization()
    {
        return [
            "id" => $this->getId(),
            "restaurant_id" => $this->getRestaurantId(),
            "name" => $this->getName(),
            "max_seats" => $this->getMaxSeats()
        ];
    }
}