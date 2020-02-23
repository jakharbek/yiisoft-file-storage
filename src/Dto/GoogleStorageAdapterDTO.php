<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;


use Yiisoft\Yii\File\Adapter\GoogleStorageAdapter;

/**
 * This class of DTO for working with Google Cloud
 * This DTO for work with @see GoogleStorageAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/google-cloud-storage/
 * @see https://github.com/Superbalist/flysystem-google-cloud-storage/blob/master/src/GoogleStorageAdapter.php
 * @see https://github.com/Superbalist/flysystem-google-cloud-storage
 *
 * Class GoogleStorageAdapterDTO
 * @package Dto
 */
class GoogleStorageAdapterDTO
{
    public $projectId;
    public $bucket;
    public $pathPrefix = null;
    public $storageApiUri = null;
}
