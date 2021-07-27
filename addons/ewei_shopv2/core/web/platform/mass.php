<?php  
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Mass_EweiShopV2Page extends WebPage 
{

	public function main() 
	{
		global $_W;
		global $_GPC;
		global $setting_keyword;
	   	
 		$active_sub_permission=array(
		'post'=>array(
			'title'=>'定时群发',
			'url'=>webUrl('platform.mass',array()),
			'permission_name'=>'post',
			'active'=>'post',
		),'send'=>array(
			'title'=>'群发记录',
			'url'=>webUrl('platform.mass',array('dos'=>'send')),
			'permission_name'=>'send',
			'active'=>'send',
		),
 
		
	);
			 
		load()->func('cron');
		load()->model('cloud');
		load()->model('module');
		load()->model('mc');
		load()->model('material');
		
		$do=$_GPC['dos'];
		$dos = array('list', 'post', 'cron', 'send', 'del', 'preview');
		$do = in_array($do, $dos) ? $do : 'post';

	 
		if ($do == 'list') {
			$time = strtotime(date('Y-m-d'));
			$record = pdo_getall('mc_mass_record', array('uniacid' => $_W['uniacid'], 'sendtime >=' => $time), array(), 'sendtime', 'sendtime ASC', array(1,7));

			$days = array();
			for ($i = 0; $i < 8; $i++) {
				$day_info = array();
				$day_info['day'] = date('Y-m-d', strtotime("+{$i} days", $time));

				$starttime = strtotime("+{$i} days", $time);
				$endtime = $i+1;
				$endtime = strtotime("+{$endtime} days", $time);
				$massdata = pdo_fetch('SELECT id, `groupname`, `msgtype`, `group`, `attach_id`, `media_id`, `sendtime` FROM '. tablename('mc_mass_record') . ' WHERE uniacid = :uniacid AND sendtime BETWEEN :starttime AND :endtime AND status = 1', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime));

				if (!empty($massdata)) {
					$massdata['media'] = pdo_get('wechat_attachment', array('id' => $massdata['attach_id']));
					$massdata['media']['attach'] = tomedia($massdata['media']['attachment']);
					$massdata['media']['createtime_cn'] = date('Y-m-d H:i', $massdata['media']['createtime']);
					switch ($massdata['msgtype']) {
						case 'news':
							$massdata['msgtype_zh'] = '图文';
							$massdata['media']['items'] = pdo_getall('wechat_news', array('attach_id' => $massdata['attach_id']));
							foreach ($massdata['media']['items'] as  &$news_val) {
								$news_val['thumb_url'] = tomedia($news_val['thumb_url']);
							}
							unset($news_val);
							break;
						case 'image':
							$massdata['msgtype_zh'] = '图片';
							break;
						case 'voice':
							$massdata['msgtype_zh'] = '语音';
							break;
						case 'video':
							$massdata['msgtype_zh'] = '视频';
							$massdata['media']['attach']['tag'] = iunserializer($massdata['media']['tag']);
							break;
					}
					$massdata['clock'] = date('H:m', $massdata['sendtime']);
				}
				$day_info['info'] = $massdata;
				$days[] = $day_info;
			}

				include($this->template());
		}



if ($do == 'del') {
	$mass = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => intval($_GPC['id'])));
	if (!empty($mass) && $mass['cron_id'] > 0) {
		$status = cron_delete(array($mass['cron_id']));
		if (is_error($status)) {
			iajax(0, $status, '');
		}
	}
	pdo_delete('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => intval($_GPC['id'])));
	itoast('删除成功', '', 'info');
}

