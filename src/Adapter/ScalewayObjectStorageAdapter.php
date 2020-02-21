<?php


namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class ScalewayObjectStorageAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class ScalewayObjectStorageAdapter extends AwsS3Adapter
{
    /**
     * @param array $configuration
     */
    protected function validation(array $configuration)
    {
        AdapterHelper::validation([
            'credentials' => ['key', 'secret'],
            'region',
            'version',
            'bucket',
            'endpoint'
        ], $configuration);
    }
}
