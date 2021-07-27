<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
class Unipush_EweiShopV2Model
{
    public $url = 'https://restapi.getui.com';
    public $appKey = 'lqx7YY4qqP61SUjFWJuz11';
    public $appId = 'yPG81qIyo68kFnRXWL5wJ8';
    public $masterSecret = 'esee93tl4r6XOQOWaHrlV3';
    public $api;
    public function __construct(){
        include_once EWEI_SHOPV2_VENDOR . 'getui/GTClient.php';
        $this->api = new GTClient($this->url,$this->appKey,$this->appId,$this->masterSecret);
    }
    public function pushAll($params){
        $push = new GTPushRequest();
        if($params['request_id']) $push->setRequestId($params['request_id']);
        if($params['group_name']) $push->setGroupName($params['group_name']);
        if($params['audience'] == 'all'){

        }
        if($params['push_message']){

            $message = new GTPushMessage();

            if($params['push_message']['notification']){
                $notify = new GTNotification();
                if($params['push_message']['notification']['title'])
                    $notify->setTitle($params['push_message']['notification']['title']);
                if($params['push_message']['notification']['body'])
                    $notify->setBody($params['push_message']['notification']['body']);
                if($params['push_message']['notification']['click_type'])
                    $notify->setClickType($params['push_message']['notification']['click_type']);
                if($params['push_message']['notification']['click_type']=='url' && $params['push_message']['notification']['url'])
                    $notify->setUrl($params['push_message']['notification']['url']);
                $message->setNotification($notify);
            }

            $push->setPushMessage($message);
        }
        $result = $this->api->pushApi()->pushAll($push);
        echo "<pre>";
        print_r($result);
        exit;
        if($result['code']==0) return true;
        return false;
    }

    public function pushTcAll(){

    }



}


?>
