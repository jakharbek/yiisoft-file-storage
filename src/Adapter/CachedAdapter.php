<?php


namespace Yiisoft\File\Adapter;


use League\Flysystem\AdapterInterface;
use Yiisoft\File\Dto\CachedAdapterDTO;
use Yiisoft\File\Exception\AdapterException;
use Yiisoft\File\Helper\AdapterHelper;

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
