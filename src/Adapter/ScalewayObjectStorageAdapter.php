<?php


namespace Yiisoft\File\Adapter;

use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class ScalewayObjectStorageAdapter
 * @package Yiisoft\File\Adapter
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
