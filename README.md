<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://github.com/yiisoft.png" height="100px">
    </a>
    <h1 align="center">Yii File</h1>
    <br>
</p>

The package Yii File

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
"yiisoft/yii-file": "*"
```

to the require section of your `composer.json` file.

### Directory Structure

```
config/                                             configuration
docs/                                               documentation
src/                                                source code
        Adapter/                                    Adapters
        DTO/                                        DTOs
        Exception/                                  Exceptions
        Helper/                                     Helpers
        Repository/                                 Repositories
tests/                                              tests
```

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
 after the scheme has been updated you can add your other storage servers.

Storage
---
you should use the repository entity to create an instance of it fill the constructor

```php
use Yiisoft\Yii\File\Storage;
use Yiisoft\Yii\File\Adapter\AdapterFactory;
use Yiisoft\Yii\File\Dto\SftpAdapterDTO;

$dto = new SftpAdapterDTO();
$dto->host = "host";
$dto->username = "username";
$dto->password = "password";
$dto->root = "/www/html/cdn.site.domain/static";
$adapter = AdapterFactory::create($dto);

$storage = new Storage($adapter);
$storage->setPublicUrl("http://cdn.site.domain/");
$storage->setAlias("cdn.site.domain");
$storage->setTag('image');
$storage->setTemplate('/:year/:month/:day/:hour/:minute/:second/');

```
and save in cycle orm

now you have two repositories registered, one local by default, the other on a completely different server

`if a template is specified at the repository then files will be downloaded according to this template it is optional it can be omitted`

File
-----------
Once we have identified all of our file vaults,
now let's upload files to our servers

for this we need a class `Yiisoft\Yii\File\File` and now you need to create a new object of this class
the constructor should specify the path to the (temporary) file or the name of the super-global $_FILES array
```php
use Yiisoft\Yii\File\File;

$file = new File('/var/www/html/tests/data/files/test-file-2.txt');
```

for to specify a superglobal array, display the name of the array key with the dollar ($) prefix
For example
```html
<input name="avatar" type="file" />
```
```php
use Yiisoft\Yii\File\File;
 
$file = new File('$avatar');
```

Now, using the method `put`, we can save the resulting file to one of our previously defined storage servers
we can ask the server how, by tags, he will randomly select a server with such tags and upload a file there, or by alias in this case, he select one specific server
the first argument takes what the name will be and the second argument on which server to upload the file

for example tag:
```php
use Yiisoft\Yii\File\File;
 
$file = new File('$avatar');
$file->put('user-avatar',"#image");
````

for example alias:
```php
use Yiisoft\Yii\File\File;
 
$file = new File('$avatar');
$file->put('user-avater',"cdn.site.domain");
```
now he uploaded the file to the server but at the moment did not save this file in the database in the file table

Now, in order to save in the database, use the features Cycle ORM
```php 
use Yiisoft\Yii\File\File;
 
$file = new File('$avatar');
$file->put('user-avater',"cdn.site.domain"); 
(new ORM\Transaction($this->orm))->persist($file)->run();
```


Read (get)
----
For a list of files, use the features Cycle ORM, `file` and `storag` are entities.

Delete
----
```php
$file->delete();
```

Adapters
----

AWS S3 - `Yiisoft\Yii\File\Adapter\AwsS3Adapter`

Azure - `Yiisoft\Yii\File\Adapter\AzureAdapter`

Cached - `Yiisoft\Yii\File\Adapter\CachedAdapter`

Digital Ocean - `Yiisoft\Yii\File\Adapter\DigitalOceanSpacesAdapter`

Dropbox - `Yiisoft\Yii\File\Adapter\DropboxAdapter`

FTP - `Yiisoft\Yii\File\Adapter\FtpAdapter`

Gitlab - `Yiisoft\Yii\File\Adapter\GitlabAdapter`

Google Cloud Storage - `Yiisoft\Yii\File\Adapter\GoogleStorageAdapter`

Local - `Yiisoft\Yii\File\Adapter\LocalAdapter`

Memory - `Yiisoft\Yii\File\Adapter\MemoryAdapter`

Null - `Yiisoft\Yii\File\Adapter\NullAdapter`

Rackspace - `Yiisoft\Yii\File\Adapter\RackspaceAdapter`

Replicate - `Yiisoft\Yii\File\Adapter\ReplicateAdapter`

Scaleway - `Yiisoft\Yii\File\Adapter\ScalewayObjectStorageAdapter`

SFTP - `Yiisoft\Yii\File\Adapter\SftpAdapter`

WebDAV - `Yiisoft\Yii\File\Adapter\WebDAVAdapter`

Zip - `Yiisoft\Yii\File\Adapter\ZipArchiveAdapter`

To get a copy of these adapters, you can get directly but the best use the factory `Yiisoft\Yii\File\Adapter\AdapterFactory`
he takes as an argument DTO.

Other features
----
there are many other possibilities besides you can see it in the class `Yiisoft\Yii\File\File` , `Yiisoft\Yii\File\Storage` and `Yiisoft\Yii\File\Adapter\AdapterFactory` and other sources

