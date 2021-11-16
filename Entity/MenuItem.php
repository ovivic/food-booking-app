<?php


class MenuItem
{

    private int $id;
    private int $restaurantId;

    private string $name;
    private float $price;

    public function __construct($menuItemData, $isExistingUser=true)
    {
        if ($isExistingUser) {
            $this->id = $menuItemData["id"];
        }

        $this->restaurantId = $menuItemData["restaurant_id"];
        $this->name = $menuItemData["name"];
        $this->price = $menuItemData["price"];
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
     * @return MenuItem
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
     * @return MenuItem
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
     * @return MenuItem
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float|mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|mixed $price
     * @return MenuItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getSerialization()
    {
        return [
            "id" => $this->getId(),
            "restaurant_id" => $this->getRestaurantId(),
            "name" => $this->getName(),
            "price" => $this->getPrice()
        ];
    }

}