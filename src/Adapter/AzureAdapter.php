<?php


namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\AzureAdapterDTO;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class AzureAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class AzureAdapter extends AzureBlobStorageAdapter
{
    /**
     * @var AzureAdapterDTO
     */
    public $connectionParams;

    /**
     * AzureAdapter constructor.
     * @param mixed ...$args
     * @throws AdapterException
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either AzureAdapterDTO or pass argument according to AzureAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], AzureAdapterDTO::class)) {
            /**
             * @var $dto AzureAdapterDTO
             */
            $dto = &$args[0];
            $this->connectionParams = $dto;
            AdapterHelper::validation([
                'defaultEndpointsProtocol',
                'accountName',
                'accountKey',
                'container'
            ], $dto);

            $client = BlobRestProxy::createBlobService("DefaultEndpointsProtocol={$dto->defaultEndpointsProtocol};AccountName={$dto->accountName};AccountKey={$dto->accountKey};");
            return parent::__construct($client, $dto->container);
        }

        if (!is_a($args[0], BlobRestProxy::class)) {
            throw new AdapterException("BlobRestProxy attribute must be set");
        }

        if (func_num_args() == 1) {
            throw new AdapterException("Container attribute must be set");
        }

        return parent::__construct(...$args);
    }
}
