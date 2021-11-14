<?php


class Restaurant
{
    public const DINE_IN = 1;
    public const DELIVERY = 2;

    private int $id;
    private int $user_id;

    private string $name;
    private string $email;
    private string $phone;

    private bool $isOpen;

    private ?string $description;
    private bool $isDiningIn;
    private bool $isDelivery;
    private ?float $rating;

    public function __construct($restaurantDataArray, $isExistingRecord = true)
    {
        if ($isExistingRecord)
        {
            $this->id = $restaurantDataArray["id"];
            $this->user_id = $restaurantDataArray["user_id"];
            $this->name = $restaurantDataArray["name"];
            $this->email = $restaurantDataArray["email"];
            $this->phone = $restaurantDataArray["phone"];
            $this->isOpen = $restaurantDataArray["open"];
            $this->description = $restaurantDataArray["description"];
            $this->isDiningIn = $restaurantDataArray["dine_in"];
            $this->isDelivery = $restaurantDataArray["delivery"];
            $this->rating = $restaurantDataArray["rating"];
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Restaurant
     */
    public function setId(int $id): Restaurant
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return Restaurant
     */
    public function setUserId(int $user_id): Restaurant
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Restaurant
     */
    public function setName(string $name): Restaurant
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Restaurant
     */
    public function setEmail(string $email): Restaurant
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Restaurant
     */
    public function setPhone(string $phone): Restaurant
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    /**
     * @param bool $isOpen
     * @return Restaurant
     */
    public function setIsOpen(bool $isOpen): Restaurant
    {
        $this->isOpen = $isOpen;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param ?string $description
     * @return Restaurant
     */
    public function setDescription(?string $description): Restaurant
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDiningIn(): bool
    {
        return $this->isDiningIn;
    }

    /**
     * @param bool $isDiningIn
     * @return Restaurant
     */
    public function setIsDiningIn(bool $isDiningIn): Restaurant
    {
        $this->isDiningIn = $isDiningIn;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDelivery(): bool
    {
        return $this->isDelivery;
    }

    /**
     * @param bool $isDelivery
     * @return Restaurant
     */
    public function setIsDelivery(bool $isDelivery): Restaurant
    {
        $this->isDelivery = $isDelivery;
        return $this;
    }

    /**
     * @return float
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param ?float $rating
     * @return Restaurant
     */
    public function setRating(?float $rating): Restaurant
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * custom serialization for the object
     */
    public function getSerialization()
    {
        return [
            "id" => $this->getId(),
            "user_id" => $this->getUserId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "phone" => $this->getPhone(),
            "is_open" => $this->isOpen(),
            "description" => $this->getDescription(),
            "dine_in" => $this->isDiningIn(),
            "delivery" => $this->isDelivery(),
            "rating" => $this->getRating()
        ];
    }
}