<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\CachedAdapter;

/**
 * This class of DTO for working with Cached
 * This DTO for work with @see CachedAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://github.com/thephpleague/flysystem-cached-adapter/blob/master/src/CachedAdapter.php
 * @see https://github.com/thephpleague/flysystem-cached-adapter
 *
 * Class CachedAdapterDTO
 * @package Yiisoft\Yii\File\Dto
 */
class CachedAdapterDTO
{
    public $adapter;
    public $cache;
}
