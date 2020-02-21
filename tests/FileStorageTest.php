<?php


namespace Yiisoft\Yii\File\Tests;


use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Adapter\LocalAdapter;
use Yiisoft\Yii\File\Dto\LocalAdapterDTO;
use Yiisoft\Yii\File\Helper\AdapterHelper;

class FileStorageTest extends TestCase
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
}
