<h1 align="center">SMS - 短信发送，从未如此简单</h1>

<p align="center">
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/hongyukeji/sms"><img src="https://poser.pugx.org/hongyukeji/sms/license" alt="License"></a>
</p>

> 全网首款支持所有短信服务商，自由扩展，无缝对接。

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
- [SendCloud](https://www.sendcloud.net)
- [互亿无线](http://www.ihuyi.com)
- 上述短信服务商比较常用，其他短信如有需要可联系[Shadow](http://wpa.qq.com/msgrd?v=3&uin=1527200768&site=qq&menu=yes)集成
- 如需支持其他短信服务商，可以自行Fork，在`src/Sms.php`中添加对应的短信发送方法即可
- 短信快速集成（参考[《宏观设计模式》](docs/README.md) — 鸿宇科技出品）

## 环境

- PHP >= 5.6.0

## 安装

```shell
$ composer require hongyukeji/sms
```

## 使用

> PHP框架中使用，配置文件参考 'docs/config/config.php' 

> 短信发送参数详解: send([参数1-手机号: 支持字符串和数组格式],[参数2-模板: 支持模板Code和模板内容],[参数3-模板参数: 模板对应的参数, 数组格式],[参数4-短信服务商: 设置短信发送服务商, 该参数为空时调用配置文件中默认短信服务商])

```php
use HongYuKeJi\Helpers\Sms;

$config = [
    'default' => [
        'gateway' => 'aliyun',
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

// return 返回值 status: 0-发送成功, 1-发送失败
$result = [
    'status' => '0',
    'message' => '短信发送成功！',
];
```

## 维护

- Author：Shadow
- QQ：[1527200768](http://wpa.qq.com/msgrd?v=3&uin=1527200768&site=qq&menu=yes)
- Email：[admin@hongyuvip.com](mailto:admin@hongyuvip.com)
- QQ交流群：[90664526](http://shang.qq.com/wpa/qunwpa?idkey=a3e498d7d3329615c9b3d1dbbbc50e43fa80b39e93a1ae78f1fb0a268f3a0476)

## 配置

- [阿里云](https://help.aliyun.com/document_detail/55451.html)

> 使用说明：templateCode + templateParam

```php
'aliyun' => [
    'accessKeyId' => '',
    'accessKeySecret' => '',
    'signName' => '',
],
```

- [云片网](https://www.yunpian.com/doc/zh_CN/introduction/demos/php.html)

> 使用说明：templateCode + templateParam

```php
'yunpian' => [
    'apikey' => '',
],
```

- [腾讯云](https://cloud.tencent.com/document/product/382/9557)

> 使用说明：templateCode + templateParam

```php
'qcloud' => [
    'appid' => '',
    'appkey' => '',
    'smsSign' => '',
],
```

- [短信宝](http://www.smsbao.com/openapi/55.html)

> 使用说明：templateContent + templateParam

```php
'duanxinbao' => [
    'user' => '',
    'pass' => '',
    'signName' => '',
],
```

- [赛邮云](https://www.mysubmail.com/chs/documents/developer/t2f1J2)

> 使用说明：templateCode + templateParam

```php
'submail' => [
    'appid' => '',
    'appkey' => '',
],
```

- [SendCloud](https://www.sendcloud.net/doc/sms)

> 使用说明：templateCode + templateParam

```php
'sendcloud' => [
    'sms_user' => '',
    'sms_key' => '',
],
```

- [互亿无线](http://www.ihuyi.com/demo/sms/php.html)

> 使用说明：templateContent + templateParam

```php
'ihuyi' => [
    'apiid' => '',
    'apikey' => '',
],
```