<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Dto\NullAdapterDTO;

/**
 * This class of adapter for working with Null
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\NullAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/null-test/
 * @see https://github.com/thephpleague/flysystem/blob/1.x/src/Adapter/NullAdapter.php
 * @see https://github.com/thephpleague/flysystem
 *
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
