<?php  
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Material_EweiShopV2Page extends WebPage 
{

	public function main() 
	{
		global $_W;
		global $_GPC;
		global $setting_keyword;
	    load()->model('material');
		load()->model('mc');
		load()->model('account');
		load()->model('attachment');
		load()->func('file');
		$active_sub_permission=array(

				'news'=>array(
					'title'=>'图文',
					'url'=>webUrl('platform.material',array('type'=>'news')),
					'permission_name'=>'news',
					'active'=>'news',
				),		
				'image'=>array(
					'title'=>'图片',
					'url'=>webUrl('platform.material',array('type'=>'image')),
					'permission_name'=>'image',
					'active'=>'image',
				),
				'voice'=>array(
					'title'=>'语音',
					'url'=>webUrl('platform.material',array('type'=>'voice')),
					'permission_name'=>'voice',
					'active'=>'voice',
				),	'video'=>array(
					'title'=>'语音',
					'url'=>webUrl('platform.material',array('type'=>'video')),
					'permission_name'=>'video',
					'active'=>'video',
				),
		 

		);


		$do=$_GPC['dos'];
		$dos = array('display', 'sync', 'delete', 'send');
		$do = in_array($do, $dos) ? $do : 'display';
		 
		 
		 if ($do == 'send') {
	$group = intval($_GPC['group']);
	$type = trim($_GPC['type']);
	$id = intval($_GPC['id']);
	$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($media)) {
		iajax(1, '素材不存在', '');
	}
	$group = $group > 0 ? $group : -1;
	$account_api = WeAccount::createByUniacid();
	$result = $account_api->fansSendAll($group, $type, $media['media_id']);
	if (is_error($result)) {
		iajax(1, $result['message'], '');
	}
	$groups = pdo_get('mc_fans_groups', array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid']));
	if (!empty($groups)) {
		$groups = iunserializer($groups['groups']);
	}
	if ($group == -1) {
		$groups = array(
				$group => array(
						'name' => '全部粉丝',
						'count' => 0
				)
		);
	}
	$record = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'groupname' => $groups[$group]['name'],
		'fansnum' => $groups[$group]['count'],
		'msgtype' => $type,
		'group' => $group,
		'attach_id' => $id,
		'media_id' => $media['media_id'],
		'status' => 0,
		'type' => 0,
		'sendtime' => TIMESTAMP,
		'createtime' => TIMESTAMP,
	);
	pdo_insert('mc_mass_record', $record);
	iajax(0, '发送成功！', '');
}

if ($do == 'display') {
	$type = trim($_GPC['type']);
	$type = in_array($type, array('news', 'image', 'voice', 'video')) ? $type : 'news';
	permission_check_account_user('platform_material_' . $type);
	$server = in_array(trim($_GPC['server']), array(MATERIAL_LOCAL, MATERIAL_WEXIN)) ? trim($_GPC['server']) : '';
	$group = mc_fans_groups(true);
	$page_index = max(1, intval($_GPC['page']));
	$page_size = 24;
	$search = addslashes($_GPC['title']);

	if ($type == 'news') {
		$material_news_list = material_news_list($server, $search, array('page_index' => $page_index, 'page_size' => $page_size));
	} else {
		if (empty($server)) {
			$server = MATERIAL_WEXIN;
		}
		$material_news_list = material_list($type, $server, array('page_index' => $page_index, 'page_size' => $page_size));
	}
	$material_list = $material_news_list['material_list'];
	$pager = $material_news_list['page'];
}

if ($do == 'delete') {
	if(isset($_GPC['uniacid'])) { 		$requniacid = intval($_GPC['uniacid']);
		attachment_reset_uniacid($requniacid);
	}

	$material_id = intval($_GPC['material_id']);
	$server = $_GPC['server'] == 'local' ? 'local' : 'wechat';
	$type = trim($_GPC['type']);
	$cron_record = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'attach_id' => $material_id, 'sendtime >=' => TIMESTAMP), array('id'));
	if (!empty($cron_record)) {
		iajax('-1', '有群发消息未发送，不可删除');
	}
	if ($type == 'news'){
		$result = material_news_delete($material_id);
	} else {
				$result = material_delete($material_id, $server);
	}
	if (is_error($result)){
		iajax('-1', $result['message']);
	}
	iajax('0', '删除素材成功');
}

	if ($do == 'sync') {
		
		$account_api = WeAccount::createByUniacid();
		$pageindex = max(1, $_GPC['pageindex']);
		$type = empty($_GPC['type']) ? 'news' : $_GPC['type'];
		$news_list = $account_api->batchGetMaterial($type, ($pageindex - 1) * 20);
		$wechat_existid = empty($_GPC['wechat_existid']) ? array() : $_GPC['wechat_existid'];
		if ($pageindex == 1) {
			$original_newsid = pdo_getall('wechat_attachment', array('uniacid' => $_W['uniacid'], 'type' => $type, 'model' => 'perm'), array('id'), 'id');
			$original_newsid = array_keys($original_newsid);
			$wechat_existid = material_sync($news_list['item'], array(), $type);
			if ($news_list['total_count'] > 20) {
				$total = ceil($news_list['total_count']/20);
				iajax('1', array('type' => $type,'total' => $total, 'pageindex' => $pageindex+1, 'wechat_existid' => $wechat_existid, 'original_newsid' => $original_newsid), '');
			}
		} else {
			$wechat_existid = material_sync($news_list['item'], $wechat_existid, $type);
			$total = intval($_GPC['total']);
			$original_newsid = $_GPC['original_newsid'];
			if ($total != $pageindex) {
				iajax('1', array('type' => $type, 'total' => $total, 'pageindex' => $pageindex+1, 'wechat_existid' => $wechat_existid, 'original_newsid' => $original_newsid), '');
			}
			if (empty($original_newsid)) {
				$original_newsid = array();
			}
			$original_newsid = array_filter($original_newsid, function($item){
				return is_numeric($item);
			});
		}
		
		$delete_id = array_diff($original_newsid, $wechat_existid);
		if (!empty($delete_id) && is_array($delete_id)) {
				foreach ($delete_id as $id) {
					pdo_delete('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
					pdo_delete('wechat_news', array('uniacid' => $_W['uniacid'], 'attach_id' => $id));
				}
			}
			iajax(0, '更新成功！', webUrl('platform.material'));
		}

		include($this->template());
	}
	
	
	public function display() {
		header("location:" . webUrl("platform.material"));
			exit();
		
	}
	public function post() {
		global $_W;
		global $_GPC;
		
		
		load()->func('file');
load()->model('material');
load()->model('account');
$do=$_GPC['dos'];
$dos = array('news', 'tomedia', 'addnews', 'upload_material', 'upload_news');
$do = in_array($do, $dos) ? $do : 'news';

permission_check_account_user('platform_material');

if ($do == 'tomedia') {
	iajax('0', tomedia($_GPC['url']), '');
}

if ($do == 'news') {
	$type = trim($_GPC['type']);
	$newsid = intval($_GPC['newsid']);
	$upload_limit = material_upload_limit();
	if (empty($newsid)) {
		if ($type == 'reply') {
			$reply_news_id = intval($_GPC['reply_news_id']);
			$news = pdo_get('news_reply', array(
				'id' => $reply_news_id 
			));
			$news_list = pdo_getall('news_reply', array(
				'parent_id' => $news['id'] 
			), array(), '', ' displayorder ASC');
			$news_list = array_merge(array(
				$news 
			), $news_list);
			if (!empty($news_list)) {
				foreach ($news_list as $key => &$row_news) {
					$row_news = array(
						'uniacid' => $_W['uniacid'],
						'thumb_url' => $row_news['thumb'],
						'title' => $row_news['title'],
						'author' => $row_news['author'],
						'digest' => $row_news['description'],
						'content' => $row_news['content'],
						'url' => $row_news['url'],
						'displayorder' => $key,
						'show_cover_pic' => intval($row_news['incontent']),
						'content_source_url' => $row_news['content_source_url']
					);
				}
				unset($row_news);
			}
		}
	} else {
		$attachment = material_get($newsid);
		if (is_error($attachment)){
			itoast('图文素材不存在，或已删除', url('platform/material'), 'warning');
		}
		$news_list = $attachment['news'];
	}
	if (!empty($_GPC['new_type'])) {
		$new_type = trim($_GPC['new_type']);
		if (!in_array($new_type, array('reply', 'link'))) {
			$new_type = 'reply';
		}
	}
	if (!empty($news_list)) {
		foreach ($news_list as $key => $row_news) {
			if (empty($row_news['author']) && empty($row_news['content'])) {
				$new_type = 'link';
			} else {
				$new_type = 'reply';
			}
		}
	}
	include($this->template('platform/material/post'));
	exit;
//	template('platform/material-post');
}

if ($do == 'addnews') {
	$is_sendto_wechat = trim($_GPC['target']) == 'wechat' ? true : false;
	$attach_id = intval($_GPC['attach_id']);
	if (empty($_GPC['news'])) {
		iajax(- 1, '提交内容参数有误');
	}
	$attach_id = material_news_set($_GPC['news'], $attach_id);
	if (is_error($attach_id)) {
		iajax(-1, $attach_id['message']);
	}
	if (!empty($_GPC['news_rid'])) {
		pdo_update('news_reply', array('media_id' => $attach_id), array('id' => intval($_GPC['news_rid'])));
	}
	if ($is_sendto_wechat) {
		$result = material_local_news_upload($attach_id);
	}
	if (is_error($result)){
		iajax(-1, '提交微信素材失败');
	}else{
		iajax(0, '编辑图文素材成功');
	}
}

if ($do == 'upload_material') {
	$material_id = intval($_GPC['material_id']);
	$result = material_local_upload($material_id);
	if (is_error($result)) {
		iajax(1, $result['message']);
	}
	iajax(0, json_encode($result));
}

if ($do == 'upload_news') {
	$material_id = intval($_GPC['material_id']);
	$result = material_local_news_upload($material_id);
	if (is_error($result)){
		iajax(-1, $result['message']);
	} else {
		iajax(0, '转换成功');
	}
}
 
		include($this->template());
	}

}
?>