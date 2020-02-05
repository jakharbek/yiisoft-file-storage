<?php


namespace Yiisoft\File\Repository;

use Cycle\ORM\Select\Repository;
use Yiisoft\File\File;
use Yiisoft\File\Storage;

/**
 * Class StorageRepository
 * @package Yiisoft\File\Repository
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
            ->andWhere(['tag' => $tag])
            ->orderBy('id', 'RAND()');
        if (!is_a($storage, Storage::class)) {
            throw new \Exception("Storage is not founded");
        }
        return $storage;
    }

    public function test()
    {

    }
}
