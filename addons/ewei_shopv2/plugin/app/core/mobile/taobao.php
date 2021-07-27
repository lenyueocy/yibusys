<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Taobao_EweiShopV2Page extends AppMobilePage
{
    public function __construct(){

    }
    public function run(){
    	global $_GPC,$_W;
    	$table_taobao_url = tablename('shop_taobao_url');
    	$sql = "select * from {$table_taobao_url} where status=0 order by id asc limit 1";
    	$taobao_url = pdo_fetch($sql);
		if(empty($taobao_url)) exit;
		//$_GPC['url'] = 'https://detail.m.tmall.com/item.htm?isNew=false&downgradesource=h5_2&hideSmb=true&id=613551312694&spm=a2141.7631671.content.99';
		//$url = $_GPC['url'];
		$url = $taobao_url['url'];
		if (is_numeric($url)) {
			$itemid = $url;
		} else {
			preg_match('/id\\=(\\d+)/i', $url, $matches);
			if (isset($matches[1])) {
				$itemid = $matches[1];
			}
		}
		$model = m('plugin')->loadModel('taobao');
    	$result = $model->get_item_tmall_bypage($itemid, $_GPC['url'], 0);
    	if($result['result']==1){
    		pdo_update('shop_taobao_url',['status'=>1],['id'=>$taobao_url['id']]);
		}
		echo "<pre>";
		print_r($result);
		exit;
	}
}

?>
