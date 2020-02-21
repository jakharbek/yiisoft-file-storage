<?php
return [
    'file.storage' => [
            'local' => [
                'root' => '',
                'public_url' => '',
                [
                    'file' => [
                        'public' => 0644,
                        'private' => 0600,
                    ],
                    'dir' => [
                        'public' => 0755,
                        'private' => 0700,
                    ],
                ]
            ],
    ],
    'cycle.dbal' => [
        'default' => 'default',
        'aliases' => [],
        'databases' => [
            'default' => ['connection' => 'sqlite']
        ],
        'connections' => [
            'sqlite' => [
                'driver' => \Spiral\Database\Driver\SQLite\SQLiteDriver::class,
                'connection' => 'sqlite:/var/www/html/src/tests/db',
                'username' => '',
                'password' => '',
            ]
        ],
    ],

    # Общий конфиг Cycle
    'cycle.common' => [
        # Список путей к папкам с файлами миграций
        'entityPaths' => [
            '/var/www/html/src'
        ],

        # Включить использование кеша при получении схемы БД
        'cacheEnabled' => false,
        # Ключ, используемый при кешировании схемы
        'cacheKey' => 'Cycle-ORM-Schema',

        # Дополнительные генераторы, запускаемые при расчёте схемы
        # Массив определений \Cycle\Schema\GeneratorInterface
        'generators' => [
            # Генератор SyncTables позволяет без миграций вносить изменения схемы в БД
            // \Cycle\Schema\Generator\SyncTables::class,
        ],

        # Определение класса \Cycle\ORM\PromiseFactoryInterface
        'promiseFactory' => null, # использовать объекты Promise
        # Для использования фабрики ProxyFactory необходимо подключить пакет cycle/proxy-factory
        // 'promiseFactory' => \Cycle\ORM\Promise\ProxyFactory::class,

        # Логгер SQL запросов
        # Определение класса \Psr\Log\LoggerInterface
        'queryLogger' => null,
        # Вы можете использовать класс \Yiisoft\Yii\Cycle\Logger\StdoutQueryLogger
        # чтобы выводить SQL лог в stdout
        // 'queryLogger' => \Yiisoft\Yii\Cycle\Logger\StdoutQueryLogger::class,
    ],

    # Конфиг миграций
    'cycle.migrations' => [
        'directory' => '/var/www/html/src/migrations',
        'namespace' => 'Yiisoft\\File\\Migration',
        'table' => 'migration',
        'safe' => false,
    ],
];
