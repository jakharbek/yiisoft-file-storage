<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */


namespace Yiisoft\Yii\File\Repository;

use Cycle\ORM\Select\Repository;
use Yiisoft\Yii\File\Storage;

/**
 * Class StorageRepository
 * @package Yiisoft\Yii\File\Repository
 */
class StorageRepository extends Repository
{
    /**
     * @param $alias
     * @return Storage|null
     * @throws \Exception
     */
    public function getByAlias($alias): ?Storage
    {
        ;
        $storage = $this->findOne(['alias' => $alias]);
        if (!is_a($storage, Storage::class)) {
            throw new \Exception("Storage is not founded");
        }
        return $storage;
    }

    /**
     * @param $tag
     * @return Storage|null
     * @throws \Exception
     */
    public function getByTag($tag): ?Storage
    {
        $storage = $this->select
            ->andWhere(['tag' => $tag]);

        $storages = $storage->fetchAll();
        $storage = $storages[array_rand($storages)];
        if (!is_a($storage, Storage::class)) {
            throw new \Exception("Storage is not founded");
        }
        return $storage;
    }
}
