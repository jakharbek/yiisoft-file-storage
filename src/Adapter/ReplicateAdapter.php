<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\ReplicateAdapterDTO;
use League\Flysystem\AdapterInterface;
use Yiisoft\Yii\File\Exception\AdapterException;

/**
 * This class of adapter for working with Replicate
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\ReplicateAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/replicate/
 * @see https://github.com/thephpleague/flysystem-replicate-adapter/blob/master/src/ReplicateAdapter.php
 * @see https://github.com/thephpleague/flysystem-replicate-adapter
 *
 * Class ReplicateAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class ReplicateAdapter extends \League\Flysystem\Replicate\ReplicateAdapter
{
    /**
     * @var ReplicateAdapterDTO
     */
    public $connectionParams;

    /**
     * ReplicateAdapter constructor.
     * @param mixed ...$args
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either ReplicateAdapterDTO or pass argument according to ReplicateAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], ReplicateAdapterDTO::class)) {
            /**
             * @var $dto ReplicateAdapterDTO
             */
            $dto = $args[0];
            $this->connectionParams = $dto;
            return parent::__construct($dto->source, $dto->replica);
        }

        if (!is_a($args[0], AdapterInterface::class)) {
            throw new AdapterException("Source attribute must be set");
        }

        if (!is_a($args[1], AdapterInterface::class)) {
            throw new AdapterException("Replica attribute must be set");
        }

        return parent::__construct(...$args);
    }
}
