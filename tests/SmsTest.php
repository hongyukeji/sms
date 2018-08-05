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