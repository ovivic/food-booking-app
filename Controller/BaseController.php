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

}