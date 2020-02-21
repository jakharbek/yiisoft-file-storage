<?php


namespace Yiisoft\Yii\File\Dto;

use Aws\S3\UseArnRegion\ConfigurationProvider as UseArnRegionConfigurationProvider;

/**
 * Class AwsS3AdapterDTO
 * @package Dto
 */
class AwsS3AdapterDTO
{
    public $credentials_key;
    public $credentials_secret;
    public $region;
    public $version;
    public $bucket;
    public $endpoint;

    /**
     * Set to true to allow passed in ARNs to override client region. Accepts...
     *
     * @var array
     */
    public $use_arn_region = [UseArnRegionConfigurationProvider::class, 'defaultProvider'];

    /**
     * Set to true to send requests to an S3 Accelerate endpoint by default.
     * Can be enabled or disabled on individual operations by setting
     * Note: you must enable S3 Accelerate on a bucket before it can be accessed via an Accelerate endpoint.
     *
     * @var bool
     */
    public $use_accelerate_endpoint = false;
    /**
     * Set to true to send requests to an S3 Dual Stack
     * endpoint by default, which enables IPv6 Protocol
     * Can be enabled or disabled on individual operations by setting
     *
     * @var bool
     */
    public $use_dual_stack_endpoint = false;
    /**
     * Set to true to send requests to an S3 path style endpoint by default.
     * Can be enabled or disabled on individual operations by setting
     *
     * @var bool
     */
    public $use_path_style_endpoint = false;

    public $options = [];
    public $prefix;
}
