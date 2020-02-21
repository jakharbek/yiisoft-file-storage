<?php


namespace Yiisoft\File\Tests;


use PHPUnit\Framework\TestCase;
use Yiisoft\File\Helper\ConfigHelper;

class ConfiguratinTest extends TestCase
{
    public function testPrams()
    {
        ConfigHelper::getParams();
        $this->assertIsArray(ConfigHelper::getParams());
    }

    public function testPram()
    {
        $this->assertIsArray(ConfigHelper::getParam("file.storage"));
    }
}
