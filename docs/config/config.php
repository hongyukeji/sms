<?php

$config = [
    'yunpian' => [
        'apikey' => '',
        'templateCode' => [
            // 您的验证码是#code#。有效期为#time#，请尽快验证！
            'verificationCode' => '',
        ],
    ],
    'aliyun' => [
        'accessKeyId' => '',
        'accessKeySecret' => '',
        'signName' => '',
        'templateCode' => [
            // 您的验证码是${code}。有效期为${time}，请尽快验证！
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
];