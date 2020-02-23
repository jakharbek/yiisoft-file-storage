<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\AzureAdapter;

/**
 * This class of DTO for working with Azure
 * This DTO for work with @see AzureAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/azure/
 * @see https://github.com/thephpleague/flysystem-azure-blob-storage/blob/master/src/AzureBlobStorageAdapter.php
 * @see https://github.com/thephpleague/flysystem-azure-blob-storage
 *
 * Class AzureAdapterDTO
 * @package Yiisoft\Yii\File\Dto
 */
class AzureAdapterDTO
{
    public $defaultEndpointsProtocol = "https";
    public $accountName;
    public $accountKey;
    public $container;
}
