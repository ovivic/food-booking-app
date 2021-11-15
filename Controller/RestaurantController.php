<?php


class RestaurantController extends BaseController
{
    public const API_READ_ALL = "/api/restaurant/read.php";
    public const API_READ_ONE = "/api/restaurant/read_one.php";
    public const API_CREATE = "/api/restaurant/create.php";
    public const API_UPDATE = "/api/restaurant/update.php";

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

    /**
     * "/api/restaurant/read_one" Endpoint - Get Restaurant details
     *
     * @param $userId
     * @return false|string
     */
    public function readOneAction($userId)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->restaurantModel->readOneByProperty("user_id", $userId);

        if ($restaurant !== null) {
            return $this->returnJsonEncodedArray([$restaurant]);
        }

        // TODO Handle when address cannot be found
        return false;
    }

    /**
     * "/api/restaurant/create" Endpoint - Create Restaurant record
     * @param $jsonData
     * @return false
     */
    public function createAction($jsonData)
    {
        $restaurant = new Restaurant($jsonData, false);

        return $this->restaurantModel->create($restaurant);
    }

    /**
     * "/api/restaurant/update" Endpoint - Update Restaurant record
     * @param $jsonData
     */
    public function updateAction($jsonData)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->restaurantModel->readOneByProperty("id", $jsonData["id"]);

        $restaurant = $restaurant
            ->setId($jsonData["id"])
            ->setUserId($jsonData["user_id"])
            ->setName($jsonData["name"])
            ->setEmail($jsonData["email"])
            ->setPhone($jsonData["phone"])
            ->setIsOpen($jsonData["open"])
            ->setDescription($jsonData["description"])
            ->setIsDiningIn($jsonData["dine_in"])
            ->setIsDelivery($jsonData["delivery"])
            ->setRating($jsonData["rating"]);

        return $this->restaurantModel->update($restaurant);
    }
}