if ($do == 'post') {
	permission_check_account_user('platform_masstask_post');
	$id = intval($_GPC['id']);
	$mass_info = pdo_get('mc_mass_record', array('id' => $id));
	$groups = mc_fans_groups();
	$account_api = WeAccount::createByUniacid();
	$supports = $account_api->getMaterialSupport();
	$show_post_content = $supports['mass'];

	if (checksubmit('submit')) {
		$type = in_array(intval($_GPC['type']), array(0, 1)) ? intval($_GPC['type']) : 0;
		$group = json_decode(htmlspecialchars_decode($_GPC['group']), true);

		if (empty($_GPC['reply'])) {
			itoast('请选择要群发的素材', '', 'error');
		}
		$mass_record = array(
			'uniacid' => $_W['uniacid'],
			'acid' => $_W['acid'],
			'groupname' => $group['name'],
			'fansnum' => $group['count'],
			'msgtype' => '',
			'group' => $group['id'],
			'attach_id' => '',
			'media_id' => '',
			'status' => 1,
			'type' => $type,
			'sendtime' => TIMESTAMP,
			'createtime' => TIMESTAMP,
			'cron_id' => 0,
		);
		foreach ($_GPC['reply'] as $material_type => $material) {
			if (empty($material)) {
				continue;
			}
			list($temp, $msgtype) = explode('_', $material_type);
			$attachment = material_get($material);
			if ($attachment['model'] == 'local') {
				itoast('图文素材请选择微信素材', '', 'error');
			}

			if ($material_type == 'reply_basic') {
				$material = htmlspecialchars_decode($material);
				$material = trim($material, '\"');
			}

			$mass_record['media_id'] = $material;
			$mass_record['attach_id'] = $attachment['id'];
			$mass_record['msgtype'] = $msgtype;
			break;
		}

				if ($type == 1) {
			$cloud = cloud_prepare();
			if (is_error($cloud)) {
				itoast($cloud['message'], '', 'error');
			}
			set_time_limit(0);

			$starttime = strtotime(date('Y-m-d', strtotime($_GPC['sendtime'])));
			$endtime = strtotime(date('Y-m-d', strtotime($_GPC['sendtime']))) + 86400;
			$cron_title  = date('Y-m-d', strtotime($_GPC['sendtime'])) . '微信群发任务';

			$mass_record['sendtime'] = strtotime($_GPC['sendtime']);

			$records = pdo_fetchall("SELECT id, cron_id FROM " . tablename('mc_mass_record') . ' WHERE uniacid = :uniacid AND sendtime BETWEEN :starttime AND :endtime AND status = 1 ORDER BY sendtime ASC LIMIT 8', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime), 'id');
			if (!empty($records)) {
				foreach ($records as $record) {
					if (!$record['cron_id']) {
						continue;
					}
					$corn_ids[] = $record['cron_id'];
				}
				if (!empty($corn_ids)) {
					$status = cron_delete($corn_ids);
					if (is_error($status)) {
						itoast('删除群发错误,请重新提交', referer());
					}
				}
				$ids = implode(',', array_keys($records));
				pdo_delete('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => array($ids)));
			}

			pdo_insert('mc_mass_record', $mass_record);
			$mass_record_id = pdo_insertid();

			$cron_data = array(
				'uniacid' => $_W['uniacid'],
				'name' => $cron_title,
				'filename' => 'mass',
				'type' => 1,
				'lastruntime' => $mass_record['sendtime'],
				'extra' => $mass_record_id,
				'module' => 'task',
				'status' => 1,
			);
			$status = cron_add($cron_data);
			if (is_error($status)) {
				$message = "{$cron_title}同步到云服务失败,请手动同步<br>";
				itoast($message, url('platform/mass/send'), 'info');
			}

			pdo_update('mc_mass_record', array('cron_id' => $status), array('id' => $mass_record_id, 'uniacid' => $_W['uniacid']));
			itoast('定时群发设置成功', webUrl('platform/mass',array('dos'=>'send')), 'success');
		} else {
			$account_api = WeAccount::createByUniacid();
			$msgtype = $msgtype == 'basic' ? 'text' : $msgtype;
			$result = $account_api->fansSendAll($group['id'], $msgtype, $mass_record['media_id']);
			if (is_error($result)) {
				itoast($result['message'], url('platform/mass'), 'info');
			}
			if ($msgtype == 'news') {
				$mass_record['msg_id'] = $result['msg_id'];
				$mass_record['msg_data_id'] = $result['msg_data_id'];
			}
			$mass_record['status'] = 0;
			pdo_insert('mc_mass_record', $mass_record);
			itoast('立即发送设置成功', webUrl('platform/mass',array('dos'=>'send')), 'success');
		}
	}
	include($this->template('platform/mass/post'));
	exit;
	//template('platform/mass-post');
}

if ($do == 'cron') {
	$id = intval($_GPC['id']);
	$record = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($record)) {
		itoast('群发任务不存在或已删除', referer(), 'error');
	}
	$cron = array(
		'uniacid' => $_W['uniacid'],
		'name' => date('Y-m-d', $record['sendtime']) . "微信群发任务",
		'filename' => 'mass',
		'type' => 1,
		'lastruntime' => $record['sendtime'],
		'extra' => $record['id'],
		'module' => 'task',
		'status' => 1
	);
	$status = cron_add($cron);
	if (is_error($status)) {
		itoast($status['message'], referer(), 'error');
	}
	pdo_update('mc_mass_record', array('cron_id' => $status), array('uniacid' => $_W['uniacid'], 'id' => $id));
	itoast('同步到云服务成功', referer(), 'success');
}

