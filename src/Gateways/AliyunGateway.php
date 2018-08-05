<?php

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class AliyunGateway extends Gateway
{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $signName;

    /**
     * AliyunGateway constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->signName = $config['signName'];
    }

    /**
     * 阿里短信 单条发送
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param array $templateParam
     * @param null $outId
     * @param null $smsUpExtendCode
     * @return bool|\stdClass
     */
    public function sendSms($phoneNumbers, $templateCode, $templateParam = [], $outId = null, $smsUpExtendCode = null)
    {
        $params = array();

        // *** 需用户填写部分 ***
        $accessKeyId = $this->accessKeyId;
        $accessKeySecret = $this->accessKeySecret;
        $params["PhoneNumbers"] = $phoneNumbers;
        $params["SignName"] = $this->signName;
        $params["TemplateCode"] = $templateCode;
        $params['TemplateParam'] = $templateParam;
        $params['OutId'] = $outId;
        $params['SmsUpExtendCode'] = $smsUpExtendCode;
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        //$helper = new SignatureHelper();
        // 此处可能会抛出异常，注意catch
        $content = $this->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        $response = $content;

        if ($response->Code === "InvalidAccessKeyId.NotFound") {
            $response->Message = '阿里短信 accessKeyId 不正确，无效的访问密钥';
        }
        if ($response->Code === 'SignatureDoesNotMatch') {
            $response->Message = '阿里短信 accessKeySecret 不正确，签名不匹配';
        }
        if ($response->Code === 'isv.SMS_SIGNATURE_ILLEGAL') {
            $response->Message = '阿里短信 signName 不正确，签名不合法(不存在或被拉黑';
        }
        if ($response->Code === 'isv.SMS_TEMPLATE_ILLEGAL') {
            $response->Message = $templateCode . $response->Message;
        }
        if ($response->Code === 'isv.TEMPLATE_MISSING_PARAMETERS') {
            $response->Message = $templateCode . $response->Message;
        }
        if ($response->Code === 'isv.MOBILE_NUMBER_ILLEGAL') {
            $response->Message = $phoneNumbers . '手机号无效';
        }
        if ($response->Code === 'isv.BUSINESS_LIMIT_CONTROL') {
            $response->Message = '阿里短信业务限流：将短信发送频率限制在正常的业务流控范围内，默认流控：短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。参考网址：https://help.aliyun.com/knowledge_detail/57710.html';
        }

        return $content;
    }

    /**
     * 阿里短信 批量发送
     *
     * @param $phoneNumbers
     * @param $templateCode
     * @param array $templateParam
     * @return bool|\stdClass
     */
    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam = [])
    {
        $params = array();

        // *** 需用户填写部分 ***
        $accessKeyId = $this->accessKeyId;
        $accessKeySecret = $this->accessKeySecret;
        $params["PhoneNumberJson"] = $phoneNumbers;
        $params["SignNameJson"] = array();
        foreach ($phoneNumbers as $key => $value) {
            array_push($params["SignNameJson"], $this->signName);
        }
        $params["TemplateCode"] = $templateCode;
        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $params["TemplateParamJson"] = array();
        foreach ($phoneNumbers as $key => $value) {
            array_push($params["TemplateParamJson"], $templateParam);
        }
        $params["SmsUpExtendCodeJson"] = json_encode(array("90997", "90998"));
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        $params["TemplateParamJson"] = json_encode($params["TemplateParamJson"], JSON_UNESCAPED_UNICODE);
        $params["SignNameJson"] = json_encode($params["SignNameJson"], JSON_UNESCAPED_UNICODE);
        $params["PhoneNumberJson"] = json_encode($params["PhoneNumberJson"], JSON_UNESCAPED_UNICODE);
        if (!empty($params["SmsUpExtendCodeJson"] && is_array($params["SmsUpExtendCodeJson"]))) {
            $params["SmsUpExtendCodeJson"] = json_encode($params["SmsUpExtendCodeJson"], JSON_UNESCAPED_UNICODE);
        }
        // 此处可能会抛出异常，注意catch
        $content = $this->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendBatchSms",
                "Version" => "2017-05-25",
            ))
        );

        $response = $content;

        if ($response->Code === "InvalidAccessKeyId.NotFound") {
            $response->Message = '阿里短信 accessKeyId 不正确，无效的访问密钥';
        }
        if ($response->Code === 'SignatureDoesNotMatch') {
            $response->Message = '阿里短信 accessKeySecret 不正确，签名不匹配';
        }
        if ($response->Code === 'isv.SMS_SIGNATURE_ILLEGAL') {
            $response->Message = '阿里短信 signName 不正确，签名不合法(不存在或被拉黑';
        }
        if ($response->Code === 'isv.SMS_TEMPLATE_ILLEGAL') {
            $response->Message = $templateCode . $response->Message;
        }
        if ($response->Code === 'isv.TEMPLATE_MISSING_PARAMETERS') {
            $response->Message = $templateCode . $response->Message;
        }
        if ($response->Code === 'isv.MOBILE_NUMBER_ILLEGAL') {
            $response->Message = $phoneNumbers . '手机号无效';
        }
        if ($response->Code === 'isv.BUSINESS_LIMIT_CONTROL') {
            $response->Message = '阿里短信业务限流：将短信发送频率限制在正常的业务流控范围内，默认流控：短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。参考网址：https://help.aliyun.com/knowledge_detail/57710.html';
        }

        return $content;
    }

    /**
     * 生成签名并发起请求
     *
     * @param $accessKeyId string AccessKeyId (https://ak-console.aliyun.com/)
     * @param $accessKeySecret string AccessKeySecret
     * @param $domain string API接口所在域名
     * @param $params array API具体参数
     * @param $security boolean 使用https
     * @return bool|\stdClass 返回API接口调用结果，当发生错误时返回false
     */
    public function request($accessKeyId, $accessKeySecret, $domain, $params, $security = false)
    {
        $apiParams = array_merge(array(
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0, 0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $accessKeyId,
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ), $params);
        ksort($apiParams);

        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }

        $stringToSign = "GET&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&", true));

        $signature = $this->encode($sign);

        $url = ($security ? 'https' : 'http') . "://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";

        try {
            $content = $this->fetchContent($url);
            return json_decode($content);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    private function fetchContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));

        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);

        if ($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);

        return $rtn;
    }
}