<?php


class MenuItemController extends BaseController
{
    public const API_READ_ALL = "/api/menuItem/readAll.php";
    public const API_CREATE = "/api/restaurant/create.php";
    public const API_UPDATE = "/api/restaurant/update.php";

    private MenuItemModel $menuItemModel;

    public function __construct(MenuItemModel $menuItemModel)
    {
        $this->menuItemModel = $menuItemModel;
    }

    public function readAllAction($restaurantId)
    {
        return $this->returnJsonEncodedArray($this->menuItemModel->readAllForRestaurant($restaurantId));
    }
}