if ($do == 'preview') {
	$wxname = trim($_GPC['wxname']);
	if (empty($wxname)) {
		iajax(1, '微信号不能为空', '');
	}
	$type = trim($_GPC['type']);
	$media_id = trim($_GPC['media_id']);
	$account_api = WeAccount::createByUniacid();
	$data = $account_api->fansSendPreview($wxname, $media_id, $type);
	if (is_error($data)) {
		iajax(-1, $data['message'], '');
	}
	iajax(0, 'success', '');
}

if ($do == 'send') {
	permission_check_account_user('platform_masstask_send');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = ' WHERE `uniacid` = :uniacid AND `acid` = :acid';
	$params = array();
	$params[':uniacid'] = $_W['uniacid'];
	$params[':acid'] = $_W['acid'];
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_mass_record') . $condition, $params);
	$lists = pdo_getall('mc_mass_record', array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid']), array(), '', 'id DESC', 'LIMIT '.($pindex-1)* $psize.','.$psize);
	$types = array('text' => '文本消息', 'image' => '图片消息', 'voice' => '语音消息', 'video' => '视频消息', 'news' => '图文消息', 'wxcard' => '微信卡券');
	$pager = pagination($total, $pindex, $psize);
		include($this->template('platform/mass/send'));
		exit;
	//template('platform/mass-send');
}
	//	include($this->template());
	}
	
	
	public function post() {
		global $_W;
		global $_GPC;
		
		load()->model('mc');
		load()->model('menu');
		load()->model('material');

 		$active_sub_permission=array(
		'post'=>array(
			'title'=>'默认菜单',
			'url'=>webUrl('platform.menu',array('dos'=>'post')),
			'permission_name'=>'post',
			'active'=>'post',
		),'display'=>array(
			'title'=>'个性化菜单',
			'url'=>webUrl('platform.menu',array('dos'=>'display','type'=>3)),
			'permission_name'=>'display',
			'active'=>'display',
		),
 
		
	);
		permission_check_account_user('platform_menu_default');
		$type = intval($_GPC['type']);
		$id = intval($_GPC['id']);
		$copy = intval($_GPC['copy']);
	
		if (empty($type)) {
			
			if (!$_W['isajax']) {
				$update_self_menu = menu_update_currentself();
			//		print_r($update_self_menu);exit;
				if (is_error($update_self_menu)) {
					itoast($update_self_menu['message'], '', 'info');
				}
			}
			$type = MENU_CURRENTSELF;
			$default_menu = menu_default();
			$id = intval($default_menu['id']);
		}
		$params = array();
		if ($id > 0) {
			$menu = menu_get($id);
			if (empty($menu)) {
				itoast('菜单不存在或已经删除', weburl('platform/menu'), 'error');
			}
			if (!empty($menu['data'])) {
				$menu['data'] = iunserializer(base64_decode($menu['data']));
				if (!empty($menu['data']['button'])) {
					foreach ($menu['data']['button'] as &$button) {
						if (!empty($button['url'])) {
							$button['url'] = preg_replace('/(.*)redirect_uri=(.*)&response_type(.*)wechat_redirect/', '$2', $button['url']);
							$button['url'] = urldecode($button['url']);
						}
						if (empty($button['sub_button'])) {
							if ($button['type'] == 'media_id') {
								$button['type'] = 'click';
							}
							$button['sub_button'] = array();
						} else {
							$button['sub_button'] = !empty($button['sub_button']['list']) ? $button['sub_button']['list'] : $button['sub_button'];
							foreach ($button['sub_button'] as &$subbutton) {
								if (!empty($subbutton['url'])) {
									$subbutton['url'] = preg_replace('/(.*)redirect_uri=(.*)&response_type(.*)wechat_redirect/', '$2', $subbutton['url']);
									$subbutton['url'] = urldecode($subbutton['url']);
								}
								if ($subbutton['type'] == 'media_id') {
									$subbutton['type'] = 'click';
								}
							}
							unset($subbutton);
						}
					}
					unset($button);
				}
				if (!empty($menu['data']['matchrule']['province'])) {
					$menu['data']['matchrule']['province'] .= '省';
				}
				if (!empty($menu['data']['matchrule']['city'])) {
					$menu['data']['matchrule']['city'] .= '市';
				}
				if (empty($menu['data']['matchrule']['sex'])) {
					$menu['data']['matchrule']['sex'] = 0;
				}
				if (empty($menu['data']['matchrule']['group_id'])) {
					$menu['data']['matchrule']['group_id'] = -1;
				}
				if (empty($menu['data']['matchrule']['client_platform_type'])) {
					$menu['data']['matchrule']['client_platform_type'] = 0;
				}
				if (empty($menu['data']['matchrule']['language'])) {
					$menu['data']['matchrule']['language'] = '';
				}
				$params = $menu['data'];
				$params['title'] = $menu['title'];
				$params['type'] = $menu['type'];
				$params['id'] = $menu['id'];
				$params['status'] = $menu['status'];
			}
			$type = $menu['type'];
		}
		$status = $params['status'];
		$groups = mc_fans_groups();
		$languages = menu_languages();
		if ($_W['isajax'] && $_W['ispost']) {
			set_time_limit(0);
			$_GPC['group']['title'] = trim($_GPC['group']['title']);
			$_GPC['group']['type'] = intval($_GPC['group']['type']) == 0 ? 1 : intval($_GPC['group']['type']);
			$post = $_GPC['group'];
					if (empty($post['title'])) {
				iajax(-1, '请填写菜单组名称！', '');
			}
			$check_title_exist_condition = array(
				'title' => $post['title'],
				'type' => $type,
			);
			if (!empty($id)) {
				$check_title_exist_condition['id <>'] = $id;
			}
			$check_title_exist = pdo_getcolumn('uni_account_menus', $check_title_exist_condition, 'id');
			if (!empty($check_title_exist)) {
				iajax(-1, '菜单组名称已存在，请重新命名！', '');
			}
					if ($post['type'] == MENU_CONDITIONAL && empty($post['matchrule'])) {
				iajax(-1, '请选择菜单显示对象', '');
			}
			if (!empty($post['button'])) {
				foreach ($post['button'] as $key => &$button) {
					$keyword_exist = strexists($button['key'], 'keyword:');
					if ($keyword_exist) {
						$button['key'] = substr($button['key'], 8);
					}
					if (!empty($button['sub_button'])) {
						foreach ($button['sub_button'] as &$subbutton) {
							$sub_keyword_exist = strexists($subbutton['key'], 'keyword:');
							if ($sub_keyword_exist) {
								$subbutton['key'] = substr($subbutton['key'], 8);
							}
						}
						unset($subbutton);
					}
				}
				unset($button);
			}

			$is_conditional = $post['type'] == MENU_CONDITIONAL ? true : false;
			$account_api = WeAccount::createByUniacid();
			$menu = $account_api->menuBuild($post, $is_conditional);
			if ($_GPC['submit_type'] == 'publish' || $is_conditional) {
				$result = $account_api->menuCreate($menu);
			} else {
				$result = true;
			}
			if (is_error($result)) {
				iajax($result['errno'], $result['message']);
			} else {
							if ($post['matchrule']['group_id'] != -1) {
					$menu['matchrule']['groupid'] = $menu['matchrule']['tag_id'];
					unset($menu['matchrule']['tag_id']);
				}
				$menu = json_decode(urldecode(json_encode($menu)), true);

				$insert = array(
					'uniacid' => $_W['uniacid'],
					'menuid' => $result,
					'title' => $post['title'],
					'type' => $post['type'],
					'sex' => intval($menu['matchrule']['sex']),
					'group_id' => isset($menu['matchrule']['group_id']) ? $menu['matchrule']['group_id'] : -1,
					'client_platform_type' => intval($menu['matchrule']['client_platform_type']),
					'area' => trim($menus['matchrule']['country']) . trim($menu['matchrule']['province']) . trim($menu['matchrule']['city']),
					'data' => base64_encode(iserializer($menu)),
					'status' => STATUS_ON,
					'createtime' => TIMESTAMP,
				);

				if ($post['type'] == MENU_CURRENTSELF) {
					if (!empty($id)) {
						pdo_update('uni_account_menus', $insert, array('uniacid' => $_W['uniacid'], 'type' => MENU_CURRENTSELF, 'id' => $id));
					} else {
						pdo_insert('uni_account_menus', $insert);
					}
					iajax(0, '创建菜单成功', weburl('platform/menu'));
				} elseif ($post['type'] == MENU_CONDITIONAL) {
					if ($post['status'] == STATUS_OFF && $post['id'] > 0) {
						pdo_update('uni_account_menus', $insert, array('uniacid' => $_W['uniacid'], 'type' => MENU_CONDITIONAL, 'id' => $post['id']));
					} else {
						pdo_insert('uni_account_menus', $insert);
					}
					iajax(0, '创建菜单成功', weburl('platform/menu', array('type' => MENU_CONDITIONAL)));
				}
			}
		}
		
		include($this->template());
	}

}
?>