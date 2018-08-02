<?php
/**
 * sms
 * ============================================================================
 * Copyright © 2015-2018 HongYuKeJi.Co.Ltd. All rights reserved.
 * Http://www.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 堂堂正正做人，踏踏实实做事。
 * ----------------------------------------------------------------------------
 * Author: Shadow  QQ: 1527200768  Time: 2018/8/2 23:40
 * E-mail: admin@hongyuvip.com
 * ============================================================================
 */

namespace HongYuKeJi\Helpers\Tests;

use HongYuKeJi\Helpers\Sms;

class SmsTest
{
    public function send()
    {
        $config = [
            'yunpian' => [
                'apikey' => '',
                'templateCode' => [
                    // 您的验证码是#code#。有效期为#hour#，请尽快验证！
                    'verificationCode' => '2414994',
                ],
            ],
            'aliyun' => [
                'accessKeyId' => '',
                'accessKeySecret' => '',
                'signName' => '',
                'templateCode' => [
                    // 您的验证码是${code}。有效期为${hour}，请尽快验证！
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

        $defaultSms = 'yunpian';

        $sms = new Sms($config, $defaultSms);

        // templateCode + templateParam
        $result = $sms->send(['13800138000', '13900139000'], 'templateCode', [
            'code' => '1234',
            'hour' => '15分钟',
        ]);

        // Content + templateParam
        $result = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
            'code' => '1234',
            'hour' => '15分钟',
        ], 'duanxinbao');

        var_dump($result);
    }
}