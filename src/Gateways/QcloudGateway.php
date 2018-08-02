<?php

namespace HongYuKeJi\Helpers\Gateway;

use HongYuKeJi\Helpers\Gateways\Qcloud\SmsMultiSender;
use HongYuKeJi\Helpers\Gateways\Qcloud\SmsSingleSender;
use HongYuKeJi\Helpers\Gateways\Gateway;

class QcloudGateway extends Gateway
{
    protected $appid;
    protected $appkey;
    protected $smsSign;

    public function __construct($appid, $appkey, $smsSign)
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        $this->smsSign = $smsSign;
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        // 短信应用SDK AppID
        $appid = $this->appid; // 1400开头

        // 短信应用SDK AppKey
        $appkey = $this->appkey;

        // 需要发送短信的手机号码
        $phoneNumbers = $phoneNumbers;

        // 短信模板ID，需要在短信应用中申请
        $templateId = $templateCode;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请

        // 签名
        $smsSign = $this->smsSign; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`

        // 指定模板ID单发短信
        try {
            $ssender = new SmsSingleSender($appid, $appkey);
            $params = $templateParam;
            $result = $ssender->sendWithParam("86", $phoneNumbers, $templateId, $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
            //echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }

        return $result;
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        // 短信应用SDK AppID
        $appid = $this->appid; // 1400开头

        // 短信应用SDK AppKey
        $appkey = $this->appkey;

        // 需要发送短信的手机号码
        $phoneNumbers = $phoneNumbers;

        // 短信模板ID，需要在短信应用中申请
        $templateId = $templateCode;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请

        // 签名
        $smsSign = $this->smsSign; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`

        try {
            $msender = new SmsMultiSender($appid, $appkey);
            $params = $templateParam;
            $result = $msender->sendWithParam("86", $phoneNumbers,
                $templateId, $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
            //echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }

        return $result;
    }
}