<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\ZipArchiveAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with ZIP
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\ZipArchiveAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/zip-archive/
 * @see https://github.com/thephpleague/flysystem-ziparchive/blob/master/src/ZipArchiveAdapter.php
 * @see https://github.com/thephpleague/flysystem-ziparchive
 *
 * Class ZipArchiveAdapter
 * @package Yiisoft\Yii\File\Adapter
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
