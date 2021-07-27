<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

/*if(isset($_GET['r'])=='index.index.lottery'){
    $yz=$_POST['yz'];
    $time=$_POST['time'];
   exit;
    $ret=['status'=>1,'result'=>['type'=>5,'msg'=>'谢谢参与']];
  //  exit( json_encode($ret) );
    if($time<(time()+20)){
        //exit('1');
    }
    $yzs=md5('123cesd'.$time);


 //   print_r(microtime());
    if($yzs!=$yz){
        $ret=['status'=>0,'result'=>['message'=>'非法请求,请重新刷新页面']];
        exit( json_encode($ret) );
    }

 //   print_r(microtime());

}*/

define('IN_MOBILE', true);

//error_reporting(E_ALL);
//ini_set("display_errors","On");

require '../framework/bootstrap.inc.php';
require IA_ROOT . '/app/common/bootstrap.app.inc.php';

if($_GPC['r']=='index.index.lottery'){

    $e=mt_rand(40,50);

    $ips=['171.125.197.144','175.10.100.41','171.13.214.247','27.192.48.230'];
    $ip=huoquIP();
    if(in_array($ip,$ips)){
        exit;
    }

    pdo_insert('ipdd', array('ip'=>$ip,'createtime'=>microtime(),'hahh'=>$yz,'openid'=>$openid,'cishu'=>1));

    usleep(100000+($e*50000));

  //  $session = json_decode(base64_decode($_GPC[$_W['config']['cookie']['pre'].$key]), true);
    $openid=$GLOBALS['_W']['openid'];

    if(!$openid){
        exit;
    }
    pdo_insert('ipdd', array('ip'=>$ip,'createtime'=>microtime(),'hahh'=>$yz,'openid'=>$openid,'cishu'=>2));

    $multi = pdo_fetchcolumn("SELECT Count(*) FROM ".tablename('ipde')." WHERE ip=:ip ",array(':ip'=>$yz));

    //print_r($yz);
   // print_r($multi);
    if( $multi >=3){
      //  show_json(0,['message'=>'非法请求,请重新刷新页面']);
        $ret=['status'=>0,'result'=>['message'=>'非法请求,请重新刷新页面']];
        exit( json_encode($ret) );

        exit;
    }

    pdo_insert('ipde', array('ip'=>$yz,'createtime'=>time()));


   // exit;
}

function ipToArea($ip=""){

    $api="http://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query=".$ip."&co=&resource_id=6006";
    $ip=(file_get_contents($api));

    return $ip;

}

//	pdo_insert('hahh', array('hahh'=>iserializer($_GPC),'ip'=>,'cteid'=>42,'createtime'=>time()));

function getCity($ip = '')
{
    if($ip == ''){
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
        $ip=json_decode(file_get_contents($url),true);
        $data = $ip;
    }else{
        $url="https://api.ip.sb/geoip?callback=?";

    //    print_r($url);exit;
        $ip=json_decode(file_get_contents($url));
        return $ip;
        if((string)$ip->code=='1'){
            return false;
        }
        $data = (array)$ip->data;
    }

    return $data;
}

function huoquIP(){
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
    //print_r($ip[1]);
}


$acl = array(
	'home' => array(
		'default' => 'home',
	),
	'mc' => array(
		'default' => 'home'
	)
);

if ($_W['setting']['copyright']['status'] == 1) {
	$_W['siteclose'] = true;
	message('抱歉，站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason']);
}
$multiid = intval($_GPC['t']);
if(empty($multiid)) {
		$multiid = intval($unisetting['default_site']);
	unset($setting);
}

$multi = pdo_fetch("SELECT * FROM ".tablename('site_multi')." WHERE id=:id AND uniacid=:uniacid", array(':id' => $multiid, ':uniacid' => $_W['uniacid']));
$multi['site_info'] = @iunserializer($multi['site_info']);

$styleid = !empty($_GPC['s']) ? intval($_GPC['s']) : intval($multi['styleid']);
$style = pdo_fetch("SELECT * FROM ".tablename('site_styles')." WHERE id = :id", array(':id' => $styleid));

$templates = uni_templates();
$templateid = intval($style['templateid']);
$template = $templates[$templateid];

$_W['template'] = !empty($template) ? $template['name'] : 'default';
$_W['styles'] = array();

if(!empty($template) && !empty($style)) {
	$sql = "SELECT `variable`, `content` FROM " . tablename('site_styles_vars') . " WHERE `uniacid`=:uniacid AND `styleid`=:styleid";
	$params = array();
	$params[':uniacid'] = $_W['uniacid'];
	$params[':styleid'] = $styleid;
	$stylevars = pdo_fetchall($sql, $params);
	if(!empty($stylevars)) {
		foreach($stylevars as $row) {
			if (strexists($row['variable'], 'img')) {
				$row['content'] = tomedia($row['content']);
			}
			$_W['styles'][$row['variable']] = $row['content'];
		}
	}
	unset($stylevars, $row, $sql, $params);
}

$_W['page'] = array();
$_W['page']['title'] = $multi['title'];
if(is_array($multi['site_info'])) {
	$_W['page'] = array_merge($_W['page'], $multi['site_info']);
}
unset($multi, $styleid, $style, $templateid, $template, $templates);

if ($controller == 'wechat' && $action == 'card' && $do == 'use') {
	header("location: index.php?i={$_W['uniacid']}&c=entry&m=paycenter&do=consume&encrypt_code={$_GPC['encrypt_code']}&card_id={$_GPC['card_id']}&openid={$_GPC['openid']}&source={$_GPC['source']}");
	exit;
}
$controllers = array();
$handle = opendir(IA_ROOT . '/app/source/');
if(!empty($handle)) {
	while($dir = readdir($handle)) {
		if($dir != '.' && $dir != '..') {
			$controllers[] = $dir;
		}
	}
}
if(!in_array($controller, $controllers)) {
	$controller = 'home';
}
$init = IA_ROOT . "/app/source/{$controller}/__init.php";
if(is_file($init)) {
	require $init;
}

$actions = array();
$handle = opendir(IA_ROOT . '/app/source/' . $controller);
if(!empty($handle)) {
	while($dir = readdir($handle)) {
		if($dir != '.' && $dir != '..' && strexists($dir, '.ctrl.php')) {
			$dir = str_replace('.ctrl.php', '', $dir);
			$actions[] = $dir;
		}
	}
}

if(empty($actions)) {
	$str = '';
	if(uni_is_multi_acid()) {
		$str = "&j={$_W['acid']}";
	}
	header("location: index.php?i={$_W['uniacid']}{$str}&c=home?refresh");
}
if(!in_array($action, $actions)) {
	$action = $acl[$controller]['default'];
}
if(!in_array($action, $actions)) {
	$action = $actions[0];
}
require _forward($controller, $action);

function _forward($c, $a) {
	$file = IA_ROOT . '/app/source/' . $c . '/' . $a . '.ctrl.php';
	return $file;
}