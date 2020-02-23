<?php


namespace Yiisoft\Yii\File\Tests;

use Cycle\Bootstrap;
use Cycle\ORM\ORMInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Yiisoft\Di\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    public $container;
    /**
     * @var \Cycle\ORM\ORMInterface
     */
    public $orm;

    public function setUp(): void
    {
        parent::setUp();
        global $orm;
        $this->orm = $orm;
    }
}
