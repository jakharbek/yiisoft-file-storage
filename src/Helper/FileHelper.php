<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */


namespace Yiisoft\Yii\File\Helper;


use Yiisoft\Yii\File\Exception\FileException;
use Yiisoft\Yii\File\File;

/**
 * Class FileHelper
 * @package Yiisoft\Yii\File\Helper
 */
class FileHelper
{

    /**
     * @param $name
     * @return array
     * @throws FileException
     */
    public static function getPathsFromFiles($name): array
    {
        if (!isset($_FILES[$name])) {
            throw new FileException("Sent files is not founded");
        }

        $uploadedFiles = $_FILES[$name];

        if (count($uploadedFiles) == 0) {
            throw new FileException("Sent files is not founded");
        }

        $files = [];

        foreach ($uploadedFiles as $uploadedFile) {
            $files[] = self::getPathFromFiles($name);
        }

        return $files;
    }

    /**
     * @param $name
     * @return File
     * @throws FileException
     */
    public static function getPathFromFiles($name): string
    {
        if (!isset($_FILES[$name])) {
            throw new FileException("Sent files is not founded");
        }

        $uploadedFile = $_FILES[$name];
        if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
            throw new FileException("Sent file has error");
        }

        $tmpName = $uploadedFile['tmp_name'];
        if (!file_exists($tmpName)) {
            throw new FileException("File is not exists");
        }

        return $tmpName;
    }

}
