<?php


namespace Yiisoft\File\Helper;

/**
 * Class ConfigHelper
 * @package Yiisoft\File\Helper
 */
class ConfigHelper
{
    /**
     * @param $param
     * @return mixed
     */
    public static function getParam($param)
    {
        $params = dirname(__DIR__)."/../config/params.php";
        return $params[$param] ?? $param;
    }
}
