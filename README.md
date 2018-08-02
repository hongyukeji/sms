<h1 align="center">SMS</h1>

<p align="center">
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/license" alt="License"></a>
</p>

> 支持全网短信发送，自由扩展，无缝对接。更多请点击[https://www.hongyuvip.com](https://www.hongyuvip.com)

## 特点

- 支持全网络短信服务商
- 支持自由扩展且易维护

## 支持

- [阿里云](https://www.aliyun.com)
- [云片](https://www.yunpian.com)
- [腾讯](https://cloud.tencent.com/product/sms)
- [短信宝](http://www.smsbao.com)
- 其他短信服务商快速集成（参考《宏观设计模式》 --- 鸿宇科技出品）

## 环境

- PHP >= 5.6.0

## 安装

```shell
$ composer require hongyukeji/sms
```

## 使用

```php
use HongYuKeJi\Helpers\Sms;

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
```

## 维护

- Author：Shadow
- QQ：[1527200768](http://wpa.qq.com/msgrd?v=3&uin=1527200768&site=qq&menu=yes)
- Email：[admin@hongyuvip.com](mailto:admin@hongyuvip.com)
- QQ交流群：[90664526](http://shang.qq.com/wpa/qunwpa?idkey=a3e498d7d3329615c9b3d1dbbbc50e43fa80b39e93a1ae78f1fb0a268f3a0476)

## 配置

- 阿里云

> 使用说明：templateCode + templateParam

```php
'aliyun' => [
    'accessKeyId' => '',
    'accessKeySecret' => '',
    'signName' => '',
    'templateCode' => [
        // 您的验证码是${code}。有效期为${hour}，请尽快验证！
        'verificationCode' => '',
    ],
],
```

- 云片

> 使用说明：templateCode + templateParam

```php
'yunpian' => [
    'apikey' => '',
    'templateCode' => [
        // 您的验证码是#code#。有效期为#hour#，请尽快验证！
        'verificationCode' => '2414994',
    ],
],
```

- 腾讯云

> 使用说明：templateCode + templateParam

```php
'qcloud' => [
    'appid' => '',
    'appkey' => '',
    'smsSign' => '',
    'templateCode' => [
        'verificationCode' => '',
    ],
],
```

- 短信宝

> 使用说明：Content + templateParam

```php
'duanxinbao' => [
    'user' => '',
    'pass' => '',
    'signName' => '',
    'templateCode' => [
        'verificationCode' => '您的验证码是%s。有效期为%s，请尽快验证！',
    ],
],
```