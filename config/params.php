<?php
return [
    'file.storage' => [
            'local' => [
                'root' => '',
                'public_url' => '',
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
