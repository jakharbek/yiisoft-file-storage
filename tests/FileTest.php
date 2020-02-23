<?php


namespace Yiisoft\Yii\File\Tests;


use Cycle\ORM;
use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Adapter\LocalAdapter;
use Yiisoft\Yii\File\Dto\LocalAdapterDTO;
use Yiisoft\Yii\File\File;

class FileTest extends \Yiisoft\Yii\File\Tests\TestCase
{
    /**
     * @param $dto
     * @param $adapterClass
     * @throws \Yiisoft\Yii\File\Exception\AdapterException
     * @dataProvider getTestFactory
     */
    public function testFactory($dto, $adapterClass)
    {
        $adapter = AdapterFactory::create($dto);
        $this->assertInstanceOf($adapterClass, $adapter);
    }

    public function getTestFactory()
    {
        $data = [];

        $localDTO = new LocalAdapterDTO();
        $localDTO->root = "/test/static";
        $data[] = [$localDTO, LocalAdapter::class];

        return $data;
    }

    /**
     * @param $tmpName
     * @param $dirName
     * @param $baseName
     * @param $newPath
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \Throwable
     * @throws \Yiisoft\Factory\Exceptions\InvalidConfigException
     * @throws \Yiisoft\Factory\Exceptions\NotInstantiableException
     * @throws \Yiisoft\Yii\File\Exception\AdapterException
     * @dataProvider getUploadFile
     */
    public function testUploadFile($tmpName, $dirName, $baseName, $newPath, $ext)
    {
        $file = new File($tmpName, $this->orm);
        $this->assertTrue($file->exists());
        $this->assertIsString($file->getMimetype());
        $this->assertIsInt($file->getTimestamp());
        $this->assertIsInt($file->getSize());
        $this->assertEquals($ext, $file->getExtension());
        $this->assertEquals($dirName, $file->getDir());
        $this->assertEquals($baseName, $file->getBasename());
        $this->assertTrue($file->put($newPath));
        (new ORM\Transaction($this->orm))->persist($file)->run();
    }

    public function testInstance()
    {

        $_FILES = [
            'profile-image' => [
                'name' => 'test-file-2.txt',
                'type' => 'text/plain',
                'tmp_name' => '/var/www/html/tests/data/files/test-file-2.txt',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
        ];
        $file = new File('$profile-image', $this->orm);
        $this->assertTrue($file->put('files-file-2.txt'));
        (new ORM\Transaction($this->orm))->persist($file)->run();
    }

    public function getUploadFile()
    {
        return [
            ['/var/www/html/tests/data/files/test-file-1.txt', '/var/www/html/tests/data/files', 'test-file-1.txt', 'test-file-1.txt', 'txt'],
        ];
    }

    public function testUploadFileSftp()
    {
        $_FILES = [
            'profile-image' => [
                'name' => 'test-file-2.txt',
                'type' => 'text/plain',
                'tmp_name' => '/var/www/html/tests/data/files/test-file-2.txt',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
        ];
        $file = new File('$profile-image', $this->orm);
        $file->setStorage('#picture');
        $this->assertTrue($file->put('files-file-new-2.txt'));
    }

    public function testUploadFileTemplate()
    {
        $_FILES = [
            'profile-image' => [
                'name' => 'test-file-2.txt',
                'type' => 'text/plain',
                'tmp_name' => '/var/www/html/tests/data/files/test-file-2.txt',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
        ];
        $file = new File('$profile-image', $this->orm);
        $file->setStorage('other2');
        $this->assertTrue($file->put('file-doc'));
        (new ORM\Transaction($this->orm))->persist($file)->run();
    }

    public function testUploadFileWithoutFilename()
    {
        $_FILES = [
            'profile-image' => [
                'name' => 'test-file-2.txt',
                'type' => 'text/plain',
                'tmp_name' => '/var/www/html/tests/data/files/test-file-2.txt',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
        ];
        $file = new File('$profile-image', $this->orm);
        $file->setStorage('other2');
        $this->assertTrue($file->put());
        (new ORM\Transaction($this->orm))->persist($file)->run();
    }

    public function testDelete()
    {
        $_FILES = [
            'profile-image' => [
                'name' => 'test-file-2-122.txt',
                'type' => 'text/plain',
                'tmp_name' => '/var/www/html/tests/data/files/test-file-2.txt',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
        ];
        $file = new File('$profile-image', $this->orm);
        $this->assertTrue($file->put(null,"other2"));
        (new ORM\Transaction($this->orm))->persist($file)->run();
    }

}
