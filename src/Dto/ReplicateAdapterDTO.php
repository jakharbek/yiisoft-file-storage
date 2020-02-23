<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\ReplicateAdapter;

/**
 * This class of DTO for working with Replicate
 * This DTO for work with @see ReplicateAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/replicate/
 * @see https://github.com/thephpleague/flysystem-replicate-adapter/blob/master/src/ReplicateAdapter.php
 * @see https://github.com/thephpleague/flysystem-replicate-adapter
 *
 * Class ReplicateAdapterDTO
 * @package Dto
 */
class ReplicateAdapterDTO
{
    public $source;
    public $replica;
}
