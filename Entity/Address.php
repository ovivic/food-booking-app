<?php


class Address
{
    private int $id;
    private int $entityId;
    private bool $forRestaurant;
    private string $street;
    private string $town;
    private ?string $county;
    private string $postCode;

    public function __construct($addressDataArray, $isExistingRecord = true)
    {
        if ($isExistingRecord)
        {
            $this->id = $addressDataArray["id"];
            $this->entityId = $addressDataArray["entity_id"];
            $this->forRestaurant = $addressDataArray["for_restaurant"];
            $this->street = $addressDataArray["street"];
            $this->town = $addressDataArray["town"];
            $this->county = $addressDataArray["county"];
            $this->postCode = $addressDataArray["post_code"];
        }
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
     * @return Address
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param int|mixed $entityId
     * @return Address
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function getForRestaurant()
    {
        return $this->forRestaurant;
    }

    /**
     * @param bool|mixed $forRestaurant
     * @return Address
     */
    public function setForRestaurant($forRestaurant)
    {
        $this->forRestaurant = $forRestaurant;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed|string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param mixed|string $town
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * @param mixed|string $county
     * @return Address
     */
    public function setCounty($county)
    {
        $this->county = $county;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param mixed|string $postCode
     * @return Address
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getAddressString()
    {
        $addressString = $this->street . ", " . $this->town . ", ";

        if ($this->county != null) {
            $addressString .= $this->county . ", ";
        }

        return $addressString . $this->postCode;
    }

    public function getSerialization() {
        return [
            "id" => $this->getId(),
            "entityId" => $this->getEntityId(),
            "forRestaurant" => $this->getForRestaurant(),
            "street" => $this->getStreet(),
            "town" => $this->getTown(),
            "county" => $this->getCounty(),
            "postCode" => $this->getPostCode(),
            "addressString" => $this->getAddressString()
        ];
    }
}