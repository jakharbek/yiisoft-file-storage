<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;


use Yiisoft\Yii\File\Adapter\GitlabAdapter;

/**
 * This class of DTO for working with Gitlab
 * This DTO for work with @see GitlabAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/ftp/
 * @see https://github.com/thephpleague/flysystem/blob/1.x/src/Adapter/Ftp.php
 * @see https://github.com/thephpleague/flysystem
 *
 * Class GitlabAdapterDTO
 * @package Dto
 */
class GitlabAdapterDTO
{
    public $personalAccessToken;
    public $projectId;
    public $branch;
    public $baseUrl;
    public $prefix = '';
}
