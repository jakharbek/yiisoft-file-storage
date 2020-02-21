<?php


namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * Class DigitalOceanSpacesAdapter
 * @package Yiisoft\Yii\File\Adapter
 */
class DigitalOceanSpacesAdapter extends AwsS3Adapter
{
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
