<?php

namespace Yiisoft\File\Dto;


/**
 * Class GoogleStorageAdapterDTO
 * @package Dto
 */
class GoogleStorageAdapterDTO
{
    public $projectId;
    public $bucket;
    public $pathPrefix = null;
    public $storageApiUri = null;
}