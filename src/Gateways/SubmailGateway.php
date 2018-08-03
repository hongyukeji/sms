<?php

namespace HongYuKeJi\Helpers\Gateways;

require_once dirname(__FILE__) . '/Submail/SUBMAILAutoload.php';

use MESSAGEXsend;

class SubmailGateway extends Gateway
{
    protected $message_configs;

    public function __construct($config)
    {
        $this->message_configs['appid'] = $config['appid'];
        $this->message_configs['appkey'] = $config['appkey'];
        $this->message_configs['sign_type'] = 'normal';
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        $submail = new MESSAGEXsend($this->message_configs);
        $submail->setTo($phoneNumbers);
        $submail->SetProject($templateCode);
        foreach ($templateParam as $key => $value) {
            $submail->AddVar($key, $value);
        }

        $xsend = $submail->xsend();

        return $xsend;
    }

    public function sendBatch($phoneNumbers, $templateCode, $templateParam)
    {
        $submail = new MESSAGEXsend($this->message_configs);
        foreach ($phoneNumbers as $k => $v) {
            $submail->setTo($v);
            $submail->SetProject($templateCode);
            foreach ($templateParam as $key => $value) {
                $submail->AddVar($key, $value);
            }
            $xsend = $submail->xsend();
        }

        return $xsend;
    }
}