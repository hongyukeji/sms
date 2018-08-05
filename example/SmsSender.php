<?php

use HongYuKeJi\Helpers\Sms;

require_once dirname(__FILE__) . '/../src/Sms.php';
require_once dirname(__FILE__) . '/../vendor/autoload.php';
(new \Dotenv\Dotenv(__DIR__ . '/../'))->load();

$config = [
    'default' => [
        'gateway' => 'yunpian',
    ],
    'gateways' => [
        'yunpian' => [
            'apikey' => getenv('YUNPIAN_APIKEY'),
            'templateCode' => [
                // 您的验证码是#code#。有效期为#time#，请尽快验证！
                'verificationCode' => '',
            ],
        ],
        'aliyun' => [
            'accessKeyId' => getenv('ALIYUN_ACCESSKEYID'),
            'accessKeySecret' => getenv('ALIYUN_ACCESSKEYSECRET'),
            'signName' => getenv('ALIYUN_SIGNNAME'),
            'templateCode' => [
                // 您的验证码是${code}。有效期为${time}，请尽快验证！
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

$sms = new Sms($config);

// templateCode + templateParam
/*$resultTemplateCode = $sms->send(['13800138000', '13900139000'], 'templateCode', [
    'code' => '1234',
    'time' => '15分钟',
]);

var_dump($resultTemplateCode);*/

// Content + templateParam
$resultTemplateContent = $sms->send('13800138000', '11111', [
    'code' => '1234',
    'time' => '15分钟',
], 'sendcloud');

var_dump($resultTemplateContent);
