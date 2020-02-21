<?php

namespace Yiisoft\Yii\File\Dto;


/**
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
