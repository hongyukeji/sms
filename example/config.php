<?php

(new \Dotenv\Dotenv(__DIR__ . '/../'))->load();

$configs = [
    'default' => [
        'gateway' => 'aliyun',
    ],
    'gateways' => [
        'aliyun' => [
            'accessKeyId' => getenv('ALIYUN_ACCESSKEYID'),
            'accessKeySecret' => getenv('ALIYUN_ACCESSKEYSECRET'),
            'signName' => getenv('ALIYUN_SIGNNAME'),
            'templateCode' => [
                // 您的验证码是${code}。有效期为${time}，请尽快验证！
                'verificationCode' => '',
            ],
        ],
        'yunpian' => [
            'apikey' => getenv('YUNPIAN_APIKEY'),
            'templateCode' => [
                // 您的验证码是#code#。有效期为#time#，请尽快验证！
                'verificationCode' => '',
            ],
        ],
        'qcloud' => [
            'appid' => getenv('QCLOUD_APPID'),
            'appkey' => getenv('QCLOUD_APPKEY'),
            'smsSign' => getenv('QCLOUD_SMSSIGN'),
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'duanxinbao' => [
            'user' => getenv('DUANXINBAO_USER'),
            'pass' => getenv('DUANXINBAO_PASS'),
            'signName' => getenv('DUANXINBAO_SIGNNAME'),
            'templateCode' => [
                'verificationCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
        'submail' => [
            'appid' => getenv('SUBMAIL_APPID'),
            'appkey' => getenv('SUBMAIL_APPKEY'),
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'sendcloud' => [
            'sms_user' => getenv('SENDCLOUD_SMS_USER'),
            'sms_key' => getenv('SENDCLOUD_SMS_KEY'),
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'ihuyi' => [
            'apiid' => getenv('IHUYI_APIID'),
            'apikey' => getenv('IHUYI_APIKEY'),
            'templateCode' => [
                // 您的验证码是【变量】。有效期为【变量】，请尽快验证！
                'verificationCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
    ],
];