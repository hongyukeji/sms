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
                'verifyCode' => '',
            ],
        ],
        'yunpian' => [
            'apikey' => getenv('YUNPIAN_APIKEY'),
            'templateCode' => [
                // 您的验证码是#code#。有效期为#time#，请尽快验证！
                'verifyCode' => '',
            ],
        ],
        'qcloud' => [
            'appid' => getenv('QCLOUD_APPID'),
            'appkey' => getenv('QCLOUD_APPKEY'),
            'smsSign' => getenv('QCLOUD_SMSSIGN'),
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'duanxinbao' => [
            'user' => getenv('DUANXINBAO_USER'),
            'pass' => getenv('DUANXINBAO_PASS'),
            'signName' => getenv('DUANXINBAO_SIGNNAME'),
            'templateCode' => [
                'verifyCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
        'submail' => [
            'appid' => getenv('SUBMAIL_APPID'),
            'appkey' => getenv('SUBMAIL_APPKEY'),
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'sendcloud' => [
            'sms_user' => getenv('SENDCLOUD_SMS_USER'),
            'sms_key' => getenv('SENDCLOUD_SMS_KEY'),
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'ihuyi' => [
            'apiid' => getenv('IHUYI_APIID'),
            'apikey' => getenv('IHUYI_APIKEY'),
            'templateCode' => [
                // 您的验证码是【变量】。有效期为【变量】，请尽快验证！
                'verifyCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
        'chuanglan' => [
            'api_send_url' => 'http://smssh1.253.com/msg/send/json',
            'api_variable_url' => 'http://smssh1.253.com/msg/variable/json',
            'api_balance_query_url' => 'http://smssh1.253.com/msg/balance/json',
            'api_account' => '',
            'api_password' => '',
            'sms_sign' => '',
            'templateCode' => [
                'verifyCode' => '您的验证码是{$var}。有效期为15分钟，请尽快验证！',
            ],
        ],
    ],
];