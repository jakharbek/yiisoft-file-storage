<?php


namespace Yiisoft\Yii\File\Adapter;


use Spatie\Dropbox\Client;
use Yiisoft\Yii\File\Dto\DropboxAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
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
            throw new AdapterException("Please enter either DropboxAdapterDTO or pass argument according to DropboxAdapterDTO.");
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
