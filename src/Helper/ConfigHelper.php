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
        $params = self::getParams();
        return $params[$param] ?? null;
    }

    public static function getParams()
    {
        $params = require \hiqdev\composer\config\Builder::path('params');
        return $params;
    }
}
