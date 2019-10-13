<?php

namespace HongYuKeJi\Helpers\Gateways;

require_once dirname(__FILE__) . '/Chuanglan/ChuanglanSmsApi.php';

class ChuanglanGateway extends Gateway
{
    protected $config;
    protected $clapi;

    public function __construct($config)
    {
        $this->config = $config;
        $this->clapi = new \ChuanglanSmsApi($config);
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        $params = array_values($templateParam);
        array_unshift($params, $phoneNumbers);
        $msg = $templateCode;
        if (isset($this->config['sms_sign'])) {
            $msg = '【' . $this->config['sms_sign'] . '】' . $msg;
        }
        $params = implode(',', $params);
        $result = $this->clapi->sendVariableSMS($msg, $params);
        return $result;
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        $msg = $templateCode;
        $param_array = [];
        foreach ($phoneNumbers as $phoneNumber) {
            $param_array[] = $phoneNumber . ',' . implode(',', array_values($templateParam));
        }
        $params = implode(';', $param_array);
        $result = $this->clapi->sendVariableSMS($msg, $params);
        return $result;
    }
}
