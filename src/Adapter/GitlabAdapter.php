<?php


namespace Yiisoft\Yii\File\Adapter;


use RoyVoetman\FlysystemGitlab\Client;
use Yiisoft\Yii\File\Dto\GitlabAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;
use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class GitlabAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class GitlabAdapter extends \RoyVoetman\FlysystemGitlab\GitlabAdapter
{
    /**
     * @var array|GitlabAdapterDTO
     */
    public $connectionParams;

    /**
     * GitlabAdapter constructor.
     * @param mixed ...$args
     * @throws AdapterException
     */
    function __construct(...$args)
    {
        if (func_num_args() == 0) {
            throw new AdapterException("Please enter either GitlabAdapterDTO or pass argument according to GitlabAdapterDTO.");
        }

        if (func_num_args() == 1 && is_a($args[0], GitlabAdapterDTO::class)) {
            /**
             * @var $dto GitlabAdapterDTO|array
             */
            $dto = $args[0];
            $this->connectionParams = $dto;
            AdapterHelper::validation([
                'personalAccessToken',
                'projectId',
                'branch',
                'baseUrl'
            ], $dto);

            $client = new Client($dto->personalAccessToken, $dto->projectId, $dto->branch, $dto->baseUrl);
            return parent::__construct($client, $dto->prefix);
        }

        if (!is_a($args[0], Client::class)) {
            throw new AdapterException("Client attribute must be set");
        }

        return parent::__construct(...$args);
    }
}
