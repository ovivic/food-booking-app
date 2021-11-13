<?php


class AddressController extends BaseController
{
    public const API_READ_ONE = "/api/address/read_one.php";

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
}