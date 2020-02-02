<?php


namespace Yiisoft\File\Adapter;

use Yiisoft\File\Dto\LocalAdapterDTO;
use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class LocalAdapter
 * @package Yiisoft\File\Adapter
 */
class LocalAdapter extends \League\Flysystem\Adapter\Local
{
    /**
     * @var LocalAdapterDTO
     */
    public $connectionParams;

    /**
     * Local constructor.
     * @param $rootOrDto
     * @param mixed ...$args
     */
    function __construct($rootOrDto, ...$args)
    {
        if (is_a($rootOrDto, LocalAdapterDTO::class)) {

            AdapterHelper::validation([
                'root',
                'writeFlags',
                'linkHandling',
                'permissions'
            ], $rootOrDto);
            $this->connectionParams = $rootOrDto;
            return parent::__construct(
                $rootOrDto->root,
                $rootOrDto->writeFlags,
                $rootOrDto->linkHandling,
                $rootOrDto->permissions
            );
        }

        return parent::__construct(
            $rootOrDto,
            ...$args
        );
    }
}