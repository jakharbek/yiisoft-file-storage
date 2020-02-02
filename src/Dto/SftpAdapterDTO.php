<?php
namespace Yiisoft\File\Dto;

/**
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
