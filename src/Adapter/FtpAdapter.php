<?php


namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Dto\FtpAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class FtpAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class FtpAdapter extends \League\Flysystem\Adapter\Ftp
{
    public $connectionParams;

    /**
     * Ftp constructor.
     * @param mixed ...$args
     * @throws \Exception
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either FtpAdapterDTO or pass argument according to FtpAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], FtpAdapterDTO::class)) {
            $dto = $args[0];
            $this->connectionParams = $dto;
            $this->validation($dto);
            $config = (array)$dto;
            AdapterHelper::clear($config);
            return parent::__construct($config);
        }

        $this->validation($args);
        $config = $args;
        AdapterHelper::clear($args);
        return parent::__construct(...$config);
    }

    /**
     * @param $configuration
     */
    private function validation($configuration)
    {
        AdapterHelper::validation(['host', 'username', 'password'], $configuration);
    }
}
