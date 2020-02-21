<?php


namespace Yiisoft\Yii\File\Adapter;


use Yiisoft\Yii\File\Dto\AwsS3AdapterDTO;
use Yiisoft\Yii\File\Dto\AzureAdapterDTO;
use Yiisoft\Yii\File\Dto\CachedAdapterDTO;
use Yiisoft\Yii\File\Dto\DigitalOceanSpacesAdapterDTO;
use Yiisoft\Yii\File\Dto\DropboxAdapterDTO;
use Yiisoft\Yii\File\Dto\FtpAdapterDTO;
use Yiisoft\Yii\File\Dto\GitlabAdapterDTO;
use Yiisoft\Yii\File\Dto\GoogleStorageAdapterDTO;
use Yiisoft\Yii\File\Dto\LocalAdapterDTO;
use Yiisoft\Yii\File\Dto\MemoryAdapterDTO;
use Yiisoft\Yii\File\Dto\NullAdapterDTO;
use Yiisoft\Yii\File\Dto\RackspaceAdapterDTO;
use Yiisoft\Yii\File\Dto\ReplicateAdapterDTO;
use Yiisoft\Yii\File\Dto\ScalewayObjectStorageAdapterDTO;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;
use Yiisoft\Yii\File\Dto\WebDAVAdapterDTO;
use Yiisoft\Yii\File\Dto\ZipArchiveAdapterDTO;
use Yiisoft\Yii\File\Exception\AdapterException;

/**
 * Class AdapterFactory
 * @package Yiisoft\Yii\File\Adapter
 */
class AdapterFactory
{
    /**
     * @param $dto
     * @return AwsS3Adapter|AzureAdapter|CachedAdapter|DigitalOceanSpacesAdapter|DropboxAdapter|FtpAdapter|GitlabAdapter|GoogleStorageAdapter|LocalAdapter|MemoryAdapter|NullAdapter|RackspaceAdapter|ReplicateAdapter|ScalewayObjectStorageAdapter|SftpAdapter|WebDAVAdapter|ZipArchiveAdapter
     * @throws AdapterException
     */
    public static function create($dto)
    {
        switch ($dto) {
            case is_a($dto, AwsS3AdapterDTO::class) :
                return new AwsS3Adapter($dto);
            case is_a($dto, AzureAdapterDTO::class) :
                return new AzureAdapter($dto);
            case is_a($dto, DigitalOceanSpacesAdapterDTO::class) :
                return new DigitalOceanSpacesAdapter($dto);
            case is_a($dto, DropboxAdapterDTO::class) :
                return new DropboxAdapter($dto);
            case is_a($dto, FtpAdapterDTO::class) :
                return new FtpAdapter($dto);
            case is_a($dto, GitlabAdapterDTO::class) :
                return new GitlabAdapter($dto);
            case is_a($dto, GoogleStorageAdapterDTO::class) :
                return new GoogleStorageAdapter($dto);
            case is_a($dto, LocalAdapterDTO::class) :
                return new LocalAdapter($dto);
            case is_a($dto, MemoryAdapterDTO::class) :
                return new MemoryAdapter($dto);
            case is_a($dto, NullAdapterDTO::class) :
                return new NullAdapter($dto);
            case is_a($dto, RackspaceAdapterDTO::class) :
                return new RackspaceAdapter($dto);
            case is_a($dto, ReplicateAdapterDTO::class) :
                return new ReplicateAdapter($dto);
            case is_a($dto, ScalewayObjectStorageAdapterDTO::class) :
                return new ScalewayObjectStorageAdapter($dto);
            case is_a($dto, SftpAdapterDTO::class) :
                return new SftpAdapter($dto);
            case is_a($dto, WebDAVAdapterDTO::class) :
                return new WebDAVAdapter($dto);
            case is_a($dto, ZipArchiveAdapterDTO::class) :
                return new ZipArchiveAdapter($dto);
            case is_a($dto, CachedAdapterDTO::class) :
                return new CachedAdapter($dto);
            default:
                throw new AdapterException("Adapter DTO is not founded");
        }
    }
}
