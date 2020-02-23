<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;

use League\Flysystem\Config;
use League\Flysystem\Memory\MemoryAdapter as Memory;
use Yiisoft\Yii\File\Dto\MemoryAdapterDTO;

/**
 * This class of adapter for working with Memory
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\MemoryAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/memory/
 * @see https://github.com/thephpleague/flysystem-memory/blob/master/src/MemoryAdapter.php
 * @see https://github.com/thephpleague/flysystem-memory
 *
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
