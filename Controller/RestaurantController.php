<?php


class RestaurantController extends BaseController
{
    public const API_READ_ALL = "/api/restaurant/read.php";
    public const API_READ_ONE = "/api/user/read_one.php";
    public const API_CREATE = "/api/user/create.php";

    private RestaurantModel $restaurantModel;

    public function __construct(RestaurantModel $restaurantModel)
    {
        $this->restaurantModel = $restaurantModel;
    }

    /**
     * "/api/restaurant/read" Endpoint - Get List of all restaurants
     *
     * @return false|string
     */
    public function listAction() {
        return $this->returnJsonEncodedArray($this->restaurantModel->listAll());
    }
}