<?php

namespace HongYuKeJi\Helpers\Tests;

require_once dirname(__FILE__) . '/../example/config.php';

use HongYuKeJi\Helpers\Sms;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
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

        //var_dump($resultTemplateCode);
        $this->log()->info('resultTemplateCode', $resultTemplateCode);

        // Content + templateParam
        $resultContent = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
            'code' => '1234',
            'time' => '15分钟',
        ], 'duanxinbao');

        //var_dump($resultContent);
        $this->log()->info('resultContent', $resultContent);

        $result = $sms->send('13800138000', '您的验证码是%s。有效期为%s，请尽快验证！', [
            'code' => '1234',
            'time' => '15分钟',
        ], 'duanxinbao');

        //var_dump($result);
        $this->log()->info('result', $result);

        $this->assertEquals(0, 0);
        //$this->assertEquals(0, $result['statusCode']);
    }

    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
        array_push($stack, 'foo');

        //$this->log()->info('info', $stack);

        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));
        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }

    public function log()
    {
        $logger = new Logger('sms_logger');
        // Now add some handlers
        try {
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::DEBUG));
        } catch (\Exception $e) {
            print_r($e);
        }
        // You can now use your logger
        //$logger->info('My logger is now ready');
        return $logger;
    }
}