<?php

namespace Yiisoft\Yii\File\Adapter;

use League\Flysystem\Config;
use League\Flysystem\Memory\MemoryAdapter as Memory;
use Yiisoft\Yii\File\Dto\MemoryAdapterDTO;

/**
 * Class MemoryAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class MemoryAdapter extends Memory
{
    /**
     * @var MemoryAdapterDTO
     */
    public $connectionParams;

    function __construct(Config $config = null)
    {
        $this->connectionParams = new MemoryAdapterDTO();
        parent::__construct($config);
    }
}
