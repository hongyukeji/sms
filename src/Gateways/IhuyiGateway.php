<?php
/**
 * sms
 * ============================================================================
 * Copyright © 2015-2018 HongYuKeJi.Co.Ltd. All rights reserved.
 * Http://www.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 堂堂正正做人，踏踏实实做事。
 * ----------------------------------------------------------------------------
 * Author: Shadow  QQ: 1527200768  Time: 2018/8/4 20:20
 * E-mail: admin@hongyuvip.com
 * ============================================================================
 */

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class IhuyiGateway extends Gateway
{
    protected $target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
    protected $apiid;
    protected $apikey;

    public function __construct($config)
    {
        $this->apiid = $config['apiid'];
        $this->apikey = $config['apikey'];
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        //短信接口地址
        $target = $this->target;
        //获取手机号
        $mobile = $phoneNumbers;
        // 短信内容格式处理
        $content = vsprintf($templateCode, $templateParam);

        $post_data = "account=" . $this->apiid . "&password=" . $this->apikey . "&mobile=" . $mobile . "&content=" . rawurlencode($content);
        //查看用户名 登录用户中心->验证码通知短信>产品总览->API接口信息->APIID
        //查看密码 登录用户中心->验证码通知短信>产品总览->API接口信息->APIKEY
        $gets = $this->xml_to_array($this->Post($post_data, $target));

        return $gets;
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        $target = $this->target;
        $content = vsprintf($templateCode, $templateParam);
        foreach ($phoneNumbers as $key => $value) {
            $mobile = $value;
            $post_data = "account=" . $this->apiid . "&password=" . $this->apikey . "&mobile=" . $mobile . "&content=" . rawurlencode($content);
            $gets = $this->xml_to_array($this->Post($post_data, $target));
        }

        return $gets;
    }

    //请求数据到短信接口，检查环境是否 开启 curl init。
    public function Post($curlPost, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    //将 xml数据转换为数组格式。
    public function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = $this->xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }
}