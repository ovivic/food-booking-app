<?php


class MenuItemController extends BaseController
{
    public const API_READ_ALL = "/api/menuItem/readAll.php";
    public const API_CREATE = "/api/menuItem/create.php";
    public const API_DELETE = "/api/menuItem/delete.php";

    private MenuItemModel $menuItemModel;

    public function __construct(MenuItemModel $menuItemModel)
    {
        $this->menuItemModel = $menuItemModel;
    }

    public function readAllAction($restaurantId)
    {
        return $this->returnJsonEncodedArray($this->menuItemModel->readAllForRestaurant($restaurantId));
    }

    public function deleteAction($itemId)
    {
        return $this->menuItemModel->delete($itemId);
    }

    public function createAction($jsonData)
    {
        $menuItem = new MenuItem($jsonData, false);

        return $this->menuItemModel->create($menuItem);
    }
}