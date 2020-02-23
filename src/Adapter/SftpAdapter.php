<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Dto\FtpAdapterDTO;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with SFTP
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\SftpAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/sftp/
 * @see https://github.com/thephpleague/flysystem-sftp
 * @see https://github.com/thephpleague/flysystem-sftp/blob/master/src/SftpAdapter.php
 * @see https://github.com/thephpleague/flysystem-sftp
 *
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
     * SFtp constructor.
     * @param mixed ...$args
     * @throws \Exception
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either SftpAdapterDTO or pass argument according to SftpAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], SftpAdapterDTO::class)) {
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
