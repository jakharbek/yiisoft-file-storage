<?php


namespace Yiisoft\File\Tests;


use PHPUnit\Framework\TestCase;
use Yiisoft\File\Adapter\AdapterFactory;
use Yiisoft\File\Adapter\LocalAdapter;
use Yiisoft\File\Dto\LocalAdapterDTO;
use Yiisoft\File\Helper\AdapterHelper;

class FileStorageTest extends TestCase
{

    /**
     * @param $dto
     * @param $adapterClass
     * @throws \Yiisoft\File\Exception\AdapterException
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
