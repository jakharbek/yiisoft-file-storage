<?php


namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Dto\FtpAdapterDTO;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class SftpAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class SftpAdapter extends \League\Flysystem\Sftp\SftpAdapter
{
    /**
     * @var SftpAdapterDTO
     */
    public $connectionParams;

    /**
     * Ftp constructor.
     * @param mixed ...$args
     * @throws \Exception
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either SftpAdapterDTO or pass argument according to SftpAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], FtpAdapterDTO::class)) {
            $this->connectionParams = $args[0];
            $dto = (array)$args[0];
            $this->validation($dto);
            AdapterHelper::clear($dto);
            return parent::__construct($dto);
        }

        $dto = $args;
        $this->validation($dto);
        AdapterHelper::clear($dto);
        return parent::__construct(...$dto);
    }


    /**
     * @param $configuration
     */
    private function validation($configuration)
    {
        AdapterHelper::validation(['host', 'username', 'password'], $configuration);
    }
}
