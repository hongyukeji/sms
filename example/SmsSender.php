<?php
/**
 * sms
 * ============================================================================
 * Copyright © 2015-2018 HongYuKeJi.Co.Ltd. All rights reserved.
 * Http://www.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 堂堂正正做人，踏踏实实做事。
 * ----------------------------------------------------------------------------
 * Author: Shadow  QQ: 1527200768  Time: 2018/8/4 20:23
 * E-mail: admin@hongyuvip.com
 * ============================================================================
 */

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
            'apikey' => '',
        ],
        'aliyun' => [
            'accessKeyId' => '',
            'accessKeySecret' => '',
            'signName' => '',
        ],
        'qcloud' => [
            'appid' => '',
            'appkey' => '',
            'smsSign' => '',
        ],
        'duanxinbao' => [
            'user' => '',
            'pass' => '',
            'signName' => '',
        ],
        'submail' => [
            'appid' => '',
            'appkey' => '',
        ],
        'sendcloud' => [
            'sms_user' => '',
            'sms_key' => '',
        ],
        'ihuyi' => [
            'apiid' => '',
            'apikey' => '',
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
$resultTemplateContent = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
    'code' => '1234',
    'time' => '15分钟',
], 'aliyun');

var_dump($resultTemplateContent);
