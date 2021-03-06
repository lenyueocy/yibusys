<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('TM_CREDITSHOP_LOTTERY', 'TM_CREDITSHOP_LOTTERY');
define('TM_CREDITSHOP_EXCHANGE', 'TM_CREDITSHOP_EXCHANGE');
define('TM_CREDITSHOP_WIN', 'TM_CREDITSHOP_WIN');

if (!class_exists('CycelbuyModel')) {
	class CycelbuyModel extends PluginModel
	{
		public function cycelbuy_periodic($orderid)
		{
			global $_GPC;
			global $_W;
			$openid = $_W['openid'];
			$sql = 'SELECT id,ordersn,status,cycelbuy_periodic,cycelbuy_predict_time,iscycelbuy,addressid,dispatchprice,dispatchtype FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and iscycelbuy=1 and uniacid =:uniacid';
			$param = array(':id' => intval($orderid), ':uniacid' => intval($_W['uniacid']));
			$order = pdo_fetch($sql, $param);

			if ($order['status'] == 1) {
				$cycelbuy_periodic = explode(',', $order['cycelbuy_periodic']);
				$cycelbuy_day = $cycelbuy_periodic[0];
				$cycelbuy_unit = $cycelbuy_periodic[1];
				$cycelbuy_num = $cycelbuy_periodic[2];

				if ($cycelbuy_unit == 1) {
					$cycelbuy_day = $cycelbuy_day * 7;
				}
				else {
					if ($cycelbuy_unit == 2) {
						$cycelbuy_day = $cycelbuy_day * 30;
					}
				}

				$addressSql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id=:id and uniacid=:uniacid';
				$addressParam = array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']);
				$address = pdo_fetch($addressSql, $addressParam);
				$addressInfo = serialize($address);
				$data['orderid'] = $order['id'];
				$data['uniacid'] = $_W['uniacid'];
				$data['status'] = 0;
				$data['addressid'] = $order['addressid'];
				$data['address'] = $addressInfo;
				$data['dispatchprice'] = $order['dispatchprice'] / $cycelbuy_num;
				$data['createtime'] = time();
				$data['dispatchtype'] = $order['dispatchtype'];
				$i = 0;

				while ($i < $cycelbuy_num) {
					$data['cycelsn'] = $order['ordersn'] . '_' . ($i + 1);

					if ($i == 0) {
						$data['receipttime'] = $order['cycelbuy_predict_time'];
					}
					else {
						$data['receipttime'] = $order['cycelbuy_predict_time'] + 86400 * $i * $cycelbuy_day;
					}

					pdo_insert('ewei_shop_cycelbuy_periods', $data);
					++$i;
				}
			}
		}

		/**
         * ????????????
         * @param type $message_type
         * @param type $openid
         * @return type
         */
		public function sendMessage($openid = '', $data = array(), $message_type = '')
		{
			global $_W;
			global $_GPC;
			$set = $this->getSet();
			$tm = $set['tm'];
			$templateid = $tm['templateid'];
			$time = date('Y-m-d H:i', time());
			$member = m('member')->getMember($openid);
			$usernotice = unserialize($member['noticeset']);

			if (!is_array($usernotice)) {
				$usernotice = array();
			}

			if ($message_type == TM_CYCELBUY_SELLER_DATE) {
				if ($tm['cycelbuy_seller_date_close_advanced']) {
					return false;
				}

				if (empty($tm['openids'])) {
					return false;
				}

				$tag = 'cycelbuy_seller_date';
				$text = $data['nickname'] . '????????????????????????
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => $data['nickname'] . '?????????????????????', 'color' => '#ff0000'),
					'keyword1' => array('title' => '????????????', 'value' => '????????????', 'color' => '#000000'),
					'keyword2' => array('title' => '????????????', 'value' => $data['nickname'] . '?????????????????????', 'color' => '#000000'),
					'keyword3' => array('title' => '????????????', 'value' => '????????????????????????', 'color' => '#000000'),
					'keyword4' => array('title' => '????????????', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
??????????????????', 'color' => '#000000')
				);
				$datas[] = array('name' => '??????', 'value' => $data['nickname']);
				$datas[] = array('name' => '????????????', 'value' => $data['ordersn']);
				$datas[] = array('name' => '???????????????', 'value' => $data['goods']);
				$openids = explode(',', $tm['openids']);

				foreach ($openids as $openid) {
					m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
				}
			}
			else if ($message_type == TM_CYCELBUY_SELLER_ADDRESS) {
				if ($tm['cycelbuy_seller_address_close_advanced']) {
					return false;
				}

				if (empty($tm['openids'])) {
					return false;
				}

				$tag = 'cycelbuy_seller_address';
				$text = $data['nickname'] . '????????????????????????
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => $data['nickname'] . '????????????????????????', 'color' => '#ff0000'),
					'keyword1' => array('title' => '????????????', 'value' => '????????????', 'color' => '#000000'),
					'keyword2' => array('title' => '????????????', 'value' => $data['nickname'] . '?????????????????????', 'color' => '#000000'),
					'keyword3' => array('title' => '????????????', 'value' => '????????????????????????', 'color' => '#000000'),
					'keyword4' => array('title' => '????????????', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
??????????????????', 'color' => '#000000')
				);
				$datas[] = array('name' => '??????', 'value' => $data['nickname']);
				$datas[] = array('name' => '???????????????', 'value' => $data['newaddress']);
				$datas[] = array('name' => '??????', 'value' => date('Y-m-d H:i:s', $data['paytime']));
				$datas[] = array('name' => '????????????', 'value' => $data['ordersn']);
				$openids = implode(',', $tm['openids']);

				foreach ($openids as $openid) {
					m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
				}
			}
			else if ($message_type == TM_CYCELBUY_BUYER_DATE) {
				if ($tm['cycelbuy_buyer_date_close_advanced']) {
					return false;
				}

				$tag = 'cycelbuy_buyer_date';
				$text = '??????????????????????????????
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => '?????????' . $data['nickname'] . '???????????????????????????', 'color' => '#ff0000'),
					'keyword2' => array('title' => '????????????', 'value' => '????????????????????????', 'color' => '#000000'),
					'keyword3' => array('title' => '????????????', 'value' => '???????????????????????????', 'color' => '#000000'),
					'keyword1' => array('title' => '????????????', 'value' => '????????????', 'color' => '#000000'),
					'remark'   => array('value' => '
??????????????????', 'color' => '#000000')
				);
				$toopenid = $openid;
				$datas[] = array('name' => '??????', 'value' => $data['nickname']);
				$datas[] = array('name' => '???????????????', 'value' => $data['newdate']);
				$datas[] = array('name' => '??????', 'value' => $time);
				$datas[] = array('name' => '????????????', 'value' => $data['ordersn']);
				m('notice')->sendNotice(array('openid' => $toopenid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
			}
			else if ($message_type == TM_CYCELBUY_BUYER_ADDRESS) {
				if ($tm['cycelbuy_buyer_address_close_advanced']) {
					return false;
				}

				$tag = 'cycelbuy_buyer_address';
				$text = '??????????????????????????????
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => '?????????' . $member['nickname'] . '?????????????????????????????????', 'color' => '#ff0000'),
					'keyword1' => array('title' => '????????????', 'value' => '????????????', 'color' => '#000000'),
					'keyword2' => array('title' => '????????????', 'value' => '?????????????????????????????????', 'color' => '#000000'),
					'keyword3' => array('title' => '????????????', 'value' => '????????????????????????', 'color' => '#000000'),
					'keyword4' => array('title' => '????????????', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
??????????????????', 'color' => '#000000')
				);
				$toopenid = $openid;
				$datas[] = array('name' => '??????', 'value' => $member['nickname']);
				$datas[] = array('name' => '???????????????', 'value' => $data['newaddress']);
				$datas[] = array('name' => '??????', 'value' => $time);
				$datas[] = array('name' => '????????????', 'value' => $data['ordersn']);
				m('notice')->sendNotice(array('openid' => $toopenid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
			}
			else {
				if ($message_type == TM_CYCELBUY_SELLER_SEND) {
					if ($tm['cycelbuy_timing_close_advanced']) {
						return false;
					}

					$address = iunserializer($data['address']);
					$tag = 'cycelbuy_timing';
					$text = '?????????????????????????????????
????????????????????????

????????????
' . $data['ordersn'] . '
???????????????' . $data['price'] . '
---------------------
????????????' . $address['realname'] . '
???????????????:' . $address['mobile'] . '
????????????:' . $address['province'] . $address['city'] . $address['area'] . $address['address'] . '
??????:' . $data['num'] . ' 

?????????????????????';
					$message = array(
						'first'    => array('value' => '?????????????????????????????????????????????', 'color' => '#ff0000'),
						'keyword1' => array('title' => '????????????', 'value' => '????????????', 'color' => '#000000'),
						'keyword2' => array('title' => '????????????', 'value' => '??????????????????', 'color' => '#000000'),
						'keyword3' => array('title' => '????????????', 'value' => '??????????????????', 'color' => '#000000'),
						'keyword4' => array('title' => '????????????', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
						'remark'   => array('value' => '
??????????????????', 'color' => '#000000')
					);
					$datas[] = array('name' => '????????????', 'value' => $data['ordersn']);
					$datas[] = array('name' => '????????????', 'value' => $data['price']);
					$datas[] = array('name' => '?????????', 'value' => $address['realname']);
					$datas[] = array('name' => '???????????????', 'value' => $address['mobile']);
					$datas[] = array('name' => '????????????', 'value' => $address['province'] . $address['city'] . $address['area'] . $address['address']);
					$datas[] = array('name' => '??????', 'value' => $data['num']);
					$datas[] = array('name' => '??????', 'value' => $time);
					$openids = explode(',', $tm['openids']);

					foreach ($openids as $openid) {
						m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
					}
				}
			}
		}
	}
}

?>
