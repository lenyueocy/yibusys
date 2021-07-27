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
        $filter = $_GPC['filter'];
        $where = ['status'=>1];
        if(!empty($filter)){
            if(!empty($filter['storeid'])) $where['storeid'] = $filter['storeid'];
            if(!empty($filter['departmentid'])) $where['departmentid'] = $filter['departmentid'];
        }
        $list = pdo_getall('ewei_doctor',$where);
        $list = set_medias($list,'avatar');
        return app_json(['list'=>$list]);
    }
    public function get_detail(){
        global $_GPC;
        global $_W;
        if(empty($_GPC['id'])) return app_error(AppError::$ParamsError,'参数错误');
        $list = pdo_get('ewei_doctor',['id'=>$_GPC['id']]);
        $list['avatar'] = tomedia($list['avatar']);
        return app_json(['list'=>$list]);
    }
}

?>