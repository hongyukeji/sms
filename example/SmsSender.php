<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/../src/Sms.php';

use HongYuKeJi\Helpers\Sms;

$config = $configs;

$sms = new Sms($config);

// templateCode + templateParam
$resultTemplateCode = $sms->send('13800138000', 'SMS_88888888', [
    'code' => '1234',
    'time' => '15分钟',
]);

var_dump($resultTemplateCode);

// templateContent + templateParam
$resultTemplateContent = $sms->send(['13800138000', '13900139000'], '您的验证码是%s。有效期为%s，请尽快验证！', [
    'code' => '1234',
    'time' => '15分钟',
], 'duanxinbao');

var_dump($resultTemplateContent);

// 返回值
$result = [
    'statusCode' => '0',
    'message' => '短信发送成功！',
];