<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Dto;

use Yiisoft\Yii\File\Adapter\SftpAdapter;

/**
 * This class of DTO for working with Sftp
 * This DTO for work with @see SftpAdapter
 * This DTO implements the flysystem arguments, for more information
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/sftp/
 * @see https://github.com/thephpleague/flysystem-sftp
 * @see https://github.com/thephpleague/flysystem-sftp/blob/master/src/SftpAdapter.php
 * @see https://github.com/thephpleague/flysystem-sftp
 *
 * Class SftpAdapterDTO
 * @package Dto
 */
class SftpAdapterDTO
{
    public $host;
    public $username;
    public $password;
    public $port = 22;
    public $hostFingerprint;
    public $useAgent;
    public $agent;
    public $timeout = 90;
    public $root = "/";
    public $privateKey;
    public $passphrase;
    public $permPublic = 0744;
    public $permPrivate = 0700;
    public $directoryPerm = 0744;
}
