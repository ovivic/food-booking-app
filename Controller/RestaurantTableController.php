<?php


class RestaurantTableController extends BaseController
{
    public const API_READ_ALL = "/api/table/readAll.php";
    public const API_CREATE = "/api/table/create.php";
    public const API_DELETE = "/api/table/delete.php";

    private RestaurantTableModel $restTableModel;

    public function __construct($restTableModel)
    {
        $this->restTableModel = $restTableModel;
    }

    public function readAllAction($restaurantId)
    {
        return $this->returnJsonEncodedArray($this->restTableModel->readAllForRestaurant($restaurantId));
    }

    public function deleteAction($itemId)
    {
        return $this->restTableModel->delete($itemId);
    }

    public function createAction($jsonData)
    {
        $restTable = new RestaurantTable($jsonData, false);

        return $this->restTableModel->create($restTable);
    }
}