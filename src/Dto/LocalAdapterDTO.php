<?php
namespace Yiisoft\File\Dto;

use League\Flysystem\Adapter\Local;

/**
 * Class LocalAdapterDTO
 * @package Dto
 */
class LocalAdapterDTO
{
    /**
     * Path to the root directory of files
     *
     * @example /var/www/html/static
     *
     * @var string
     */
    public $root;

    /**
     * By default this adapter uses a lock during writes and updates.
     * This behaviour can be altered using 0 argument.
     *
     * @var int
     */
    public $writeFlags = LOCK_EX;

    /**
     * The Local adapter doesn’t support links,
     * this violates the root path constraint which is enforced throughout Flysystem.
     * By default, when links are encountered an exception is thrown.
     * This behaviour can be altered using argument Local::SKIP_LINKS.
     *
     * @var int
     */
    public $linkHandling = Local::DISALLOW_LINKS;

    /**
     * you can set default file and directory permissions.
     *
     * @var array
     */
    public $permissions = [
        'file' => [
            'public' => 0644,
            'private' => 0600,
        ],
        'dir' => [
            'public' => 0755,
            'private' => 0700,
        ],
    ];
}
