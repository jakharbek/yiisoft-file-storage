<?php

use Cycle\Bootstrap;
use Cycle\ORM\ORMInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use hiqdev\composer\config\Builder;
use Yiisoft\Di\Container;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Don't do it in production, assembling takes it's time
Builder::rebuild();
AnnotationRegistry::registerLoader('class_exists');

$config = Bootstrap\Config::forDatabase(
    'sqlite:tests/test.db', // connection dsn
    '',                   // username
    ''                    // password
);

$config = $config->withEntityDirectory(__DIR__ . DIRECTORY_SEPARATOR . '../src');
$orm = Bootstrap\Bootstrap::fromConfig($config);
