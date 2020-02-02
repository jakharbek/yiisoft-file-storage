<?php


namespace Yiisoft\File\Adapter;


use Yiisoft\File\Dto\AwsS3AdapterDTO;
use Yiisoft\File\Dto\AzureAdapterDTO;
use Yiisoft\File\Dto\CachedAdapterDTO;
use Yiisoft\File\Dto\DigitalOceanSpacesAdapterDTO;
use Yiisoft\File\Dto\DropboxAdapterDTO;
use Yiisoft\File\Dto\FtpAdapterDTO;
use Yiisoft\File\Dto\GitlabAdapterDTO;
use Yiisoft\File\Dto\GoogleStorageAdapterDTO;
use Yiisoft\File\Dto\LocalAdapterDTO;
use Yiisoft\File\Dto\MemoryAdapterDTO;
use Yiisoft\File\Dto\NullAdapterDTO;
use Yiisoft\File\Dto\RackspaceAdapterDTO;
use Yiisoft\File\Dto\ReplicateAdapterDTO;
use Yiisoft\File\Dto\ScalewayObjectStorageAdapterDTO;
use Yiisoft\File\Dto\SftpAdapterDTO;
use Yiisoft\File\Dto\WebDAVAdapterDTO;
use Yiisoft\File\Dto\ZipArchiveAdapterDTO;
use Yiisoft\File\Exception\AdapterException;

/**
 * Class AdapterFactory
 * @package Yiisoft\File\Adapter
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
