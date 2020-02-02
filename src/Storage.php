<?php


namespace Yiisoft\File;


use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Yiisoft\File\Adapter\AdapterFactory;

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

}
