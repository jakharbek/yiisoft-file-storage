<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use OpenCloud\Rackspace;
use Yiisoft\Yii\File\Adapter\RackspaceAdapter;

/**
 * This class of DTO for working with Rackspace
 * This DTO for work with @see RackspaceAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/rackspace/
 * @see https://github.com/thephpleague/flysystem-rackspace/blob/master/src/RackspaceAdapter.php
 * @see https://github.com/thephpleague/flysystem-rackspace
 *
 * Class RockspaceAdapterDTO
 * @package Yiisoft\Yii\File\Dto
 */
class RackspaceAdapterDTO
{
    public $url = Rackspace::UK_IDENTITY_ENDPOINT;
    public $username;
    public $password;
    public $name = "cloudFiles";
    public $region = "LON";
    public $prefix = null;
    public $containerName;
}
