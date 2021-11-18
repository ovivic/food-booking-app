<?php


class DeliveryOrderController extends BaseController
{
    public const API_READ_ALL = "/api/deliveryOrder/readAll.php";
    public const API_CREATE = "/api/deliveryOrder/create.php";
    public const API_DELETE = "/api/deliveryOrder/delete.php";

    private DeliveryOrderModel $deliveryOrderModel;

    public function __construct($deliveryOrderModel)
    {
        $this->deliveryOrderModel = $deliveryOrderModel;
    }

    public function deleteAction($itemId)
    {
        return $this->deliveryOrderModel->delete($itemId);
    }

    public function createAction($jsonData)
    {
        $order = new DeliveryOrder($jsonData, false);

        return $this->deliveryOrderModel->create($order);
    }

    public function readAlLAction($propertyName, $entityId)
    {
        return $this->returnJsonEncodedArray($this->deliveryOrderModel->readAllByProperty($propertyName, $entityId));
    }
}