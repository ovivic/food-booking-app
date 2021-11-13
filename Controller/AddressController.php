<?php


class AddressController extends BaseController
{
    public const API_READ_ONE = "/api/address/read_one.php";
    public const API_CREATE = "/api/address/create.php";
    public const API_UPDATE = "/api/address/update.php";

    private AddressModel $addressModel;

    public function __construct(AddressModel $addressModel)
    {
        $this->addressModel = $addressModel;
    }

    /**
     * "/api/address/read_one" Endpoint - returns a single address record
     *
     * @param $entityId
     * @param $isForRestaurant
     */
    public function readOneAction($entityId, $isForRestaurant = false)
    {
        $addressData = null;

        if ($isForRestaurant) {
            $addressData = $this->addressModel->getRestaurantAddress($entityId);
        } else {
            $addressData = $this->addressModel->getClientAddress($entityId);
        }

        if ($addressData !== null) {
            return $this->returnJsonEncodedArray([$addressData]);
        }

        // TODO Handle when address cannot be found
        return false;
    }

    /**
     * "/api/address/create" Endpoint - Create a new address in the system
     *
     * @param $jsonData
     *
     * @return true/false if the profile had been added or not
     */
    public function createAction($jsonData): bool
    {
        $address = new Address($jsonData, false);

        return $this->addressModel->create($address);
    }

    public function updateAction($jsonData)
    {
        /** @var Address $address */
        $address = $this->addressModel->readOneByProperty("id", $jsonData["id"]);

        $address = $address
            ->setId($jsonData["id"])
            ->setEntityId($jsonData["entity_id"])
            ->setForRestaurant($jsonData["for_restaurant"])
            ->setStreet($jsonData["street"])
            ->setTown($jsonData["town"])
            ->setCounty($jsonData["county"])
            ->setPostCode($jsonData["post_code"]);

        return $this->addressModel->updateRecord($address);
    }
}