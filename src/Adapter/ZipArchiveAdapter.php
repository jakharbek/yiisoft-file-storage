<?php


namespace Yiisoft\File\Adapter;


use Yiisoft\File\Dto\ZipArchiveAdapterDTO;
use Yiisoft\File\Exception\AdapterException;
use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class ZipArchiveAdapter
 * @package Yiisoft\File\Adapter
 */
class ZipArchiveAdapter extends \League\Flysystem\ZipArchive\ZipArchiveAdapter
{
    /**
     * ZipArchiveAdapter constructor.
     * @param mixed ...$args
     * @throws AdapterException
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either ZipArchiveAdapterDTO or pass argument according to ZipArchiveAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], ZipArchiveAdapterDTO::class)) {
            /**
             * @var $dto ZipArchiveAdapterDTO
             */
            $dto = $args[0];
            AdapterHelper::validation(['location'], $dto);
            return parent::__construct($dto->location, $dto->archive, $dto->prefix);
        }

        return parent::__construct(...$args);
    }
}
