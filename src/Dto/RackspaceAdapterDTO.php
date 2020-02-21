<?php
namespace Yiisoft\Yii\File\Dto;

use OpenCloud\Rackspace;

/**
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
