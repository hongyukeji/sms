<?php

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class YunpianGateway extends Gateway
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 云片网开发文档
     * php DEMO https://www.yunpian.com/doc/zh_CN/introduction/demos/php.html
     * 返回码总体说明 https://www.yunpian.com/doc/zh_CN/returnValue/list.html
     * 返回值示例 https://www.yunpian.com/doc/zh_CN/returnValue/example.html
     * 常见的返回码 https://www.yunpian.com/doc/zh_CN/returnValue/common.html
     *
     * @param $templateCode
     * @param $phoneNumbers
     * @param $templateParam
     * @return mixed
     */
    public function sendSms($templateCode, $phoneNumbers, $templateParam)
    {
        $apikey = $this->config['apikey'];

        $ch = curl_init();

        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // 格式化手机号
        if (!empty($phoneNumbers) && is_array($phoneNumbers)) {
            $phoneNumbers = $this->yunPianSwitchMobile($phoneNumbers);
        }

        // 格式化参数
        $templateParam = $this->yunPianSwitchTplValue($templateParam);

        // 发送短信
        $data = array('tpl_id' => $templateCode, 'tpl_value' => $templateParam, 'apikey' => $apikey, 'mobile' => $phoneNumbers);

        // 判断是否群发
        if ($this->config['batch'] == true) {
            $json_data = $this->tpl_sends($ch, $data);
        } else {
            $json_data = $this->tpl_send($ch, $data);
        }

        $array = json_decode($json_data, true);

        curl_close($ch);

        return $array;
    }

    /**
     * 云片短信处理手机号
     *
     * @param $array
     * @return null|string
     */
    public function yunPianSwitchMobile($array)
    {
        $string = array();

        if ($array && is_array($array)) {
            foreach ($array as $key => $value) {
                $string[] = $value;
            }
        } else {
            return null;
        }

        return implode(',', $string);
    }

    /**
     * 云片短信处理模板值
     *
     * @param $array
     * @return null|string
     */
    public function yunPianSwitchTplValue($array)
    {
        $string = array();

        if ($array && is_array($array)) {
            foreach ($array as $key => $value) {
                $string[] = '#' . $key . '#=' . $value;
            }
        } else {
            return null;
        }

        return implode('&', $string);
    }

    public function get_user($ch, $apikey)
    {
        curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function send($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL, 'http://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function tpl_send($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function tpl_sends($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_batch_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function voice_send($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function notify_send($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result, $error);
        return $result;
    }

    public function checkErr($result, $error)
    {
        if ($result === false) {
            echo 'Curl error: ' . $error;
        } else {
            //echo '操作完成没有任何错误';
        }
    }
}