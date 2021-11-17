<?php


class TableBookingController extends BaseController
{
    public const API_READ_ALL = "/api/tableBooking/readAll.php";
    public const API_CREATE = "/api/tableBooking/create.php";
    public const API_DELETE = "/api/tableBooking/delete.php";

    private TableBookingModel $tableBookingModel;

    public function __construct(TableBookingModel $tableBookingModel)
    {
        $this->tableBookingModel = $tableBookingModel;
    }

    public function deleteAction($itemId)
    {
        return $this->tableBookingModel->delete($itemId);
    }

    public function createAction($jsonData)
    {
        $booking = new TableBooking($jsonData, false);

        return $this->tableBookingModel->create($booking);
    }

    public function readAlLAction($propertyName, $entityId)
    {
        return $this->returnJsonEncodedArray($this->tableBookingModel->readAllByProperty($propertyName, $entityId));
    }
}