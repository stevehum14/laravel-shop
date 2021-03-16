<?php

return [
    'alipay' => [
        'app_id'         => '2016092000554679',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7TxbvO7m7vmsuxuW+2vp4adxIAYd9uj8Tc2FOU6FjQZOepBsYV0lXe8zo32gjdqI81lJ7R7EBxCNu+rkGN+aedQGppeBXjMd5dfLZvajE1JowwnW2F4RZBLMHGk8c4HGgIQDkT5LwiB0urVVjbMZY9osYvIZfi7BXQJybJaoa9b2dcmhw+Lut55YUHm91lg3AATHk4xokRnLfx0di60c0Y/wONEck3mJ7hRRo75+CUhKxXWzkBK/DsQMhOsRG2BPPq0lDW5o6UPIh8cAwAIzfuVJZSOqjC7QNS3wDfzbEVSyyZ26LTvT2ofEZnvIk/oRp+j/gK3AjsHUfC20pPWPyQIDAQAB',
        'private_key'    => '',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
