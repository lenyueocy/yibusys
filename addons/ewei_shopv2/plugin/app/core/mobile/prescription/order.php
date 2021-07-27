<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php";
class Order_EweiShopV2Page extends AppMobilePage
{
    public $dateList = [];
    public function __construct(){
        parent::__construct();
    }

    public function get_list(){
        global $_GPC,$_W;
        if($_GPC['type']=='doctor'){
            $doctor_id = pdo_getcolumn('ewei_doctor',['openid'=>$_W['openid']],'id');
            $where = ['doctorid'=>$doctor_id];
            if(!empty($_GPC['status']) || ($_GPC['status']===0 || $_GPC['status']==='0')) $where['status'] = intval($_GPC['status']);
            $list = pdo_getall('ewei_appoint_order',$where);
            foreach ($list as $key=>&$val){
                $member = m('member')->getMember($val['openid']);
                $val['mobile'] = $member['mobile'];
                $val['nickname'] = $member['nickname'];
                $val['avatar'] = $member['avatar'];
            }
            return app_json(['list'=>$list]);
        }else{
            $where = ['openid'=>$_W['openid']];
            if(!empty($_GPC['status']) || ($_GPC['status']===0 || $_GPC['status']==='0')) $where['status'] = intval($_GPC['status']);
            $list = pdo_getall('ewei_prescription_order',$where);
            foreach ($list as $key=>&$val){
                $val['createtime'] = date('Y-m-d H:i',$val['createtime']);
                $doctorData = pdo_get('ewei_doctor',['id'=>$val['doctorid']]);
                $val['mobile'] = $doctorData['mobile'];
                $val['nickname'] = $doctorData['name'];
                $val['avatar'] = tomedia($doctorData['avatar']);
            }
            return app_json(['list'=>$list]);
        }
    }
    public function get_detail(){
        global $_GPC,$_W;
        if(empty($_GPC['orderid'])) return app_error(-1,'参数错误');
        if($_GPC['type']=='doctor'){
            $list = pdo_get('ewei_appoint_order',['id'=>$_GPC['orderid']]);
            $member = m('member')->getMember($list['openid']);
            $list['mobile'] = $member['mobile'];
            $list['nickname'] = $member['nickname'];
            $list['avatar'] = $member['avatar'];
            return app_json(['list'=>$list]);
        }else{
            $list = pdo_get('ewei_appoint_order',['id'=>$_GPC['orderid']]);
            $doctorData = pdo_get('ewei_doctor',['id'=>$list['doctorid']]);
            $list['mobile'] = $doctorData['mobile'];
            $list['nickname'] = $doctorData['name'];
            $list['avatar'] = tomedia($doctorData['avatar']);
            return app_json(['list'=>$list]);
        }

    }

}

?>