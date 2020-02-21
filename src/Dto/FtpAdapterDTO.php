<?php

namespace Yiisoft\Yii\File\Dto;


/**
 * Class FtpAdapterDTO
 * @package Dto
 */
class FtpAdapterDTO
{
    public $host;
    public $username;
    public $password;
    public $port = 21;
    public $ssl = false;
    public $timeout = 90;
    public $root = "/";
    public $permPublic = 0744;
    public $permPrivate = 0700;
    public $passive = true;
    public $transferMode = FTP_BINARY;
    public $systemType;
    public $ignorePassiveAddress;
    public $recurseManually = false;
    public $utf8 = false;
    public $enableTimestampsOnUnixListings = false;
}
