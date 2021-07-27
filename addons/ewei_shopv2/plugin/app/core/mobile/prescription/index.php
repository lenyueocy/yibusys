<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php";
class Index_EweiShopV2Page extends AppMobilePage
{
    public function get_list()
    {
        global $_GPC;
        global $_W;
        $list = pdo_getall('ewei_department',['status'=>1,'is_delete'=>0]);
        foreach ($list as $key=>&$val){
            $val['logo'] = tomedia($val['logo']);
        }
        return app_json(['list'=>$list]);
    }
    public function get_detail(){
        global $_GPC;
        global $_W;
        if(empty($_GPC['id'])) return app_error(AppError::$ParamsError,'参数错误');
        $list = pdo_get('ewei_department',['id'=>$_GPC['id'],'status'=>1,'is_delete'=>0]);
        $list['logo'] = tomedia($list['logo']);
        return app_json(['list'=>$list]);
    }
    public function submit(){
        global $_GPC,$_W;
        if(empty($_GPC['orderid'])) return app_error(AppError::$ParamsError,'参数错误');
        if(empty($_GPC['picture'])) return app_error(AppError::$ParamsError,'请上传处方');

        $doctor_id = pdo_getcolumn('ewei_doctor',['openid'=>$_W['openid']],'id');
        $appointOrder = pdo_get('ewei_appoint_order',['id'=>$_GPC['orderid'],'doctorid'=>$doctor_id]);
        if(empty($appointOrder)) return app_error(AppError::$ParamsError,'没有找到你要开方的预约');
        if($appointOrder['status']>1) return app_error(AppError::$ParamsError,'该预约已开方');
        $order_id = m('prescription')->createNO('ewei_prescription','ordersn','CF');
        pdo_update('ewei_appoint_order',['status'=>2],['id'=>$appointOrder['id']]);
        $insertData = [
            'uniacid'=>$_W['uniacid'],
            'openid'=>$appointOrder['openid'],
            'ordersn'=>$order_id,
            'status'=>0,
            'price'=>0.01,
            'doctorid'=>$doctor_id,
            'picture'=>$_GPC['picture'],
            'remark'=>$_GPC['content'],
            'content'=>$_GPC['content'],
            'createtime'=>time(),
        ];
        $prescription_id = pdo_insert('ewei_prescription_order',$insertData);
        if(!empty($prescription_id)){
            return app_json();
        }
        return app_error(AppError::$ParamsError,'提交失败，请稍后重试');
    }
}

?>