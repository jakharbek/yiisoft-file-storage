<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Adapter\LocalAdapter;
use Yiisoft\Yii\File\Dto\LocalAdapterDTO;
use Yiisoft\Yii\File\Exception\FileException;
use Yiisoft\Yii\File\Helper\ConfigHelper;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Annotation\Table\Index;

/**
 * Class Storage
 * @package Yiisoft\Yii\File
 * @Entity(repository = "Yiisoft\Yii\File\Repository\StorageRepository")
 * @Table(
 *      indexes={
 *             @Index(columns = {"alias"}, unique = true),
 *             @Index(columns = {"status"})
 *      }
 * )
 */
class Storage
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @Column(type = "text", nullable = true)
     */
    public $public_root;

    /**
     * @Column(type = "primary")
     */
    protected $id;

    /**
     * @Column(type = "string(255)", nullable = false, unique = true)
     */
    protected $alias;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $type;

    /**
     * @var
     */
    protected $root;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $tag;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $connectionParams;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $configParams;

    /**
     * @Column(type = "integer(2)", default = 1)
     */
    protected $status;

    /**
     * @var Filesystem
     */
    private $_filesystem;

    /**
     * @var AdapterInterface
     */
    private $_adapter;

    /**
     * @var File
     */
    private $_file;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $template;

    /**
     * Storage constructor.
     * @param $connectionParams
     * @param null $configParams
     * @throws Exception\AdapterException
     */
    function __construct($connectionParams, $configParams = null)
    {
        $this->setConnectionParams($connectionParams);
        $this->setConfigParams($configParams);
        $this->connection();
    }

    /**
     * @throws Exception\AdapterException
     */
    public function connection()
    {
        $this->_filesystem = new Filesystem($this->getAdapter(), $this->getConfigParams());
        return $this;
    }

    /**
     * @return Adapter\AwsS3Adapter|Adapter\AzureAdapter|Adapter\CachedAdapter|Adapter\DigitalOceanSpacesAdapter|Adapter\DropboxAdapter|Adapter\FtpAdapter|Adapter\GitlabAdapter|Adapter\GoogleStorageAdapter|Adapter\LocalAdapter|Adapter\MemoryAdapter|Adapter\NullAdapter|Adapter\RackspaceAdapter|Adapter\ReplicateAdapter|Adapter\ScalewayObjectStorageAdapter|Adapter\SftpAdapter|Adapter\WebDAVAdapter|Adapter\ZipArchiveAdapter
     * @throws Exception\AdapterException
     */
    public function getAdapter()
    {
        if (!is_object($this->_adapter)) {
            $this->_adapter = AdapterFactory::create($this->getConnectionParams());
        }

        return $this->_adapter;
    }

    /**
     * @return mixed
     */
    public function getConnectionParams()
    {
        return (strlen($this->connectionParams) == 0) ? null : unserialize($this->connectionParams);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function setConnectionParams($params)
    {
        if (is_object($params) || (is_array($params) && count($params) > 0)) {
            $this->connectionParams = serialize($params);
        } else {
            $this->connectionParams = (strlen($params) == 0) ? null : serialize($params);
        }

        (is_object($params)) ? $this->type = get_class($params) : (is_array($params) ? $this->type = "array" : "string");
        return $this->getConnectionParams();
    }

    /**
     * @return mixed
     */
    public function getConfigParams()
    {
        return (strlen($this->configParams) == 0) ? null : unserialize($this->configParams);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function setConfigParams($params)
    {
        $this->configParams = (strlen($params) == 0) ? null : serialize($params);
        return $this->getConfigParams();
    }

    /**
     * @return Storage
     * @throws Exception\AdapterException
     */
    public static function getLocalStorage()
    {
        $dto = new LocalAdapterDTO();
        $dto->root = ConfigHelper::getParam('file.storage')['local']['root'];
        $dto->permissions = ConfigHelper::getParam('file.storage')['local']['permissions'];
        $dto->linkHandling = ConfigHelper::getParam('file.storage')['local']['linkHandling'] ?? Local::DISALLOW_LINKS;
        $dto->writeFlags = ConfigHelper::getParam('file.storage')['local']['writeFlags'] ?? LOCK_EX;
        $store = new Storage($dto);
        $store->setAlias("local");
        return $store;
    }


    /**
     * @param $path
     * @param null $file
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function write($path, $file = null, $config = [])
    {
        if ($file == null) {
            $this->isFile();
            $file = $this->getFile();
        }

        /**
         * @var $file string|File|resource
         */
        if (is_a($file, File::class)) {
            $fileObject = $file;
            if (!$fileObject->exists()) {
                throw new FileException('File is not exists');
            }
            $file = $file->getStorage()->readStream();
        }
        if (is_resource($file)) {
            return $this->getFilesystem()->writeStream($path, $file, $config);
        }
        if (is_string($file)) {
            return $this->getFilesystem()->write($path, $file, $config);
        }
    }

    /**
     * @throws FileException
     */
    public function isFile()
    {
        if (!is_a($this->getFile(), File::class)) {
            throw new FileException("File is not exists");
        }
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->_file;
    }

    /**
     * @param File $file
     * @return File
     */
    public function setFile(File $file)
    {
        $this->_file = $file;
        return $this->getFile();
    }


    /**
     * @param null $path
     * @return bool|false|mixed|resource
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function readStream($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->readStream($path);
    }

    /**
     * @return Filesystem
     * @throws Exception\AdapterException
     */
    public function getFilesystem()
    {
        if (!is_object($this->_filesystem)) {
            $this->connection();
        }

        return $this->_filesystem;
    }

    /**
     * @param $path
     * @param $file
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function update($file, $path = null, $config = [])
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }

        /**
         * @var $file string|File|resource
         */
        if (is_a($file, File::class)) {
            $fileObject = $file;
            if (!$fileObject->exists()) {
                throw new FileException('File is not exists');
            }
            $file = $file->getStorage()->readStream();
        }
        if (is_resource($file)) {
            return $this->getFilesystem()->updateStream($path, $file, $config);
        }
        if (is_string($file)) {
            return $this->getFilesystem()->update($path, $file, $config);
        }
    }

    /**
     * @param $path
     * @param $file
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function put($path, $file = null, $config = [])
    {
        if ($file == null) {
            $this->isFile();
            $file = $this->getFile();
        }

        /**
         * @var $file string|File|resource
         */
        if (is_a($file, File::class)) {
            $fileObject = $file;
            if (!$fileObject->exists()) {
                throw new FileException('File is not exists');
            }
            $file = $file->getStorage()->readStream();
        }

        if (is_resource($file)) {
            return $this->getFilesystem()->putStream($path, $file, $config);
        }
        if (is_string($file)) {
            return $this->getFilesystem()->put($path, $file, $config);
        }
    }

    /**
     * @param $path
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function read($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->read($path);
    }

    /**
     * @param $path
     * @return bool
     * @throws Exception\AdapterException
     * @throws FileException
     */
    public function exists($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }

        return $this->has($path);
    }

    /**
     * @param $path
     * @return bool
     * @throws Exception\AdapterException
     */
    public function has($path = null)
    {
        return $this->getFilesystem()->has($path);
    }

    /**
     * @param $path
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function delete($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->delete($path);
    }

    /**
     * @param $path
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function readAndDelete($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->readAndDelete($path);
    }

    /**
     * @param $from
     * @param $to
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function rename($to, $from = null)
    {
        if ($from == null) {
            $this->isFile();
            $from = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->rename($from, $to);
    }

    /**
     * @param $from
     * @param $to
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function copy($to, $from = null)
    {
        if ($from == null) {
            $this->isFile();
            $from = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->copy($from, $to);
    }

    /**
     * @param $path
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function getMimetype($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->getMimetype($path);
    }

    /**
     * @param $path
     * @return bool|false|mixed|string
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function getTimestamp($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->getTimestamp($path);
    }

    /**
     * @param $path
     * @return bool|false|int
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileException
     */
    public function getSize($path = null)
    {
        if ($path == null) {
            $this->isFile();
            $path = $this->getFile()->getPath();
        }
        return $this->getFilesystem()->getSize($path);
    }

    /**
     * @param $path
     * @return bool
     * @throws Exception\AdapterException
     */
    public function createDir($path)
    {
        return $this->getFilesystem()->createDir($path);
    }

    /**
     * @param $path
     * @return bool
     * @throws Exception\AdapterException
     */
    public function deleteDir($path)
    {
        return $this->getFilesystem()->deleteDir($path);
    }

    /**
     * @param $path
     * @param bool $recursive
     * @return array
     * @throws Exception\AdapterException
     */
    public function listContents($path, $recursive = false)
    {
        return $this->getFilesystem()->listContents($path, $recursive);
    }

    /**
     * @return mixed
     * @throws Exception\AdapterException
     */
    public function getRoot()
    {
        if (is_a($this->getAdapter(), LocalAdapter::class)) {
            return ConfigHelper::getParam('file.storage')['local']['root'];
        }
        return $this->root;
    }

    /**
     * @param $value
     * @return mixed
     * @throws Exception\AdapterException
     */
    public function setRoot($value)
    {
        $this->root = $value;
        return $this->getRoot();
    }

    /**
     * @return mixed
     */
    public function getPublicRoot()
    {
        return $this->public_root;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setPublicRoot($value)
    {
        $this->public_root = $value;
        return $this->getPublicRoot();
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAlias($value)
    {
        return $this->alias = $value;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTag($value)
    {
        return $this->tag = $value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this->getType();
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this->getStatus();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this->getTemplate();
    }

}
