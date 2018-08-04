<?php
/**
 * sms
 * ============================================================================
 * Copyright © 2015-2018 HongYuKeJi.Co.Ltd. All rights reserved.
 * Http://www.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 堂堂正正做人，踏踏实实做事。
 * ----------------------------------------------------------------------------
 * Author: Shadow  QQ: 1527200768  Time: 2018/8/4 20:19
 * E-mail: admin@hongyuvip.com
 * ============================================================================
 */

namespace HongYuKeJi\Helpers\Gateways;

use HongYuKeJi\Helpers\Gateways\Gateway;

class SendCloudGateway extends Gateway
{
    protected $sms_user;
    protected $sms_key;

    public function __construct($config)
    {
        $this->sms_user = $config['sms_user'];
        $this->sms_key = $config['sms_key'];
    }

    public function send($phoneNumbers, $templateCode, $templateParam)
    {
        //
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        //
    }
}