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
}

?>