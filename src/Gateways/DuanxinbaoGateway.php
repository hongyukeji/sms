<?php

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class DuanxinbaoGateway extends Gateway
{
    protected $smsapi = "http://api.smsbao.com/";
    protected $user;
    protected $pass;
    protected $signName;
    protected $statusStr = array(
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

    public function __construct($config)
    {
        $this->user = $config['user'];  // 短信平台帐号
        $this->pass = $config['pass'];  // 短信平台密码
        $this->signName = $config['signName'];  // 短信签名
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        $smsapi = $this->smsapi;
        $user = $this->user; //短信平台帐号
        $pass = md5($this->pass); //短信平台密码
        $signName = $this->signName; //短信签名
        $content = $signName . vsprintf($templateCode, $templateParam);//要发送的短信内容

        $phone = $phoneNumbers;//要发送短信的手机号码
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);

        $response = [
            'status' => $result,
            'message' => $this->statusStr[$result],
        ];

        return $response;
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        $smsapi = $this->smsapi;
        $user = $this->user; //短信平台帐号
        $pass = md5($this->pass); //短信平台密码
        $signName = $this->signName; //短信签名
        $content = $signName . vsprintf($templateCode, $templateParam);//要发送的短信内容

        foreach ($phoneNumbers as $key => $value) {
            $phone = $value;//要发送短信的手机号码
            $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
            $result = file_get_contents($sendurl);
        }

        $response = [
            'status' => $result,
            'message' => $this->statusStr[$result],
        ];

        return $response;
    }
}