<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Order_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and o.uniacid=:uniacid and o.merchid=:merchid and o.status>=1';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime']['start']) && !empty($_GPC['datetime']['end'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$_GPC['keyword'] = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($_GPC['keyword'])) {
			if ($searchfield == 'ordersn') {
				$condition .= ' and o.ordersn like :keyword';
			}
			else if ($searchfield == 'member') {
				$condition .= ' and ( m.realname like :keyword or m.mobile like :keyword)';
			}
			else {
				if ($searchfield == 'address') {
					$condition .= ' and a.realname like :keyword';
				}
			}

			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$condition .= ' and o.deleted = 0 group by o.id';
		$sql = 'select o.*, a.realname as addressname,m.realname from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = o.addressid ' . (' where 1 ' . $condition . ' ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['ordersn'] = $row['ordersn'] . ' ';
			$row['goods'] = pdo_fetchall('SELECT g.thumb,og.price,og.total,og.realprice,g.title,og.optionname from ' . tablename('ewei_shop_order_goods') . ' og' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid  ' . ' where og.uniacid = :uniacid and og.orderid=:orderid order by og.createtime  desc ', array(':uniacid' => $_W['uniacid'], ':orderid' => $row['id']));
			$totalmoney += $row['price'];
		}

		unset($row);
		$condition = rtrim($condition, 'group by o.id');
		$count = pdo_fetch('select count(o.id) as count from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = o.addressid ' . (' where 1 ' . $condition), $params);
		$totalcount = $total = $count['count'];
		$pager = pagination2($total, $pindex, $psize);

		if ($_GPC['export'] == 1) {
			mca('statistics.order.export');
			$list[] = array('data' => '????????????', 'count' => $totalcount);
			$list[] = array('data' => '????????????', 'count' => $totalmoney);

			foreach ($list as &$row) {
				if ($row['paytype'] == 1) {
					$row['paytype'] = '????????????';
				}
				else if ($row['paytype'] == 11) {
					$row['paytype'] = '????????????';
				}
				else if ($row['paytype'] == 21) {
					$row['paytype'] = '????????????';
				}
				else if ($row['paytype'] == 22) {
					$row['paytype'] = '???????????????';
				}
				else if ($row['paytype'] == 23) {
					$row['paytype'] = '????????????';
				}
				else {
					if ($row['paytype'] == 3) {
						$row['paytype'] = '????????????';
					}
				}

				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
			m('excel')->export($list, array(
				'title'   => '????????????-' . date('Y-m-d-H-i', time()),
				'columns' => array(
					array('title' => '?????????', 'field' => 'ordersn', 'width' => 24),
					array('title' => '?????????', 'field' => 'price', 'width' => 12),
					array('title' => '????????????', 'field' => 'goodsprice', 'width' => 12),
					array('title' => '??????', 'field' => 'dispatchprice', 'width' => 12),
					array('title' => '????????????', 'field' => 'paytype', 'width' => 12),
					array('title' => '?????????', 'field' => 'realname', 'width' => 12),
					array('title' => '?????????', 'field' => 'addressname', 'width' => 12),
					array('title' => '????????????', 'field' => 'createtime', 'width' => 24)
				)
			));
			mplog('statistics.order.export', '??????????????????');
		}

		load()->func('tpl');
		include $this->template();
	}
}

?>
