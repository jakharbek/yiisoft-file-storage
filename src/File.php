<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Yiisoft\Yii\File\Exception\FileException;
use Yiisoft\Yii\File\Exception\StorageException;
use Yiisoft\Yii\File\Helper\FileHelper;
use Yiisoft\Yii\File\Helper\StorageHelper;
use Yiisoft\Yii\File\Repository\StorageRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Annotation\Table\Index;

/**
 * Class File
 * @package Yiisoft\Yii\Files
 * @Entity(repository = "Yiisoft/Yii/File/Repository/FileRepository")
 */
class File
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @var string
     * @Column(type = "text", nullable = false)
     */
    public $public_url;

    /**
     * @Column(type = "primary")
     */
    protected $id;

    /**
     * @Column(type = "integer(255)")
     */
    protected $size;

    /**
     * @Column(type = "integer(2)", default = 1)
     */
    protected $status = self::STATUS_ACTIVE;

    /**
     * @var string
     * @Column(type = "text", nullable = false)
     */
    protected $path;

    /**
     * @var string
     * @Column(type = "text", nullable = false)
     */
    protected $filename;

    /**
     * @var string
     * @Column(type = "string(255)", nullable = true)
     */
    protected $title;

    /**
     * @var string
     * @Column(type = "string(255)", nullable = false)
     */
    protected $mimetype;

    /**
     * @var string
     * @Column(type = "datetime")
     */
    protected $timestamp;

    /**
     * @var string
     * @Column(type = "string(255)", nullable = false)
     */
    protected $storage_alias;

    /**
     * @var ORMInterface
     */
    private $orm;

    /**
     * @var string
     */
    private $tmpname;


    /**
     * File constructor.
     * @param $name
     * @param ORMInterface $orm
     * @throws FileException
     */
    public function __construct($name, ORMInterface $orm)
    {
        if (preg_match("/[$]/m", $name)) {
            $name = str_replace("$", null, $name);
            $name = FileHelper::getPathFromFiles($name);
        }

        $this->setTmpname($name);
        if ($this->isNewFile()) {
            $this->initNewFile();
        }

        $this->orm = $orm;
    }

    /**
     * @return bool
     */
    public function isNewFile()
    {
        return $this->id === NULL;
    }

    /**
     * @throws Exception\AdapterException
     * @throws StorageException
     */
    public function initNewFile()
    {
        $this->setStorage("local");
        $this->setSize(filesize($this->getTmpname()));
        $this->setFilename(basename($this->getTmpname()));
        $this->setMimetype(mime_content_type($this->getTmpname()));
        $this->setTimestamp(filemtime($this->getTmpname()));
        $this->setTitle($this->getFilename());
    }

    /**
     * @param $value
     * @return Storage
     * @throws Exception\AdapterException
     * @throws StorageException
     */
    public function setStorage($value): Storage
    {
        $alias = NULL;
        if ($value == "local" || $value == NULL) {
            $storage = Storage::getLocalStorage();
            $alias = "local";
        }

        if ($alias == NULL) {
            $storage = $this->getStorageBy($value);
        }

        $this->setStorageAlias($storage->getAlias());
        return $this->getStorage();
    }

    /**
     * @return Storage|null
     * @throws StorageException
     */
    private function getStorageBy($value)
    {
        /**
         * @var $repository StorageRepository
         */
        $repository = $this->orm->getRepository(Storage::class);
        $storage = (preg_match("/[#]/m", $value)) ? $repository->getByTag(str_replace("#", null, $value)) : $repository->getByAlias($value);
        if (!is_a($storage, Storage::class)) {
            throw new StorageException("Storage is not founded");
        }

        $storage->setFile($this);
        return $storage;
    }

    /**
     * @return Storage
     * @throws \Exception
     */
    public function getStorage(): Storage
    {
        $alias = $this->getStorageAlias();
        if ($alias == "local" || $alias == NULL) {
            $storage = Storage::getLocalStorage();
            $storage->setFile($this);
            return $storage;
        }

        $repository = $this->orm->getRepository(Storage::class);
        $storage = $repository->getByAlias($this->getStorageAlias());
        $storage->setFile($this);
        return $storage;
    }

    /**
     * @return string
     */
    public function getStorageAlias(): ?string
    {
        return $this->storage_alias;
    }


    /**
     * @param string $storage_alias
     * @return string|null
     */
    public function setStorageAlias(string $storage_alias): ?string
    {
        $this->storage_alias = $storage_alias;
        return $this->getStorageAlias();
    }

    /**
     * @return mixed
     */
    public function getTmpname()
    {
        return $this->tmpname;
    }


    /**
     * @param $tmpname
     * @return string
     */
    public function setTmpname($tmpname): string
    {
        $this->tmpname = $tmpname;
        return $this->getTmpname();
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }


    /**
     * @param string $filename
     * @return string
     */
    public function setFilename(string $filename): string
    {
        $this->filename = $filename;
        return $this->getFilename();
    }


    /**
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     */
    public function exists()
    {
        if ($this->isNewFile()) {
            $this->checkTmpname();
            return file_exists($this->tmpname);
        }
        $storage = $this->getStorage();
        $storage->setFile($this);
        return $storage->exists($this->path);
    }

    /**
     * @throws FileException
     */
    public function checkTmpname()
    {
        if (strlen($this->getTmpname()) == 0) {
            throw new FileException("The storage location of the temporary file is not specified");
        }
    }


    /**
     * @param $newFile
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function update($newFile)
    {
        if ($this->isNewFile()) {
            throw new FileException("You cannot update the new file");
        }

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

        if ($this->isNewFile()) {
            return $storage->write($newPath, $this->getTmpStream(), $config);
        }

        return $storage->write($newPath, $this, $config);
    }


    /**
     * @return false|resource
     */
    public function getTmpStream()
    {
        return fopen($this->getTmpname(), 'r+');
    }


    /**
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \Throwable
     */
    public function delete()
    {
        if ($this->isNewFile()) {
            throw new FileException("You cannot delete the new file");
        }


        $storage = $this->getStorage();
        if (!$storage->delete()) {
            return false;
        }

        $tr = new Transaction($this->orm);
        $tr->delete($this);
        $tr->run();

        return true;
    }


    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function readAndDelete()
    {
        if ($this->isNewFile()) {
            throw new FileException("You cannot delete the new file");
        }

        return $this->getStorage()->readAndDelete();
    }


    /**
     * @param $to
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function rename($to)
    {
        if ($this->isNewFile()) {
            throw new FileException("You cannot rename the new file");
        }

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
        if ($this->isNewFile()) {
            return $this->put($to);
        }

        return $this->getStorage()->copy($to);
    }


    /**
     * @param null $filename
     * @param string $storage
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws StorageException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function put($filename = null, $storage = "local", $config = [])
    {
        $storage = $this->setStorage($storage);
        $filename = $this->setPath($filename);
        if ($this->isNewFile()) {
            return $storage->put($filename, $this->read(), $config);
        }
        return $storage->put($filename, $this, $config);
    }

    /**
     * @return bool|false|mixed|resource|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function read()
    {
        if ($this->isNewFile()) {
            return $this->getTmpStream();
        }

        return $this->getStorage()->read();
    }

    /**
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getMimetype()
    {
        return $this->mimetype;
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
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getTimestamp()
    {
        return $this->timestamp;
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
        return $this->size;
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
    public function getTitle()
    {
        if ($this->isNewFile()) {
            return $this->getFilename();
        }
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
        if ($this->isNewFile()) {
            return pathinfo($this->getTmpname());
        }
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
     * @param null $path
     * @return string|null
     * @throws \Exception
     */
    public function setPath($path = null): ?string
    {
        if ($path == null) {
            $this->path = $this->getBasename();
        } else {
            $this->path = $path;
        }

        if (strlen($this->getStorage()->getTemplate()) > 0) {
            $this->path = StorageHelper::getPathFromTemplate($this->path, $this->getStorage()->getTemplate());
        }
        $this->path .= "." . $this->getExtension();
        $this->setPublicUrl();
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
     * @return string|string[]
     * @throws \Exception
     */
    public function relativePath()
    {
        return str_replace($this->getStorage()->getRoot(), null, $this->getPath());
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

    /**
     * @return false|string
     */
    public function getTmpContents()
    {
        return file_get_contents($this->getTmpname());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}
