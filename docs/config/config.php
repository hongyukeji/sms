<?php

$config = [
    'default' => [
        'gateway' => 'aliyun',
        //'returnDataType' => 'json',   // 默认返回数组格式
    ],
    'gateways' => [
        'aliyun' => [
            'accessKeyId' => '',
            'accessKeySecret' => '',
            'signName' => '',
            'templateCode' => [
                // 您的验证码是${code}。有效期为${time}，请尽快验证！
                'verificationCode' => 'SMS_88888888',
            ],
        ],
        'yunpian' => [
            'apikey' => '',
            'templateCode' => [
                // 您的验证码是#code#。有效期为#time#，请尽快验证！
                'verificationCode' => '',
            ],
        ],
        'qcloud' => [
            'appid' => '',
            'appkey' => '',
            'smsSign' => '',
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'duanxinbao' => [
            'user' => '',
            'pass' => '',
            'signName' => '',
            'templateCode' => [
                'verificationCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
        'submail' => [
            'appid' => '',
            'appkey' => '',
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'sendcloud' => [
            'sms_user' => '',
            'sms_key' => '',
            'templateCode' => [
                'verificationCode' => '',
            ],
        ],
        'ihuyi' => [
            'apiid' => '',
            'apikey' => '',
            'templateCode' => [
                // 您的验证码是【变量】。有效期为【变量】，请尽快验证！
                'verificationCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
            ],
        ],
    ],
];