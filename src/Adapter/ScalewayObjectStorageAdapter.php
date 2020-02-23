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
 * This class of adapter for working with Scaleway
 * To work with this adapter, pass @see \Yiisoft\Yii\File\Dto\ScalewayObjectStorageAdapterDTO
 * This class extends the flysystem class, for more information about the adapter
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/scaleway-object-storage/
 * @see https://flysystem.thephpleague.com/v1/docs/adapter/aws-s3-v2/
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3/blob/master/src/AwsS3Adapter.php
 * @see https://github.com/thephpleague/flysystem-aws-s3-v3
 *
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
