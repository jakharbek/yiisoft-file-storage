<?php


namespace Yiisoft\File\Adapter;

use Aws\S3\S3Client;
use Yiisoft\File\Dto\AwsS3AdapterDTO;
use Yiisoft\File\Exception\AdapterException;
use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class AwsS3Adapter
 * @package Yiisoft\File\Adapter
 */
class AwsS3Adapter extends \League\Flysystem\AwsS3v3\AwsS3Adapter
{
    /**
     * @var AwsS3AdapterDTO
     */
    public $connectionParams;

    /**
     * Ftp constructor.
     * @param mixed ...$args
     * @throws \Exception
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either AwsS3AdapterDTO or pass argument according to AwsS3AdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], AwsS3AdapterDTO::class)) {
            /**
             * @var $dto AwsS3AdapterDTO
             */
            $dto = &$args[0];
            $this->connectionParams = $dto;
            $this->validation((array)$dto);
            $config = [
                'credentials' => [
                    'key' => $dto->credentials_key,
                    'secret' => $dto->credentials_secret
                ],
                'region' => $dto->region,
                'version' => $dto->version,
                'use_arn_region' => $dto->use_arn_region,
                'use_accelerate_endpoint' => $dto->use_accelerate_endpoint,
                'use_dual_stack_endpoint' => $dto->use_dual_stack_endpoint,
                'use_path_style_endpoint' => $dto->use_path_style_endpoint,
                'endpoint' => $dto->endpoint
            ];

            AdapterHelper::clear($config);
            $client = new S3Client($config);

            return parent::__construct($client, $dto->bucket, $dto->prefix, $dto->options);
        }

        if (!is_a($args[0], S3Client::class)) {
            throw new AdapterException("S3Client attribute must be set");
        }

        if (func_num_args() == 1) {
            throw new AdapterException("Bucket attribute must be set");
        }

        return parent::__construct(...$args);
    }

    protected function validation(array $configuration)
    {
        AdapterHelper::validation([
            'credentials' => ['key', 'secret'],
            'region',
            'version',
            'bucket'
        ], $configuration);
    }

}
