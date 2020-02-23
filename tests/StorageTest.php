<?php


namespace Yiisoft\Yii\File\Tests;


use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;
use Yiisoft\Yii\File\Storage;
use Cycle\ORM\ORMInterface;
use Cycle\ORM;


class StorageTest extends TestCase
{
    public function testCreate()
    {
        $dto = new SftpAdapterDTO();
        $dto->root = "/var/www/html/tests/static/other";
        $dto->username = "root";
        $dto->password = "screencast";
        $dto->host = "other";
        $storage = new Storage($dto);
        $storage->setPublicRoot('http://other/');
        $storage->setAlias('other1');
        $storage->setType("picture");
        $storage->setTag("picture");
        $storage->setStatus(1);
        (new ORM\Transaction($this->orm))->persist($storage)->run();
        $this->assertIsInt($storage->getId());

    }

    public function testCreateWithTemplate()
    {
        $dto = new SftpAdapterDTO();
        $dto->root = "/var/www/html/tests/static/other";
        $dto->username = "root";
        $dto->password = "screencast";
        $dto->host = "other";
        $storage = new Storage($dto);
        $storage->setPublicRoot('http://other/');
        $storage->setAlias('other2');
        $storage->setType("picture");
        $storage->setTag("picture");
        $storage->setTemplate('/:year/:month/:day/:hour/:minute/:second/');
        $storage->setStatus(1);
        (new ORM\Transaction($this->orm))->persist($storage)->run();
        $this->assertIsInt($storage->getId());

    }
}
