<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage 
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (empty($_W['shopversion'])) {
			header('location:' . webUrl('shop'));
			exit();
		}

		$shop_data = m('common')->getSysset('shop');
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$hascommission = false;

		if (p('commission')) {
			$hascommission = 0 < intval($_W['shopset']['commission']['level']);
		}

		$ordercol = 6;
		if (cv('goods') && cv('order')) {
			$ordercol = 6;
		}
		else {
			if (cv('goods') && !cv('order')) {
				$ordercol = 12;
			}
			else {
				if (cv('order') && !cv('goods')) {
					$ordercol = 12;
				}
				else {
					$ordercol = 0;
				}
			}
		}

		$pluginnum = m('plugin')->getCount();
		$no_left = true;
		include $this->template();
	}

	public function searchlist()
	{
		global $_W;
		global $_GPC;
		$return_arr = array();
		$menu = m('system')->getSubMenus(true, true);
		$keyword = trim($_GPC['keyword']);
		if (empty($keyword) || empty($menu)) {
			show_json(1, array('menu' => $return_arr));
		}

		foreach ($menu as $index => $item) {
			if (strexists($item['title'], $keyword) || strexists($item['desc'], $keyword) || strexists($item['keywords'], $keyword) || strexists($item['topsubtitle'], $keyword)) {
				if (cv($item['route'])) {
					$return_arr[] = $item;
				}
			}
		}

		show_json(1, array('menu' => $return_arr));
	}

	public function search()
	{
		global $_W;
		global $_GPC;
		$keyword = trim($_GPC['keyword']);
		$list = array();
		$history = $_GPC['history_search'];

		if (empty($history)) {
			$history = array();
		}
		else {
			$history = htmlspecialchars_decode($history);
			$history = json_decode($history, true);
		}

		if (!empty($keyword)) {
			$submenu = m('system')->getSubMenus(true, true);

			if (!empty($submenu)) {
				foreach ($submenu as $index => $submenu_item) {
					$top = $submenu_item['top'];
					if (strexists($submenu_item['title'], $keyword) || strexists($submenu_item['desc'], $keyword) || strexists($submenu_item['keywords'], $keyword) || strexists($submenu_item['topsubtitle'], $keyword)) {
						if (cv($submenu_item['route'])) {
							if (!is_array($list[$top])) {
								$title = !empty($submenu_item['topsubtitle']) ? $submenu_item['topsubtitle'] : $submenu_item['title'];

								if (strexists($title, $keyword)) {
									$title = str_replace($keyword, '<b>' . $keyword . '</b>', $title);
								}

								$list[$top] = array(
									'title' => $title,
									'items' => array()
								);
							}

							if (strexists($submenu_item['title'], $keyword)) {
								$submenu_item['title'] = str_replace($keyword, '<b>' . $keyword . '</b>', $submenu_item['title']);
							}

							if (strexists($submenu_item['desc'], $keyword)) {
								$submenu_item['desc'] = str_replace($keyword, '<b>' . $keyword . '</b>', $submenu_item['desc']);
							}

							$list[$top]['items'][] = $submenu_item;
						}
					}
				}
			}

			array_walk($list['shop']['items'], function(&$v) {
				if ($v['url'] == 'http://slf.clubmall.cn/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=shop.diypage') {
					$v['url'] = 'http://slf.clubmall.cn/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=diypage';
				}
			});

			if (empty($history)) {
				$history_new = array($keyword);
			}
			else {
				$history_new = $history;

				foreach ($history_new as $index => $key) {
					if ($key == $keyword) {
						unset($history_new[$index]);
					}
				}

				$history_new = array_merge(array($keyword), $history_new);
				$history_new = array_slice($history_new, 0, 20);
			}

			isetcookie('history_search', json_encode($history_new), 7 * 86400);
			$history = $history_new;
		}

		include $this->template();
	}

	public function clearhistory()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$type = intval($_GPC['type']);

			if (empty($type)) {
				isetcookie('history_url', '', -7 * 86400);
			}
			else {
				isetcookie('history_search', '', -7 * 86400);
			}
		}

		show_json(1);
	}

	public function switchversion()
	{
		global $_W;
		global $_GPC;
		$route = trim($_GPC['route']);
		$id = intval($_GPC['id']);
		$set = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_version') . ' WHERE uid=:uid AND `type`=0', array(':uid' => $_W['uid']));
		$data = array('version' => !empty($_W['shopversion']) ? 0 : 1);

		if (empty($set)) {
			$data['uid'] = $_W['uid'];
			pdo_insert('ewei_shop_version', $data);
		}
		else {
			pdo_update('ewei_shop_version', $data, array('id' => $set['id']));
		}

		$params = array();

		if (!empty($id)) {
			$params['id'] = $id;
		}

		load()->model('cache');
		cache_build_template();
		header('location: ' . webUrl($route, $params));
		exit();
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
	
}

?>
