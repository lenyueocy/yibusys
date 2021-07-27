<?php  
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Menu_EweiShopV2Page extends WebPage 
{

	public function main() 
	{
		global $_W;
		global $_GPC;
		global $setting_keyword;
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
		load()->model('mc');
		load()->model('menu');
		load()->model('material');
		$do=$_GPC['dos'];
		$dos = array('display', 'delete', 'refresh', 'post', 'push', 'copy', 'current_menu');
		$do = in_array($do, $dos) ? $do : 'display';

		if($_W['isajax']) {
			if(!empty($_GPC['method'])) {
				$do = $_GPC['method'];
			}
		}
		 
	if($do == 'display') {
		permission_check_account_user('platform_menu_conditional');
		set_time_limit(0);

		$type = !empty($_GPC['type']) ? intval($_GPC['type']) : MENU_CURRENTSELF;
		if ($type == MENU_CONDITIONAL) {
			$update_conditional_menu = menu_update_conditional();
			if(is_error($update_conditional_menu)) {
				itoast($update_conditional_menu['message'], '', 'error');
			}
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$condition = " WHERE uniacid = :uniacid";
		$params[':uniacid'] = $_W['uniacid'];
		if (isset($_GPC['keyword'])) {
			$condition .= " AND title LIKE :keyword";
			$params[':keyword'] = "%{$_GPC['keyword']}%";
		}
		if (!empty($type)) {
			$condition .= " AND type = :type";
			$params[':type'] = $type;
		}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('uni_account_menus') . $condition, $params);
		$data = pdo_fetchall("SELECT * FROM " . tablename('uni_account_menus') . $condition . " ORDER BY type ASC, status DESC,id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
		$pager = pagination($total, $pindex, $psize);
		if ($type == MENU_CONDITIONAL) {
			$names = array(
				'sex' => array('不限', '男', '女'),
				'client_platform_type' => array('不限', '苹果', '安卓', '其他')
			);
			$groups = mc_fans_groups(true);
		}
		//template('platform/menu');
	}


 
		include($this->template());
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