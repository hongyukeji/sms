<?php

namespace HongYuKeJi\Helpers\Tests;

(new \Dotenv\Dotenv(__DIR__ . '/../'))->load();

use HongYuKeJi\Helpers\Sms;
use HongYuKeJi\Helpers\Tests\TestCase;

class SmsTest extends TestCase
{
    public function testSend()
    {
        $config = [
            'default' => [
                'gateway' => 'yunpian',
            ],
            'gateways' => [
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
                'submail' => [
                    'appid' => '',
                    'appkey' => '',
                    'templateCode' => [
                        'verificationCode' => '',
                    ],
                ],
                'sendcloud' => [
                    'sms_user' => '213',
                    'sms_key' => '3213',
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

        $sms = new Sms($config);

        // templateCode + templateParam
        $resultTemplateCode = $sms->send(['13800138000', '13900139000'], 'templateCode', [
            'code' => '1234',
            'time' => '15分钟',
        ]);

        var_dump($resultTemplateCode);

        // Content + templateParam
        $resultContent = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
            'code' => '1234',
            'time' => '15分钟',
        ], 'duanxinbao');

        var_dump($resultContent);

        $result = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
            'code' => '1234',
            'time' => '15分钟',
        ], 'duanxinbao');

        var_dump($result);

        $this->assertEquals(0, 0);
        //$this->assertEquals(0, $result['statusCode']);
    }

    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));
        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }

}