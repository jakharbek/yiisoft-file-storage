<?php

namespace Yiisoft\File\Adapter;

use Yiisoft\File\Dto\NullAdapterDTO;

/**
 * Class NullAdapter
 * @package Yiisoft\File\Adapter
 */
class NullAdapter extends \League\Flysystem\Adapter\NullAdapter
{

    /**
     * @var NullAdapterDTO
     */
    public $connectionParams;

    function __construct()
    {
        $this->connectionParams = new NullAdapterDTO();
    }
}
