<?php


namespace Yiisoft\File;

use Cycle\ORM\ORMInterface;
use Psr\Container\ContainerInterface;
use Yiisoft\File\Repository\StorageRepository;

/**
 * Class File
 * @package Yiisoft\Files
 * @Entity(repository = "Yiisoft/File/Repository/FileRepository")
 */
class File
{
    /**
     * @Column(type = "primary")
     */
    protected $id;

    /**
     * @Column(type = "integer(1024)")
     */
    protected $size;

    /**
     * @Column(type = "integer(2)", default = 1)
     */
    protected $status;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    protected $path;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    protected $mimetype;

    /**
     * @var string
     * @Column(type = "datetime")
     */
    protected $created_at;

    /**
     * @var ORMInterface
     */
    private $orm;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    private $storage = "local";

    public function __construct(ContainerInterface $container)
    {
        $this->orm = $container->get(ORMInterface::class);
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param $path
     * @return string
     */
    public function setPath($path): ?string
    {
        $this->exists($path) ? $this->path = $path : NULL;
        return $this->getPath();
    }

    /**
     * @param null $path
     * @return bool
     */
    public function exists($path = null): bool
    {
        ($path == null) ? $path = $this->path : null;
        return $this->getStorage()->getFilesystem()->has($path);
    }

    /**
     * @return Storage
     */
    public function getStorage(): Storage
    {
        /**
         * @var $repository StorageRepository
         */
        $repository = $this->orm->getRepository('storage');
        return $repository->getByAlias($this->storage);
    }

}
