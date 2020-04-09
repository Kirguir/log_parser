<?php


class NotFoundException extends Exception implements AjaxResponseInterface
{
    protected $message = 'Resource not found.  Please check that the ID exists.';

    public function getResponseData()
    {
        return [];
    }

    public function getErrors()
    {
        return [$this->getMessage()];
    }
}
