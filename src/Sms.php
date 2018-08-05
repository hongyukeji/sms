<?php

namespace HongYuKeJi\Helpers;

use HongYuKeJi\Helpers\Gateways\AliyunGateway;
use HongYuKeJi\Helpers\Gateways\DuanxinbaoGateway;
use HongYuKeJi\Helpers\Gateways\QcloudGateway;
use HongYuKeJi\Helpers\Gateways\YunpianGateway;
use HongYuKeJi\Helpers\Gateways\IhuyiGateway;
use HongYuKeJi\Helpers\Gateways\SendCloudGateway;
use HongYuKeJi\Helpers\Gateways\SubmailGateway;

class Sms
{
    protected $config;
    protected $defaultGateway;

    public function __construct($config)
    {
        $this->config = $config['gateways'];
        if (!empty($config['default']['gateway'])) {
            $this->defaultGateway = $config['default']['gateway'];
        }
        if (!empty($this->defaultGateway) && !empty($this->config) && !array_key_exists($this->defaultGateway, $this->config)) {
            $this->defaultGateway = null;
        }
    }

    public function send($phoneNumbers, $templateCode, $templateParam = [], $gateway = null)
    {
        $defaultGateway = $this->defaultGateway;
        if (!empty($gateway) || empty($defaultGateway)) {
            $defaultGateway = $gateway;
        }
        if (empty($gateway) && empty($defaultGateway)) {
            $gateways = array_keys($this->config);
            $defaultGateway = reset($gateways);
        }
        return $this->$defaultGateway($phoneNumbers, $templateCode, $templateParam);
    }

    /**
     * 阿里云短信
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

        $smsObj = new AliyunGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $response = $smsObj->sendSms($phoneNumbers, $templateCode, $templateParam);
        } else {
            $response = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        if ($response->Code === 'OK') {
            return $this->result('0');
        } else {
            return $this->result('1', $response->Message, json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 云片网短信
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
        $config['batch'] = false;

        if (is_array($phoneNumbers)) {
            $config['batch'] = true;
        }

        $smsObj = new YunpianGateway($config);

        $response = $smsObj->sendSms($templateCode, $phoneNumbers, $templateParam);

        if ($response['code'] == '0') {
            return $this->result('0');
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

        $smsObj = new QcloudGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        $resultItem = json_decode($result, true);

        if ($resultItem['result'] == '0') {
            return $this->result('0');
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

        $smsObj = new DuanxinbaoGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        if ($result['statusCode'] == '0') {
            return $this->result('0');
        } else {
            return $this->result('1', $result['message'], json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 赛邮云短信
     *
     * @see https://www.mysubmail.com/chs/documents/developer/index
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return mixed
     */
    public function submail($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['submail'];

        $smsObj = new SubmailGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatch($phoneNumbers, $templateCode, $templateParam);
        }

        if ($result['status'] == 'success') {
            return $this->result('0');
        } else {
            return $this->result('1', '错误代码：' . $result['code'] . ' 描述：' . $result['msg'], json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * SendCloud短信
     * @see https://www.sendcloud.net/doc/sms/
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return array
     */
    public function sendcloud($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['sendcloud'];

        $smsObj = new SendCloudGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        if (json_decode($result, true)['statusCode'] == '200') {
            return $this->result('0');
        } else {
            return $this->result('1', json_decode($result, true)['message'], $result);
        }
    }

    /**
     * 互亿无线短信
     * @see http://www.ihuyi.com/demo/sms/php.html
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param $templateParam
     * @return array
     */
    public function ihuyi($phoneNumbers, $templateCode, $templateParam)
    {
        $config = $this->config['ihuyi'];

        $smsObj = new IhuyiGateway($config);

        if (!empty($phoneNumbers) && !is_array($phoneNumbers)) {
            $result = $smsObj->send($phoneNumbers, $templateCode, $templateParam);
        } else {
            $result = $smsObj->sendBatchSms($phoneNumbers, $templateCode, $templateParam);
        }

        if ($result['SubmitResult']['code'] == '2') {
            return $this->result('0');
        } else {
            return $this->result('1', $result['SubmitResult']['msg'], json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }

    public function result($statusCode, $message = '短信发送成功！', $data = null)
    {
        $result = [
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        if (!empty($data)) {
            $result['data'] = $data;
        }

        return $result;
    }
}