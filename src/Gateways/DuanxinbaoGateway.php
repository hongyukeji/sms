<?php

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class DuanxinbaoGateway extends Gateway
{
    protected $smsapi = "http://api.smsbao.com/";
    protected $user;
    protected $pass;
    protected $signName;

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

        return $result;
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

        return $result;
    }
}