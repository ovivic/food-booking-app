<?php


class RestaurantController extends BaseController
{
    private RestaurantModel $restaurantModel;

    public function __construct(RestaurantModel $restaurantModel)
    {
        $this->restaurantModel = $restaurantModel;
    }

    /**
     *
     *
     * @return false|string
     */
    public function listAction() {
        return $this->returnJsonEncodedArray($this->restaurantModel->listAll());
    }
}