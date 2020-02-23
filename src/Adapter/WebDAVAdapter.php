<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\WebDAVAdapterDTO;
use Sabre\DAV\Client;
use Yiisoft\Yii\File\Exception\AdapterException;

/**
 * This class of adapter for working with WebDAV
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\WebDAVAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/webdav/
 * @see https://github.com/thephpleague/flysystem-webdav/blob/master/src/WebDAVAdapter.php
 * @see https://github.com/thephpleague/flysystem-webdav
 *
 * Class WebDAVAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class WebDAVAdapter extends \League\Flysystem\WebDAV\WebDAVAdapter
{
    /**
     * @var WebDAVAdapterDTO
     */
    public $connectionParams;

    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either WebDAVAdapterDTO or pass argument according to WebDAVAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], WebDAVAdapterDTO::class)) {
            /**
             * @var $dto WebDAVAdapterDTO
             */
            $dto = $args[0];
            $this->connectionParams = $dto;
            $client = new Client($dto);
            return parent::__construct($client, $dto->prefix, $dto->useStreamedCopy);
        }

        if (!is_a($args[0], Client::class)) {
            throw new AdapterException("Client attribute must be set");
        }

        return parent::__construct(...$args);
    }
}
