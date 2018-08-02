<?php
/**
 * sms
 * ============================================================================
 * Copyright © 2015-2018 HongYuKeJi.Co.Ltd. All rights reserved.
 * Http://www.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 堂堂正正做人，踏踏实实做事。
 * ----------------------------------------------------------------------------
 * Author: Shadow  QQ: 1527200768  Time: 2018/08/02 20:32
 * E-mail: admin@hongyuvip.com
 * ============================================================================
 */

namespace HongYuKeJi\Helpers;

use HongYuKeJi\Helpers\Gateway\AliyunGateway;
use HongYuKeJi\Helpers\Gateway\DuanxinbaoGateway;
use HongYuKeJi\Helpers\Gateway\QcloudGateway;
use HongYuKeJi\Helpers\Gateway\YunpianGateway;

class Sms
{
    protected $config;
    protected $defaultSms;

    public function __construct($config, $defaultSms = null)
    {
        $this->config = $config;
        if ($defaultSms) {
            $this->defaultSms = $defaultSms;
        }
    }

    public function send($phoneNumbers, $templateCode, $templateParam = [], $smsGateway = null)
    {
        $defaultSms = $this->defaultSms;
        if ($smsGateway || empty($this->defaultSms)) {
            $defaultSms = $smsGateway;
        }
        return $this->$defaultSms($phoneNumbers, $templateCode, $templateParam);
    }

    /**
     * 阿里短信
     * @see https://help.aliyun.com/document_detail/55451.html
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return array|bool|\stdClass
     */
    public function aliyun($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['aliyun'];

        $accessKeyId = $config['accessKeyId'];
        $accessKeySecret = $config['accessKeySecret'];
        $signName = $config['signName'];

        if (empty($accessKeyId)) {
            return $this->result('1', '阿里短信 accessKeyId 不能为空，请填写 accessKeyId ！');
        }
        if (empty($accessKeySecret)) {
            return $this->result('1', '阿里短信 accessKeySecret 不能为空，请填写 accessKeySecret ！');
        }
        if (empty($signName)) {
            return $this->result('1', '阿里短信签名不能为空，请填写短信签名 ！');
        }

        $smsObj = new AliyunGateway($accessKeyId, $accessKeySecret, $signName);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $response = $smsObj->sendSms(
                $phoneNumbers,
                $templateCode,
                $templateParam
            );
        } else {
            $response = $smsObj->sendBatchSms(
                $phoneNumbers,
                $templateCode,
                $templateParam
            );
        }

        if ($response->Code === 'OK') {
            return $this->result('0', '发送成功');
        } elseif ($response->Code === "InvalidAccessKeyId.NotFound") {
            return $this->result('1', '阿里短信 accessKeyId 不正确，无效的访问密钥', json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'SignatureDoesNotMatch') {
            return $this->result('1', '阿里短信 accessKeySecret 不正确，签名不匹配', json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'isv.SMS_SIGNATURE_ILLEGAL') {
            return $this->result('1', '阿里短信 signName 不正确，签名不合法(不存在或被拉黑)', json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'isv.SMS_TEMPLATE_ILLEGAL') {
            return $this->result('1', $templateCode . $response->Message, json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'isv.TEMPLATE_MISSING_PARAMETERS') {
            return $this->result('1', $templateCode . $response->Message, json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'isv.MOBILE_NUMBER_ILLEGAL') {
            return $this->result('1', $phoneNumbers . '手机号无效', json_encode($response, JSON_UNESCAPED_UNICODE));
        } elseif ($response->Code === 'isv.BUSINESS_LIMIT_CONTROL') {
            return $this->result('1', '阿里短信业务限流：将短信发送频率限制在正常的业务流控范围内，默认流控：短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。参考网址：https://help.aliyun.com/knowledge_detail/57710.html', json_encode($response, JSON_UNESCAPED_UNICODE));
        } else {
            return $this->result('1', '错误码：' . $response->Code . ' 描述：' . $response->Message . ' 短信接口调用错误码查询网址：https://help.aliyun.com/knowledge_detail/57717.html', json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 云片短信
     * @see https://www.yunpian.com/doc/zh_CN/returnValue/example.html
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return mixed
     */
    public function yunpian($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['yunpian'];

        $apikey = $config['apikey'];

        $smsObj = new YunpianGateway($apikey);

        if (!empty($phoneNumbers) && is_array($phoneNumbers)) {
            $phoneNumbers = $smsObj->yunPianSwitchMobile($phoneNumbers);
            $smsObj::$batchSend = true;
        }

        $response = $smsObj->sendSms($templateCode, $phoneNumbers, $smsObj->yunPianSwitchTplValue($templateParam));

        if (!empty($response['code']) == '0') {
            return $this->result('0', '发送成功');
        } else {
            return $this->result('1', $response['msg'], json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 腾讯云短信
     *
     * @see https://cloud.tencent.com/document/product/382/9557
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return array
     */
    public function qcloud($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['qcloud'];

        $appid = $config['appid'];
        $appkey = $config['appkey'];
        $smsSign = $config['smsSign'];

        $smsObj = new QcloudGateway($appid, $appkey, $smsSign);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        $resultItem = json_decode($result, true);

        if ($resultItem['result'] == '0') {
            return $this->result('0', '发送成功');
        } else {
            return $this->result('1', $resultItem['errmsg'], $result);
        }

    }

    /**
     * 短信宝短信
     * @see http://www.smsbao.com/openapi/55.html
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return array
     */
    public function duanxinbao($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['duanxinbao'];

        $user = $config['user']; //短信平台帐号
        $pass = $config['pass']; //短信平台密码
        $signName = $config['signName']; //短信签名

        $smsObj = new DuanxinbaoGateway($user, $pass, $signName);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );

        if ($result == '0') {
            return $this->result('0', '发送成功');
        } else {
            return $this->result('1', $statusStr[$result], json_encode($statusStr[$result], JSON_UNESCAPED_UNICODE));
        }
    }

    public function result($statusCode, $message, $data = null)
    {
        $result = [
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        if ($data) {
            $result['data'] = $data;
        }

        return $result;
    }
}