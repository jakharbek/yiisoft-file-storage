<?php

namespace Yiisoft\File;

use Cycle\ORM\ORMInterface;
use Psr\Container\ContainerInterface;
use Yiisoft\File\Exception\FileException;
use Yiisoft\File\Exception\StorageException;
use Yiisoft\File\Repository\StorageRepository;

/**
 * Class File
 * @package Yiisoft\Files
 * @Entity(repository = "Yiisoft/File/Repository/FileRepository")
 */
class File
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
    protected $status = self::STATUS_ACTIVE;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    protected $path;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    protected $filename;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = true)
     */
    protected $title;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    protected $mimetype;

    /**
     * @var string
     * @Column(type = "datetime")
     */
    protected $timestamp;

    /**
     * @var ORMInterface
     */
    private $orm;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    private $_storageTag = "local";

    /**
     * @var bool
     */
    private $_useCache = true;

    /**
     * @var string
     * @Column(type = "string(2048)", nullable = false)
     */
    public $public_url;

    /**
     * File constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->orm = $container->get(ORMInterface::class);
    }


    /**
     * @param $name
     * @return array
     * @throws FileException
     */
    public static function getInstancesByFilesArray($name): array
    {
        if (!isset($_FILES[$name])) {
            throw new FileException("Sent files is not founded");
        }

        $uploadedFiles = $_FILES[$name];

        if (count($uploadedFiles) == 0) {
            throw new FileException("Sent files is not founded");
        }

        $files = [];

        foreach ($uploadedFiles as $uploadedFile) {
            $files[] = self::getInstanceByFilesArray($name);
        }

        return $files;
    }

    /**
     * @param $name
     * @param string $storageTag
     * @return File
     * @throws Exception\AdapterException
     * @throws FileException
     */
    public static function getInstanceByFilesArray($name, $storageTag = "local"): File
    {
        if (!isset($_FILES[$name])) {
            throw new FileException("Sent files is not founded");
        }

        $uploadedFile = $_FILES[$name];
        if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
            throw new FileException("Sent file has error");
        }

        $tmpName = $uploadedFile['tmp_name'];
        $file = self::getInstance($tmpName, $storageTag);
        $file->setTitle($tmpName['name']);
        try {
            $file->setPublicUrl();
        } catch (\Exception $exception) {

        }

        if (!$file->exists()) {
            throw new FileException("File is not exists");
        }

        return $file;
    }

    /**
     * @param string $path
     * @param string $storageTag
     * @return File
     * @throws Exception\AdapterException
     */
    public static function getInstance($path, $storageTag = "local"): File
    {
        $file = new File();

        if ($storageTag == null) {
            $storageTag = Storage::getLocalStorage();
        }

        $file->setPath($path);
        $file->setStorageTag($storageTag);
        return $file;
    }

    /**
     * @return bool
     * @throws Exception\AdapterException
     */
    public function exists()
    {
        return $this->getStorage()->exists();
    }

    /**
     * @return Storage
     * @throws \Exception
     */
    public function getStorage(): Storage
    {
        return ($this->_storageTag == "local") ? Storage::getLocalStorage() : $this->getStorageBy();
    }

    /**
     * @return Storage|null
     * @throws StorageException
     */
    private function getStorageBy()
    {
        /**
         * @var $repository StorageRepository
         */
        $repository = $this->orm->getRepository(Storage::class);
        $storage = (!preg_match("#", $this->_storageTag)) ? $repository->getByTag($this->_storageTag) : $repository->getByAlias($this->_storageTag);
        if (!is_a($storage, Storage::class)) {
            throw new StorageException("Storage is not founded");
        }

        $storage->setFile($this);
        return $storage;
    }

    /**
     * @param $newPath
     * @param Storage|null $storage
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     */
    public function put($newPath, Storage $storage = null, $config = [])
    {
        if ($storage == null) {
            $storage = $this->getStorage();
        }
        return $storage->put($newPath, $this, $config);
    }

    /**
     * @param $file
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function update($newFile)
    {
        return $this->getStorage()->update($newFile);
    }

    /**
     * @param $newPath
     * @param Storage|null $storage
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
     */
    public function write($newPath, Storage $storage = null, $config = [])
    {
        if ($storage == null) {
            $storage = $this->getStorage();
        }
        return $storage->write($newPath, $this, $config);
    }

    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function read()
    {
        return $this->getStorage()->read();
    }

    /**
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function delete()
    {
        return $this->getStorage()->delete();
    }

    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function readAndDelete()
    {
        return $this->getStorage()->readAndDelete();
    }

    /**
     * @param $to
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function rename($to)
    {
        return $this->getStorage()->rename($to);
    }

    /**
     * @param $to
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function copy($to)
    {
        return $this->getStorage()->copy($to);
    }

    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getMimetype()
    {
        return $this->getUseCache() ? $this->mimetype : $this->getStorage()->getMimetype();
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setMimetype($value)
    {
        return $this->mimetype = $value;
    }

    /**
     * @return bool
     */
    public function getUseCache()
    {
        return $this->_useCache;
    }

    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getTimestamp()
    {
        return $this->getUseCache() ? $this->timestamp : $this->getStorage()->getTimestamp();
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTimestamp($value)
    {
        return $this->timestamp = $value;
    }

    /**
     * @return bool|false|int
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getSize()
    {
        return $this->getUseCache() ? $this->size : $this->getStorage()->getSize();
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSize($value)
    {
        return $this->size = $value;
    }

    /**
     * @return string
     */
    public function getStorageTag()
    {
        return $this->_storageTag;
    }

    /**
     * @param string $_storageTag
     * @return string
     */
    public function setStorageTag($_storageTag)
    {
        $this->_storageTag = $_storageTag;
        return $this->getStorageTag();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $name
     * @return string
     */
    public function setTitle($name)
    {
        $this->title = $name;
        return $this->getTitle();
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return int
     * @throws FileException
     */
    public function setStatus($status)
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            throw new FileException("Your value is not range");
        }

        return $this->getStatus();
    }

    /**
     * @return string
     */
    public function getBasename()
    {
        return $this->getPathInfo()['basename'];
    }

    /**
     * @return string|string[]
     */
    public function getPathInfo()
    {
        return pathinfo($this->getPath());
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
     * @return string
     */
    public function getExtension()
    {
        return $this->getPathInfo()['extension'];
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->getPathInfo()['filename'];
    }

    /**
     * @return string|string[]
     * @throws \Exception
     */
    public function relativePath()
    {
        return str_replace($this->getStorage()->getRoot(), $this->path);
    }

    /**
     * @return string|string[]
     * @throws \Exception
     */
    public function relativeDir()
    {
        return str_replace($this->getStorage()->getRoot(), $this->getDir());
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->getPathInfo()['dirname'];
    }

    /**
     * @return string
     */
    public function getPublicUrl()
    {
        return $this->public_url;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function setPublicUrl()
    {
        $this->public_url = $this->getStorage()->getPublicRoot() . $this->relativePath();
        return $this->getPublicUrl();
    }


}
