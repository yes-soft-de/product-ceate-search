<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/25/2019
 * Time: 1:41 PM
 */

namespace App\Enum;


class RequestType
{
    static $REQUEST_UPDATE = 'update';
    static $REQUEST_CREATE = 'create';
    static $REQUEST_DELETE = 'delete';
    static $REQUEST_UNKNOWN = 'unknown';

    private $request;

    public function setRequestType($type)
    {
        switch ($type) {
            case self::$REQUEST_CREATE:
                $this->request = self::$REQUEST_CREATE;
                break;
            case self::$REQUEST_DELETE:
                $this->request = self::$REQUEST_DELETE;
                break;
            case self::$REQUEST_UPDATE:
                $this->request = self::$REQUEST_UPDATE;
                break;
            default:
                $this->request = self::$REQUEST_UNKNOWN;
                break;
        }
    }

    public function getRequestType()
    {
        return $this->request;
    }
}