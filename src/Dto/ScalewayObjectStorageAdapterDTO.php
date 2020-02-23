<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\ScalewayObjectStorageAdapter;

/**
 * This class of DTO for working with Scaleway
 * This DTO for work with @see ScalewayObjectStorageAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/scaleway-object-storage/
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/aws-s3-v2/
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3/blob/master/src/AwsS3Adapter.php
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3
 *
 * Class ScalewayObjectStorageAdapterDTO
 * @package Dto
 */
class ScalewayObjectStorageAdapterDTO extends AwsS3AdapterDTO
{

}
