<?php


namespace Yiisoft\File\Adapter;


use Yiisoft\File\Dto\WebDAVAdapterDTO;
use Sabre\DAV\Client;
use Yiisoft\File\Exception\AdapterException;

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
