<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\WebDAVAdapter;

/**
 * This class of DTO for working with WebDAV
 * This DTO for work with @see WebDAVAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/webdav/
 * @see https://github.com/thephpleague/flysystem-webdav/blob/master/src/WebDAVAdapter.php
 * @see https://github.com/thephpleague/flysystem-webdav
 *
 * Class WebDAVAdapterDTO
 * @package Dto
 */
class WebDAVAdapterDTO
{
    public $settings;
    public $prefix = null;
    public $useStreamedCopy = true;
}
