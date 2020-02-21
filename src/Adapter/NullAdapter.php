<?php

namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Dto\NullAdapterDTO;

/**
 * Class NullAdapter
 * @package Yiisoft\Yii\File\Adapter
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
