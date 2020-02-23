<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */


namespace Yiisoft\Yii\File\Helper;

/**
 * Class StorageHelper
 * @package Yiisoft\Yii\File\Helper
 */
class StorageHelper
{
    /**
     * @param $str
     * @param $template
     * @return string|string[]
     */
    public static function getPathFromTemplate($str, $template)
    {
        $args = [
            ':year' => date("Y"),
            ':month' => date("m"),
            ':day' => date("d"),
            ':hour' => date("H"),
            ':minute' => date("i"),
            ':second' => date("s")
        ];

        foreach ($args as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template.$str;
    }
}
