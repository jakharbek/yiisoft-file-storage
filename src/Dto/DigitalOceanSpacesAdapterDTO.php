<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\DigitalOceanSpacesAdapter;

/**
 * This class of DTO for working with Digital Ocean
 * This DTO for work with @see DigitalOceanSpacesAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/digitalocean-spaces/
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/aws-s3-v2/
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3/blob/master/src/AwsS3Adapter.php
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3
 *
 * Class DigitalOceanSpacesAdapterDTO
 * @package Dto
 */
class DigitalOceanSpacesAdapterDTO extends AwsS3AdapterDTO
{

}
