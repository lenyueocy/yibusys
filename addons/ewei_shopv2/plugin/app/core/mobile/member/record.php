<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Record_EweiShopV2Page extends AppMobilePage
{
	public function __construct(){
		parent::__construct();
    }

    public function main(){
		global $_W,$_GPC;
		$listData = pdo_getall('ewei_shop_member_bankcard',['openid'=>$_W['openid']]);
        return app_json(['data'=>$listData?:[]]);
	}
	public function credit(){
        global $_W,$_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = $_GPC['pagesize'];
        if(empty($_GPC['type'])) return app_error(AppError::$ParamsError);
        if(!in_array($_GPC['type'],['credit1','credit2','credit3'])) return app_error(AppError::$ParamsError);
        $table_record = tablename('ewei_shop_member_credit_record');

        $sql = "select * from {$table_record} where openid='{$_W['openid']}' and credittype='{$_GPC['type']}'";
        $total = pdo_fetchcolumn($sql);

        $sql = "select * from {$table_record} where openid='{$_W['openid']}' and credittype='{$_GPC['type']}' order by createtime desc limit ". ($pindex - 1) * $psize . "," . $psize;
        $data = pdo_fetchall($sql);

		//$data = pdo_getall('ewei_shop_member_credit_record',['openid'=>$_W['openid'],'credittype'=>$_GPC['type']]);
		foreach ($data as $key=>&$val){
			$val['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}
		return app_json(['list'=>$data,'total'=>$total]);
	}
}

?>
