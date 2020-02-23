<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\GoogleStorageAdapterDTO;
use Google\Cloud\Storage\StorageClient;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter as GoogleStorage;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with Google Cloud
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\GoogleStorageAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/google-cloud-storage/
 * @see https://github.com/Superbalist/flysystem-google-cloud-storage/blob/master/src/GoogleStorageAdapter.php
 * @see https://github.com/Superbalist/flysystem-google-cloud-storage
 *
 * Class GoogleStorageAdapter
 * @package Yiisoft\Yii\File\Adapter
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
