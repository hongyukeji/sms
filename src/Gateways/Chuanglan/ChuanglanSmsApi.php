<?php

header("Content-type:text/html; charset=UTF-8");

class ChuanglanSmsApi
{
    //参数的配置 请登录zz.253.com 获取以下API信息 ↓↓↓↓↓↓↓

    protected $API_SEND_URL = 'http://XXX/msg/send/json'; //创蓝发送短信接口URL

    protected $API_VARIABLE_URL = 'http://XXX/msg/variable/json';//创蓝变量短信接口URL

    protected $API_BALANCE_QUERY_URL = 'http://XXX/msg/balance/json';//创蓝短信余额查询接口URL

    protected $API_ACCOUNT = ''; // 创蓝API账号

    protected $API_PASSWORD = '';// 创蓝API密码

    //参数的配置 请登录zz.253.com 获取以上API信息 ↑↑↑↑↑↑↑

    public function __construct($config = [])
    {
        $this->API_SEND_URL = isset($config['api_send_url']) ? $config['api_send_url'] : '';
        $this->API_VARIABLE_URL = isset($config['api_variable_url']) ? $config['api_variable_url'] : '';
        $this->API_BALANCE_QUERY_URL = isset($config['api_balance_query_url']) ? $config['api_balance_query_url'] : '';
        $this->API_ACCOUNT = isset($config['api_account']) ? $config['api_account'] : '';
        $this->API_PASSWORD = isset($config['api_password']) ? $config['api_password'] : '';
    }

    /**
     * 发送短信
     *
     * @param string $mobile 手机号码
     * @param string $msg 短信内容
     * @param string $needstatus 是否需要状态报告
     */
    public function sendSMS($mobile, $msg, $needstatus = 'true')
    {
        //创蓝接口参数
        $postArr = array(
            'account' => $this->API_ACCOUNT,
            'password' => $this->API_PASSWORD,
            'msg' => urlencode($msg),
            'phone' => $mobile,
            'report' => $needstatus,
        );
        $result = $this->curlPost($this->API_SEND_URL, $postArr);
        return $result;
    }

    /**
     * 发送变量短信
     *
     * @param string $msg 短信内容
     * @param string $params 最多不能超过1000个参数组
     */
    public function sendVariableSMS($msg, $params)
    {
        //创蓝接口参数
        $postArr = array(
            'account' => $this->API_ACCOUNT,
            'password' => $this->API_PASSWORD,
            'msg' => $msg,
            'params' => $params,
            'report' => 'true'
        );

        $result = $this->curlPost($this->API_VARIABLE_URL, $postArr);
        return $result;
    }

    /**
     * 查询额度
     *
     *  查询地址
     */
    public function queryBalance()
    {
        //查询参数
        $postArr = array(
            'account' => $this->API_ACCOUNT,
            'password' => $this->API_PASSWORD,
        );
        $result = $this->curlPost($this->API_BALANCE_QUERY_URL, $postArr);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     *
     */
    private function curlPost($url, $postFields)
    {
        $postFields = json_encode($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
            )
        );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); //若果报错 name lookup timed out 报错时添加这一行代码
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($ch);
        if (false == $ret) {
            $result = curl_error($ch);
        } else {
            $rsp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 " . $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close($ch);
        return $result;
    }

}
