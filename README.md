<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://github.com/yiisoft.png" height="100px">
    </a>
    <h1 align="center">Yii File</h1>
    <br>
</p>

The package File Storage System

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii-file/v/stable.png)](https://packagist.org/packages/yiisoft/yii-file)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii-file/downloads.png)](https://packagist.org/packages/yiisoft/yii-file)
[![Build Status](https://travis-ci.com/yiisoft/yii-file.svg?branch=master)](https://travis-ci.com/yiisoft/_____)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/yii-file/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/yii-file/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/yii-file/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/yii-file/?branch=master)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisoft/yii-file
```

or add

```
"yiisoft/file": "*"
```

to the require section of your `composer.json` file.

Basic Usage
-----------

The package basis of this extension is `flysystem` from `league`, you can read more about it in the documentation at the link below https://flysystem.thephpleague.com/

with this package you can upload your files to almost any type of server and manage and manage them, move and delete, get the list of downloaded files to the server and migrate them to another server, all files and the list of your servers in the system are stored in the database

first you need to fill in the local storage parameters

```php
return [
    'file.storage' => [
            'local' => [
                'root' => '/var/www/html/yoursite.domain/static',
                'public_url' => 'http://cdn.yoursite.domain/',
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
    ]
];
```

Now you need to update the database schema and get a new table
 after the scheme has been updated you can add your other storage servers if they exist in the table `storage`

you should use the repository entity to create an instance of it fill the constructor

```php
use Yiisoft\Yii\File\Storage;
use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;

$dto = new SftpAdapterDTO();
$dto->host = "host";
$dto->username = "username";
$dto->password = "password";
$dto->root = "/www/html/yoursite2.domain/static";

$adapter = AdapterFactory::create($dto);

$storage = new Storage($adapter);
$storage->setPublicUrl("http://cdn.yoursite2.domain/");
$storage->setAlias("yoursite2");
$storage->setTag('imageServer');
```
and save in cycle orm

now you have two repositories registered, one local by default, the other on a completely different server

Upload File from $_FILES
-----------
`profile-image` is sent file and is index in $_FILES 
```php
use Yiisoft\Yii\File\File;
//one
$file = File::getInstanceByFilesArray('profile-image');
$file->put('/profile/image/1.jpg');//local storage

$file = File::getInstanceByFilesArray('profile-image');
$file->put('/profile/image/1.jpg','imageServer');//anyone server by tag
//more
$files_array = File::getInstancesByFilesArray('profiles-image');

foreach($files_array as $file){
    $file = File::getInstanceByFilesArray('profile-image');
    $file->put('/profile/image/1.jpg','imageServer');//anyone server by tag
}
```
