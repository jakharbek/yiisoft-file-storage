<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2020 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Jakharbek <jakharbek@gmail.com>
 */

namespace Yiisoft\Yii\File\Adapter;

use Yiisoft\Yii\File\Helper\AdapterHelper;

/**
 * This class of adapter for working with Digital Ocean
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\DigitalOceanSpacesAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/digitalocean-spaces/
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/aws-s3-v2/
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3/blob/master/src/AwsS3Adapter.php
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3
 *
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
