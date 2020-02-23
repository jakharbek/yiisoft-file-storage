<?php
require_once "vendor/autoload.php";

use Cycle\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader('class_exists');

$config = Bootstrap\Config::forDatabase(
    'sqlite:tests/test.db', // connection dsn
    '',                   // username
    ''                    // password
);

$config = $config->withEntityDirectory(__DIR__ . DIRECTORY_SEPARATOR . '../src');
return Bootstrap\Bootstrap::fromConfig($config);
