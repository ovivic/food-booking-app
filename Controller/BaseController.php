<?php


class BaseController
{
    /**
     * __call magic method
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Send API output
     *
     * @param mixed $data
     * @param array $httpheaders
     */
    protected function sendOutput($data, $httpheaders=array())
    {
        header_remove('Set_Cookie');

        if (is_array($httpheaders) && count($httpheaders)) {
            foreach ($httpheaders as $httpheader) {
                header($httpheader);
            }
        }

        echo $data;
        exit();
    }

    // could create a Serializable interface that I can put on the objects
    protected function returnJsonEncodedArray($objectArray)
    {
        $recordsArray = [];
        $recordsArray["records"] = []; // this may not be necessary

        foreach ($objectArray as $object)
        {
            array_push($recordsArray["records"], $object->getSerialization());
        }

        return json_encode($recordsArray);
    }

}