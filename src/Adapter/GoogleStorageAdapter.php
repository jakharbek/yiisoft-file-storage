<?php


namespace Yiisoft\File\Adapter;


use Yiisoft\File\Dto\GoogleStorageAdapterDTO;
use Google\Cloud\Storage\StorageClient;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter as GoogleStorage;
use Yiisoft\File\Exception\AdapterException;
use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class GoogleStorageAdapter
 * @package Yiisoft\File\Adapter
 */
class GoogleStorageAdapter extends GoogleStorage
{
    /**
     * @var GoogleStorageAdapterDTO
     */
    public $connectionParams;

    /**
     * GoogleStorageAdapter constructor.
     * @param mixed ...$args
     */
    public function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either GoogleStorageAdapterDTO or pass argument according to GoogleStorageAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], GoogleStorageAdapterDTO::class)) {
            /**
             * @var $dto GoogleStorageAdapterDTO
             */
            $dto = $args[0];

            AdapterHelper::validation([
                'projectId',
                'bucket'
            ], $dto);

            $this->connectionParams = $dto;

            $storageClient = new StorageClient([
                'projectId' => $dto->projectId,
            ]);

            $bucket = $storageClient->bucket($dto->bucket);

            return parent::__construct($storageClient, $bucket, $dto->pathPrefix, $dto->storageApiUri);
        }

        if (!is_a($args[0], StorageClient::class)) {
            throw new AdapterException("StorageClient attribute must be set");
        }

        if (func_num_args() == 1) {
            throw new AdapterException("Bucket attribute must be set");
        }

        return parent::__construct(...$args);
    }
}