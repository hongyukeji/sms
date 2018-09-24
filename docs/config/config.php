<?php

$config = [
    'default' => [
        'gateway' => 'aliyun',
    ],
    'gateways' => [
        'aliyun' => [
            'accessKeyId' => '',
            'accessKeySecret' => '',
            'signName' => '',
            'templateCode' => [
                // 您的验证码是${code}。有效期为${time}，请尽快验证！
                'verifyCode' => 'SMS_88888888',
            ],
        ],
        'yunpian' => [
            'apikey' => '',
            'templateCode' => [
                // 您的验证码是#code#。有效期为#time#，请尽快验证！
                'verifyCode' => '',
            ],
        ],
        'qcloud' => [
            'appid' => '',
            'appkey' => '',
            'smsSign' => '',
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'duanxinbao' => [
            'user' => '',
            'pass' => '',
            'signName' => '',
            'templateCode' => [
                'verifyCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
        'submail' => [
            'appid' => '',
            'appkey' => '',
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'sendcloud' => [
            'sms_user' => '',
            'sms_key' => '',
            'templateCode' => [
                'verifyCode' => '',
            ],
        ],
        'ihuyi' => [
            'apiid' => '',
            'apikey' => '',
            'templateCode' => [
                // 您的验证码是【变量】。有效期为【变量】，请尽快验证！
                'verifyCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
    ],
];