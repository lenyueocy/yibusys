<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Wallet_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_GPC;
		global $_W;
		$member = $this->member;

        //获取释放
        $table_release_log = tablename('ewei_shop_member_release_log');
        $startTime = strtotime(date("Y-m-d 00:00:00",time()));
        $endTime = strtotime(date("Y-m-d 23:59:59",time()));
        $sql = "select sum(num) from {$table_release_log} where openid='{$_W['openid']}' and createtime>={$startTime} and createtime<={$endTime}";
        $today = pdo_fetchcolumn($sql);

        $result = [
        	'credit1'=>$member['credit1'],
        	'credit2'=>$member['credit2'],
			'is_release'=>$today>0?true:false,
			'bankcardNum'=>pdo_count('ewei_shop_member_bankcard',['openid'=>$_W['openid']]),
		];
		return app_json($result);
	}

}

?>
