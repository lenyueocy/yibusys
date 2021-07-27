<?php  
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Index_EweiShopV2Page extends WebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		
		$uniacid = $_W['uniacid'];
		$acid = $_W['uniacid'];
		if (empty($uniacid) || empty($acid)) {
			itoast('请选择要编辑的公众号', url('account/manager'), 'error');
		}

		$state = uni_permission($_W['uid'], $uniacid);
		$dos = array('base', 'sms', 'modules_tpl');
		// if ($state == ACCOUNT_MANAGE_NAME_FOUNDER || $state == ACCOUNT_MANAGE_NAME_OWNER) {
		// 	$do = in_array($do, $dos) ? $do : 'base';
		// } elseif ($state == ACCOUNT_MANAGE_NAME_MANAGER) {
		// 	if (ACCOUNT_TYPE == ACCOUNT_TYPE_APP_NORMAL) {
		// 		header('Location: ' . url('wxapp/manage/display', array('uniacid' => $uniacid, 'acid' => $acid)));
		// 		exit;
		// 	} else {
		// 		$do = in_array($do, $dos) ? $do : 'modules_tpl';
		// 	}
		// } else {
		// 	itoast('您是该公众号的操作员，无权限操作！', url('account/manager'), 'error');
		// }

		$_W['page']['title'] = '管理设置 - 微信' . ACCOUNT_TYPE_NAME . '管理';
		$headimgsrc = tomedia('headimg_'.$acid.'.jpg');
		$qrcodeimgsrc = tomedia('qrcode_'.$acid.'.jpg');
		$account = account_fetch($acid);

		if($do == 'base') {
			// if ($state != ACCOUNT_MANAGE_NAME_FOUNDER && $state != ACCOUNT_MANAGE_NAME_OWNER) {
			// 	itoast('无权限操作！', url('account/post/modules_tpl', array('uniacid' => $uniacid, 'acid' => $acid)), 'error');
			// }

			if($_W['ispost'] && $_W['isajax']) {
				if(!empty($_GPC['type'])) {
					$type = trim($_GPC['type']);
				}else {
					iajax(40035, '参数错误！', '');
				}
				switch ($type) {
					case 'qrcodeimgsrc':
					case 'headimgsrc':
						$image_type = array(
							'qrcodeimgsrc' => ATTACHMENT_ROOT . 'qrcode_' . $acid . '.jpg',
							'headimgsrc' => ATTACHMENT_ROOT . 'headimg_' . $acid . '.jpg'
						);
					
						$result = utility_image_rename($_GPC['imgsrc'], $image_type[$type]);
						break;
					case 'name':
						$uni_account = pdo_update('uni_account', array('name' => trim($_GPC['request_data'])), array('uniacid' => $uniacid));
						$account_wechats = pdo_update(uni_account_tablename(ACCOUNT_TYPE), array('name' => trim($_GPC['request_data'])), array('acid' => $acid, 'uniacid' => $uniacid));
						$result = ($uni_account && $account_wechats) ? true : false;
						break;
					case 'account' :
						$data = array('account' => trim($_GPC['request_data']));break;
					case 'original':
						$data = array('original' => trim($_GPC['request_data']));break;
					case 'level':
						$data = array('level' => intval($_GPC['request_data']));break;
					case 'key':
						$data = array('key' => trim($_GPC['request_data']));break;
					case 'secret':
						$data = array('secret' => trim($_GPC['request_data']));break;
					case 'token':
						$oauth = (array)uni_setting($uniacid, array('oauth'));
						if($oauth['oauth'] == $acid && $account['level'] != 4) {
							$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid = :uniacid AND level = 4 AND secret != '' AND `key` != ''", array(':uniacid' => $uniacid));
							pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
						}
						$data = array('token' => trim($_GPC['request_data']));
						break;
					case 'encodingaeskey':
						$oauth = (array)uni_setting($uniacid, array('oauth'));
						if($oauth['oauth'] == $acid && $account['level'] != 4) {
							$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid = :uniacid AND level = 4 AND secret != '' AND `key` != ''", array(':uniacid' => $uniacid));
							pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
						}
						$data = array('encodingaeskey' => trim($_GPC['request_data']));
						break;
					case 'jointype':
						$original_type = pdo_get('account', array('uniacid' => $uniacid), 'type');
						if ($original_type['type'] == ACCOUNT_NORMAL_LOGIN) {
							$result = true;
						} else {
							$update_type = pdo_update('account', array('type' => ACCOUNT_NORMAL_LOGIN), array('uniacid' => $uniacid));
							$result = $update_type ? true : false;
						}
						break;
				}
				if(!in_array($type, array('qrcodeimgsrc', 'headimgsrc', 'name', 'endtime', 'jointype'))) {
					$result = pdo_update(uni_account_tablename(ACCOUNT_TYPE), $data, array('acid' => $acid, 'uniacid' => $uniacid));
				}
				if($result) {
					cache_delete("uniaccount:{$uniacid}");
					cache_delete("unisetting:{$uniacid}");
					cache_delete("accesstoken:{$acid}");
					cache_delete("jsticket:{$acid}");
					cache_delete("cardticket:{$acid}");

					iajax(0, '修改成功！', '');
				}else {
					iajax(1, '修改失败！', '');
				}
			}

			if ($_W['setting']['platform']['authstate']) {
				$account_platform = new WeiXinPlatform();
				$preauthcode = $account_platform->getPreauthCode();
				if (is_error($preauthcode)) {
					$authurl = array(
						'errno' => 1,
						'url' => "{$preauthcode['message']}"
					);
				} else {
					$authurl = array(
						'errno' => 0,
						'url' => sprintf(ACCOUNT_PLATFORM_API_LOGIN, $account_platform->appid, $preauthcode, urlencode(urlencode($GLOBALS['_W']['siteroot'] . 'index.php?c=account&a=auth&do=forward')))
					);
				}
			}
			$socket_url = str_replace(array('https', 'http'), 'wss', $_W['siteroot']);
			$account['end'] = $account['endtime'] == 0 ? '永久' : date('Y-m-d', $account['endtime']);
			$account['endtype'] = $account['endtime'] == 0 ? 1 : 2;
			$uniaccount = array();
			$uniaccount = pdo_get('uni_account', array('uniacid' => $uniacid));

			template('account/manage-base' . ACCOUNT_TYPE_TEMPLATE);
		}

		if($do == 'sms') {
			if ($state != ACCOUNT_MANAGE_NAME_FOUNDER && $state != ACCOUNT_MANAGE_NAME_OWNER) {
				itoast('无权限操作！', url('account/post/modules_tpl', array('uniacid' => $uniacid, 'acid' => $acid)), 'error');
			}
			$settings = uni_setting($uniacid, array('notify'));
			$notify = $settings['notify'] ? $settings['notify'] : array();

			$sms_info = cloud_sms_info();
			$max_num = empty($sms_info['sms_count']) ? 0 : $sms_info['sms_count'];
			$signatures = $sms_info['sms_sign'];

			if ($_W['isajax'] && $_W['ispost'] && $_GPC['type'] == 'balance') {
				if ($max_num == 0) {
					iajax(-1, '您现有短信数量为0，请联系服务商购买短信！', '');
				}
				$balance = intval($_GPC['balance']);
				$notify['sms']['balance'] = $balance;
				$notify['sms']['balance'] = min(max(0, $notify['sms']['balance']), $max_num);
				$count_num = $max_num - $notify['sms']['balance'];
				$num = $notify['sms']['balance'];
				$notify = iserializer($notify);
				$updatedata['notify'] = $notify;
				$result = pdo_update('uni_settings', $updatedata , array('uniacid' => $uniacid));
				if($result){
					iajax(0, array('count' => $count_num, 'num' => $num), '');
				}else {
					iajax(1, '修改失败！', '');
				}
			}
			if($_W['isajax'] && $_W['ispost'] && $_GPC['type'] == 'signature') {
				if (!empty($_GPC['signature'])) {
					$signature = trim($_GPC['signature']);
					$setting = pdo_get('uni_settings', array('uniacid' => $uniacid));
					$notify = iunserializer($setting['notify']);
					$notify['sms']['signature'] = $signature;

					$notify = serialize($notify);
					$result = pdo_update('uni_settings', array('notify' => $notify), array('uniacid' => $uniacid));
					if($result) {
						iajax(0, '修改成功！', '');
					}else {
						iajax(1, '修改失败！', '');
					}
				}else {
					iajax(40035, '参数错误！', '');
				}
			}

			template('account/manage-sms' . ACCOUNT_TYPE_TEMPLATE);
		}

		if($do == 'modules_tpl') {
			$unigroups = uni_groups();
			$owner = account_owner($uniacid);

			if($_W['isajax'] && $_W['ispost'] && ($state == ACCOUNT_MANAGE_NAME_FOUNDER || $state == ACCOUNT_MANAGE_NAME_OWNER)) {
				if($_GPC['type'] == 'group') {
					$groups = $_GPC['groupdata'];
					if(!empty($groups)) {
										pdo_delete('uni_account_group', array('uniacid' => $uniacid));
						$group = pdo_get('users_group', array('id' => $owner['groupid']));
						$group['package'] = (array)iunserializer($group['package']);
						$group['package'] = array_unique($group['package']);
						foreach ($groups as $packageid) {
							if (!empty($packageid) && !in_array($packageid, $group['package'])) {
								pdo_insert('uni_account_group', array(
									'uniacid' => $uniacid,
									'groupid' => $packageid,
								));
							}
						}
						cache_build_account_modules($uniacid);
						cache_build_account($uniacid);
						iajax(0, '修改成功！', '');
					}else {
						pdo_delete('uni_account_group', array('uniacid' => $uniacid));
						cache_build_account_modules($uniacid);
						cache_build_account($uniacid);
						iajax(0, '修改成功！', '');
					}
				}

				if($_GPC['type'] == 'extend') {
								$module = $_GPC['module'];
					$tpl = $_GPC['tpl'];
					if (!empty($module) || !empty($tpl)) {
						$data = array(
							'modules' => iserializer($module),
							'templates' => iserializer($tpl),
							'uniacid' => $uniacid,
							'name' => '',
						);
						$id = pdo_fetchcolumn("SELECT id FROM ".tablename('uni_group')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
						if (empty($id)) {
							pdo_insert('uni_group', $data);
						} else {
							pdo_update('uni_group', $data, array('id' => $id));
						}
					} else {
						pdo_delete('uni_group', array('uniacid' => $uniacid));
					}
					cache_build_account_modules($uniacid);
					cache_build_account($uniacid);
					iajax(0, '修改成功！', '');
				}
				iajax(40035, '参数错误！', '');
			}
			$modules_tpl = $extend = array();

			$founders = explode(',', $_W['config']['setting']['founder']);
			if (in_array($owner['uid'], $founders)) {
				$modules_tpl[] = array(
					'id' => -1,
					'name' => '所有服务',
					'modules' => array(array('name' => 'all', 'title' => '所有模块')),
					'templates' => array(array('name' => 'all', 'title' => '所有模板')),
				);
			} else {
				$owner['group'] = pdo_get('users_group', array('id' => $owner['groupid']), array('id', 'name', 'package'));
				$owner['group']['package'] = iunserializer($owner['group']['package']);
				if(!empty($owner['group']['package'])){
					foreach ($owner['group']['package'] as $package_value) {
						if($package_value == -1){
							$modules_tpl[] = array(
								'id' => -1,
								'name' => '所有服务',
								'modules' => array(array('name' => 'all', 'title' => '所有模块')),
								'templates' => array(array('name' => 'all', 'title' => '所有模板')),
							);
						}elseif ($package_value == 0) {

						}else {
							$modules_tpl[] = $unigroups[$package_value];
						}
					}
				}
						$extendpackage = pdo_getall('uni_account_group', array('uniacid' => $uniacid), array(), 'groupid');
				if(!empty($extendpackage)) {
					foreach ($extendpackage as $extendpackage_val) {
						if($extendpackage_val['groupid'] == -1){
							$modules_tpl[] = array(
								'id' => -1,
								'name' => '所有服务',
								'modules' => array(array('name' => 'all', 'title' => '所有模块')),
								'templates' => array(array('name' => 'all', 'title' => '所有模板')),
							);
						}elseif ($extendpackage_val['groupid'] == 0) {

						}else {
							$modules_tpl[] = $unigroups[$extendpackage_val['groupid']];
						}
					}
				}
			}

			$modules = pdo_getall('modules', array('issystem !=' => 1), array('mid', 'name', 'title'), 'name');
			$templates = pdo_getall('site_templates', array(), array('id', 'name', 'title'));
			$extend = pdo_get('uni_group', array('uniacid' => $uniacid));
			$extend['modules'] = $current_module_names = iunserializer($extend['modules']);
			$extend['templates'] = iunserializer($extend['templates']);
			if (!empty($extend['modules'])) {
				foreach ($extend['modules'] as $module_key => $module_val) {
					$extend['modules'][$module_key] = module_fetch($module_val);
				}
			}
			if (!empty($extend['templates'])) {
				$extend['templates'] = pdo_getall('site_templates', array('id' => $extend['templates']), array('id', 'name', 'title'));
			}
		}


		include($this->template());
	}
	 
	 	public function post(){

		global $_W;
		global $_GPC;
		define(ACCOUNT_TYPE, $_W['uniacid']);
		load()->model('module');
		load()->model('cloud');
		load()->model('cache');
		load()->classs('weixin.platform');
		load()->model('utility');
		load()->func('file');
		$acid =  $_W['uniacid'];
		$uniacid = $_W['uniacid'];
		$headimgsrc = tomedia('headimg_'.$acid.'.jpg');
$qrcodeimgsrc = tomedia('qrcode_'.$acid.'.jpg');
$account = account_fetch($acid);
		if($_W['ispost'] && $_W['isajax']) {
		if(!empty($_GPC['type'])) {
			$type = trim($_GPC['type']);
		} else {
			iajax(40035, '参数错误！', '');
		}
		$request_data = safe_gpc_string(trim($_GPC['request_data']));
		switch ($type) {
			case 'qrcodeimgsrc':
			case 'headimgsrc':
				$image_type = array(
					'qrcodeimgsrc' => ATTACHMENT_ROOT . 'qrcode_' . $acid . '.jpg',
					'headimgsrc' => ATTACHMENT_ROOT . 'headimg_' . $acid . '.jpg'
				);
				$imgsrc = safe_gpc_path($_GPC['imgsrc']);
				if(file_is_image($imgsrc)){
					$result = utility_image_rename($imgsrc, $image_type[$type]);
				} else {
					$result = '';
				}
				break;
			case 'name':
				$uni_account = pdo_update('uni_account', array('name' => $request_data), array('uniacid' => $uniacid));
				
				$account_wechats = pdo_update($account->tablename, array('name' => $request_data), array('acid' => $acid, 'uniacid' => $uniacid));
				$result = ($uni_account && $account_wechats) ? true : false;
				break;
			case 'account' :
				$data = array('account' => $request_data);break;
			case 'original':
				$data = array('original' => $request_data);break;
			case 'level':
				$data = array('level' => intval($_GPC['request_data']));break;
			case 'appid':
				$data = array('appid' => $request_data);break;
			case 'key':
				$data = array('key' => $request_data);break;
			case 'secret':
				$data = array('secret' => $request_data);break;
			case 'token':
				$oauth = (array)uni_setting_load(array('oauth'), $uniacid);
				if($oauth['oauth'] == $acid && $account['level'] != 4) {
					$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid = :uniacid AND level = 4 AND secret != '' AND `key` != ''", array(':uniacid' => $uniacid));
					pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
				}
				$data = array('token' => $request_data);
				break;
			case 'encodingaeskey':
				$oauth = (array)uni_setting_load(array('oauth'), $uniacid);
				if($oauth['oauth'] == $acid && $account['level'] != 4) {
					$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid = :uniacid AND level = 4 AND secret != '' AND `key` != ''", array(':uniacid' => $uniacid));
					pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
				}
				$data = array('encodingaeskey' => $request_data);
				break;
			case 'jointype':
				if (in_array($account['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_APP_NORMAL))) {
					$result = true;
				} else {
					$change_type = array(
						'type' => $account->typeSign == 'account' ? ACCOUNT_TYPE_OFFCIAL_NORMAL : ACCOUNT_TYPE_APP_NORMAL
					);
					$update_type = pdo_update('account', $change_type, array('uniacid' => $uniacid));
					$result = $update_type ? true : false;
				}
				break;
			case 'highest_visit':
				if (user_is_vice_founder() || empty($_W['isfounder'])) {
					iajax(1, '只有创始人可以修改！');
				}
				$statistics_setting = (array)uni_setting_load(array('statistics'), $uniacid);
				if (!empty($statistics_setting['statistics'])) {
					$highest_visit = $statistics_setting['statistics'];
					$highest_visit['founder'] = intval($_GPC['request_data']);
				} else {
					$highest_visit = array('founder' => intval($_GPC['request_data']));
				}
				$result = pdo_update('uni_settings', array('statistics' => iserializer($highest_visit)), array('uniacid' => $uniacid));
				break;
			case 'endtime':
				$endtime = strtotime($_GPC['endtime']);
				if ($endtime <= 0) {
					iajax(1, '参数错误！');
				}
				
					$store_create_account_info = table('store')->StoreCreateAccountInfo($uniacid);
				
				if (user_is_founder($_W['uid'], true)) {
					
						if (!empty($store_create_account_info)) {
							pdo_update('site_store_create_account', array('endtime' => $endtime), array('uniacid' => $uniacid));
						}
					
				} else {
					$owner_id = pdo_getcolumn('uni_account_users', array('uniacid' => $uniacid, 'role' => 'owner'), 'uid');
					$user_endtime = pdo_getcolumn('users', array('uid' => $owner_id), 'endtime');
					
						if (!empty($store_create_account_info)) {
							$user_endtime = max($user_endtime, $store_create_account_info['endtime']);
						}
					
					if ($user_endtime < $endtime && !empty($user_endtime)) {
						iajax(1, '设置到期日期不能超过' . date('Y-m-d', $user_endtime));
					}
				}
				$result = pdo_update('account', array('endtime' => $endtime), array('uniacid' => $uniacid));
				break;
			case 'attachment_limit':
				if (user_is_vice_founder() || empty($_W['isfounder'])) {
					iajax(1, '只有创始人可以修改！');
				}
				$has_uniacid = pdo_getcolumn('uni_settings', array('uniacid' => $uniacid), 'uniacid');
				if ($_GPC['request_data'] < 0) {
					$attachment_limit = -1;
				} else {
					$attachment_limit = intval($_GPC['request_data']);
				}
				if (empty($has_uniacid)) {
					$result = pdo_insert('uni_settings', array('attachment_limit' => $attachment_limit, 'uniacid' => $uniacid));
				} else {
					$result = pdo_update('uni_settings', array('attachment_limit' => $attachment_limit), array('uniacid' => $uniacid));
				}
				break;
		}
		
		if(!in_array($type, array('qrcodeimgsrc', 'headimgsrc', 'name', 'endtime', 'jointype', 'highest_visit', 'attachment_limit'))) {
			$result = pdo_update($account->tablename, $data, array('acid' => $acid, 'uniacid' => $uniacid));
		}

		if($result) {
			cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
			cache_delete(cache_system_key('accesstoken', array('acid' => $acid)));
			cache_delete(cache_system_key('statistics', array('uniacid' => $uniacid)));
			iajax(0, '修改成功！', '');
		} else {
			iajax(1, '修改失败！', '');
		}
	}
	}


	public function updatepassword() 
	{
		global $_W;
		global $_GPC;
			$extendfields = pdo_fetchall("SELECT field, title, description, required FROM ".tablename('profile_fields')." WHERE available = '1' AND showinregister = '1' ORDER BY displayorder DESC");
		$sql = "SELECT username, password, salt, groupid, starttime, endtime FROM " . tablename('users') . " WHERE `uid` = '{$_W['uid']}'";
		$user = pdo_fetch($sql);
		if (empty($user)) {
			show_json( -1,'抱歉，用户不存在或是已经被删除！');
		}
		$user['groupname'] = pdo_fetchcolumn('SELECT name FROM ' . tablename('users_group') . ' WHERE id = :id', array(':id' => $user['groupid']));
		//print_r($user);
		if ($_W['ispost']) 
		{
	
			ca('sysset.profile.edit');
			if (empty($_GPC['name']) || empty($_GPC['password']) || empty($_GPC['newpassword'])) {
				show_json(0,"管理账号或者密码不能为空，请重新填写！");
			//	message('管理账号或者密码不能为空，请重新填写！', url('user/profile'), 'error');
			}
			//show_json(0,"cehsi".$_GPC['pw3']);
			if ($_GPC['surenewpassword'] != $_GPC['newpassword']) {
					show_json(0,"两次输入的新密码不一致，请重新输入！     ");
			}
			if ($_GPC['password'] == $_GPC['newpassword']) {
				show_json(0,"新密码与原密码一致，请检查！     ");
			//	message('新密码与原密码一致，请检查！', url('user/profile'), 'error');
			}
			$password_old = user_hash($_GPC['password'], $user['salt']);
			if ($user['password'] != $password_old) {
				show_json(0,"原密码错误，请重新填写！         ");
			//	message('原密码错误，请重新填写！', url('user/profile'), 'error');
			}
			$result = '';
			$members = array(
				'username' => $_GPC['name'],
				'password' => user_hash($_GPC['newpassword'], $user['salt']),
			);
			$result = pdo_update('users', $members, array('uid' => $_W['uid']));
					
			plog('sysset.profile.edit', '修改WAP设置');
			show_json(1, array('message' => "修改成功,请重新登录！！！ ", 'url' => "/web/index.php?c=user&a=login&"));
			
		}
		include $this->template();
	}
	
	public function updatecache() 
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) 
		{
			ca('sysset.updatecache.edit');
			
			cache_build_template();
			cache_build_users_struct();
			cache_build_setting();
			cache_build_account_modules();
			cache_build_account();
			cache_build_accesstoken();
			cache_build_frame_menu();
			cache_build_module_subscribe_type();
			cache_build_platform();
			cache_build_stat_fans();
			cache_build_cloud_ad();
			plog('sysset.updatecache.edit', '修改WAP设置');
			show_json(1,"缓存更新成功！");
		}
		load()->model('cache');
		load()->model('setting');
		include $this->template();
	}
	
}
?>