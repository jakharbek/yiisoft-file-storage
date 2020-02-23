<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use League\Flysystem\AdapterInterface;
use Yiisoft\Yii\File\Dto\CachedAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with Cached
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\CachedAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://github.com/thephpleague/flysystem-cached-adapter/blob/master/src/CachedAdapter.php
 * @see https://github.com/thephpleague/flysystem-cached-adapter
 *
 * Class CachedAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class CachedAdapter extends \League\Flysystem\Cached\CachedAdapter
{
    /**
     * @var CachedAdapterDTO
     */
    public $connectionParams;

    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either CachedAdapterDTO or pass argument according to CachedAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], CachedAdapterDTO::class)) {
            /**
             * @var $dto CachedAdapterDTO
             */
            $dto = $args[0];
            $this->connectionParams = $dto;

            AdapterHelper::validation([
                'adapter',
                'cache'
            ], $dto);
            return parent::__construct($dto->adapter, $dto->cache);
        }

        if (!is_a($args[0], AdapterInterface::class)) {
            throw new AdapterException("Adapter attribute must be set");
        }

        if (func_num_args() == 1) {
            throw new AdapterException("Cache attribute must be set");
        }

        return parent::__construct(...$args);
    }
}
