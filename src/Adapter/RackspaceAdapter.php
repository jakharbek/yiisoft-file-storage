<?php


namespace Yiisoft\File\Adapter;


use Yiisoft\File\Dto\RackspaceAdapterDTO;
use OpenCloud\ObjectStore\Resource\Container;
use OpenCloud\OpenStack;
use Yiisoft\File\Exception\AdapterException;
use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class RackspaceAdapter
 * @package Yiisoft\File\Adapter
 */
class RackspaceAdapter extends \League\Flysystem\Rackspace\RackspaceAdapter
{
    /**
     * @var RackspaceAdapterDTO
     */
    public $connectionParams;

    /**
     * RackspaceAdapter constructor.
     * @param mixed ...$args
     * @throws AdapterException
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either RockspaceAdapterDTO or pass argument according to RockspaceAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], RackspaceAdapterDTO::class)) {
            /**
             * @var $dto RackspaceAdapterDTO
             */
            $dto = $args[0];
            $this->connectionParams = $dto;

            $client = new OpenStack($dto->url, [
                'username' => $dto->username,
                'password' => $dto->password,
            ]);

            AdapterHelper::validation([
                'username',
                'password',
                'containerName'
            ], $dto);

            $store = $client->objectStoreService($dto->name, $dto->region);
            $container = $store->getContainer($dto->containerName);
            parent::__construct($container, $dto->prefix);
        }

        if (!is_a($args[0], Container::class)) {
            throw new AdapterException("Container attribute must be set");
        }

        return parent::__construct(...$args);
    }
}