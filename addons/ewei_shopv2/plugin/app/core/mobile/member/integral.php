<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Integral_EweiShopV2Page extends AppMobilePage
{
	public function __construct(){
		parent::__construct();
    }

    public function main(){
        global $_W,$_GPC;
        $member = $this->member;
        $table_record = tablename('ewei_shop_member_credit_record');
        $startTime = strtotime(date("Y-m-d 00:00:00",time()));
        $endTime = strtotime(date("Y-m-d 23:59:59",time()));
        $sql = "select sum(num) from {$table_record} where credittype='credit1' and openid='{$_W['openid']}' and createtime>={$startTime} and createtime<={$endTime} and num>0";
        $today = pdo_fetchcolumn($sql);
        $startTime = $startTime - 86400;
        $endTime = $endTime - 86400;
        $sql = "select sum(num) from {$table_record} where credittype='credit1' and openid='{$_W['openid']}' and createtime>={$startTime} and createtime<={$endTime} and num>0";
        $yesterday = pdo_fetchcolumn($sql);
        $result = [
            'integral'=>$member['credit1'],
            'today'=>$today,
            'yesterday'=>$yesterday,
        ];
        return app_json(['data'=>$result]);
	}

}

?>
