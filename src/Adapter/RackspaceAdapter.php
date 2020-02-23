<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\RackspaceAdapterDTO;
use OpenCloud\ObjectStore\Resource\Container;
use OpenCloud\OpenStack;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with Rackspace
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\RackspaceAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/rackspace/
 * @see https://github.com/thephpleague/flysystem-rackspace/blob/master/src/RackspaceAdapter.php
 * @see https://github.com/thephpleague/flysystem-rackspace
 *
 * Class RackspaceAdapter
 * @package Yiisoft\Yii\File\Adapter
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
