<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\ZipArchiveAdapter;

/**
 * This class of DTO for working with Zip
 * This DTO for work with @see ZipArchiveAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/zip-archive/
 * @see https://github.com/thephpleague/flysystem-ziparchive/blob/master/src/ZipArchiveAdapter.php
 * @see https://github.com/thephpleague/flysystem-ziparchive
 *
 * Class ZipArchiveAdapterDTO
 * @package Dto
 */
class ZipArchiveAdapterDTO
{
    public $location;
    public $archive = null;
    public $prefix = null;
}
