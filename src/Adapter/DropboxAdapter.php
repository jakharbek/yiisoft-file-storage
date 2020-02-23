<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Spatie\Dropbox\Client;
use Yiisoft\Yii\File\Dto\DropboxAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with Dopbox
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\DropboxAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/dropbox/
 * @see https://github.com/spatie/flysystem-dropbox/blob/master/src/DropboxAdapter.php
 * @see https://github.com/spatie/flysystem-dropbox
 *
 * Class DropboxAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class DropboxAdapter extends \Spatie\FlysystemDropbox\DropboxAdapter
{
    /**
     * @var DropboxAdapterDTO
     */
    public $connectionParams;

    /**
     * DropboxAdapter constructor.
     * @param mixed ...$args
     * @throws AdapterException
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either DropboxAdapterDTO or pass argument according to DropboxAdapterDTO");
        }

        if (func_num_args() == 1 && is_a($args[0], DropboxAdapterDTO::class)) {
            /**
             * @var $dto DropboxAdapterDTO
             */
            $dto = &$args[0];
            $this->connectionParams = $dto;
            AdapterHelper::validation(['token'], $dto);
            $client = new Client($dto->token);
            return parent::__construct($client, $dto->prefix);
        }

        return parent::__construct(...$args);
    }
}
