<?php


namespace Yiisoft\Yii\File\Helper;

/**
 * Class ConfigHelper
 * @package Yiisoft\Yii\File\Helper
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
