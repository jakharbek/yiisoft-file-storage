<?php


namespace Yiisoft\File\Adapter;

use Yiisoft\File\Helper\AdapterHelper;

/**
 * Class DigitalOceanSpacesAdapter
 * @package Yiisoft\File\Adapter
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
