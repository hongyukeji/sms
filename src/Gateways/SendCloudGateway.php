<?php

namespace HongYuKeJi\Helpers\Gateways;

require_once dirname(__FILE__) . '/Sendcloud/SendCloudSMS.php';
require_once dirname(__FILE__) . '/Sendcloud/util/SMS.php';

use SendCloudSMS;
use SmsMsg;
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
        $SMS_USER = $this->sms_user;
        $SMS_KEY = $this->sms_key;
        $smsTemplateId = $templateCode;
        $sendSms = new SendCloudSMS($SMS_USER, $SMS_KEY);
        $smsMsg = new SmsMsg();
        $smsMsg->addPhoneList(array($phoneNumbers));
        foreach ($templateParam as $key => $value) {
            $smsMsg->addVars($key, $value);
        }
        $smsMsg->setTemplateId($smsTemplateId);
        $smsMsg->setTimestamp(time());
        $resonse = $sendSms->send($smsMsg);
        return $resonse->body();
    }

    public function sendBatchSms($phoneNumbers, $templateCode, $templateParam)
    {
        $SMS_USER = $this->sms_user;
        $SMS_KEY = $this->sms_key;
        $smsTemplateId = $templateCode;
        $sendSms = new SendCloudSMS($SMS_USER, $SMS_KEY);
        $smsMsg = new SmsMsg();
        $smsMsg->addPhoneList($phoneNumbers);
        foreach ($templateParam as $key => $value) {
            $smsMsg->addVars($key, $value);
        }
        $smsMsg->setTemplateId($smsTemplateId);
        $smsMsg->setTimestamp(time());
        $resonse = $sendSms->send($smsMsg);
        return $resonse->body();
    }
}