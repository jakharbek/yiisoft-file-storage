<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\DropboxAdapter;

/**
 * This class of DTO for working with Dropbox
 * This DTO for work with @see DropboxAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/dropbox/
 * @see https://github.com/spatie/flysystem-dropbox/blob/master/src/DropboxAdapter.php
 * @see https://github.com/spatie/flysystem-dropbox
 *
 * Class DropboxAdapterDTO
 * @package Yiisoft\Yii\File\Dto
 */
class DropboxAdapterDTO
{
    public $token;
    public $prefix;
}
