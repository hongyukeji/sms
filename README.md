<h1 align="center">SMS - 全网首款支持所有短信服务商</h1>

<p align="center">
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/license" alt="License"></a>
</p>

> 全网首款支持所有短信发送，自由扩展，无缝对接。

> 采用鸿宇科技专利[《宏观设计模式》](docs/README.md)开发。

> 更多请点击 [https://www.hongyuvip.com](https://www.hongyuvip.com)

## 特点

- 支持全网络短信服务商
- 支持自由扩展且易维护

## 支持

- [阿里云](https://www.aliyun.com)
- [云片网](https://www.yunpian.com)
- [腾讯云](https://cloud.tencent.com/product/sms)
- [短信宝](http://www.smsbao.com)
- [赛邮云](https://www.mysubmail.com)
- 上述短信服务商比较常用，其他短信如有需要可联系[Shadow](http://wpa.qq.com/msgrd?v=3&uin=1527200768&site=qq&menu=yes)集成
- 如需支持其他短信服务商，请自行Fork，在`src/Sms.php`中添加即可
- 短信速集成（参考[《宏观设计模式》](docs/README.md) — 鸿宇科技出品）

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
], 'submail');

var_dump($resultContent);
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
],
```

- 云片

> 使用说明：templateCode + templateParam

```php
'yunpian' => [
    'apikey' => '',
],
```

- 腾讯云

> 使用说明：templateCode + templateParam

```php
'qcloud' => [
    'appid' => '',
    'appkey' => '',
    'smsSign' => '',
],
```

- 短信宝

> 使用说明：templateContent + templateParam

```php
'duanxinbao' => [
    'user' => '',
    'pass' => '',
    'signName' => '',
],
```

- 赛邮云短信

> 使用说明：templateCode + templateParam

```php
'submail' => [
    'appid' => '',
    'appkey' => '',
],
```
