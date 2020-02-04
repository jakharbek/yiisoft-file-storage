<?php


namespace Yiisoft\File;


use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Yiisoft\File\Adapter\AdapterFactory;
use Yiisoft\File\Dto\LocalAdapterDTO;
use Yiisoft\File\Exception\FileException;
use Yiisoft\File\Helper\ConfigHelper;

/**
 * Class Storage
 * @package Yiisoft\File
 * @Entity(repository = "Yiisoft/File/Repository/StorageRepository")
 */
class Storage
{

    /**
     * @Column(type = "primary")
     */
    protected $id;

    /**
     * @Column(type = "string(255)", nullable = false)
     */
    protected $alias;

    /**
     * @Column(type = "text", nullable = true)
     */
    protected $type;

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
        $this->connectionParams = (strlen($params) == 0) ? null : serialize($params);
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
     * @param $path
     * @param $file
     * @param array $config
     * @return bool
     * @throws Exception\AdapterException
     * @throws \League\Flysystem\FileExistsException
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
     * @param $path
     * @return bool|false|mixed|resource
     * @throws Exception\AdapterException
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
        return new Storage($dto);
    }
}
