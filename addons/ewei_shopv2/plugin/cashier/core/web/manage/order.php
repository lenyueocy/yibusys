<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Order_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->set;
		$payday = (double) $set['payday'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'AND cashierid=:cashierid';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);
		if (isset($_GPC['status']) && $_GPC['status'] !== '') {
			$condition .= ' AND status=:status';
			$params[':status'] = intval($_GPC['status']);
		}

		if (isset($_GPC['operatorid']) && $_GPC['operatorid'] !== '') {
			$condition .= ' AND operatorid=:operatorid';
			$params[':operatorid'] = intval($_GPC['operatorid']);
		}

		if (isset($_GPC['paytype']) && $_GPC['paytype'] !== '') {
			$condition .= ' AND paytype=:paytype';
			$params[':paytype'] = intval($_GPC['paytype']);
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$start = strtotime($_GPC['time']['start']);
			$end = strtotime($_GPC['time']['end']);
			$condition .= ' AND createtime BETWEEN :start AND :end';
			$params[':start'] = intval($start);
			$params[':end'] = intval($end);
		}

		$goods = pdo_fetchall('SELECT id,orderid,isgoods FROM ' . tablename('ewei_shop_cashier_pay_log') . ' WHERE uniacid=:uniacid AND cashierid=:cashierid AND status=0 AND createtime < ' . (time() - 3600 * 24), array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');
		$gids = array();
		$selfgids = array();

		foreach ($goods as $v) {
			if (!empty($v['orderid'])) {
				$gids[] = $v['orderid'];
			}

			if (!empty($v['isgoods'])) {
				$selfgids[] = $v['id'];
			}
		}

		if (!empty($selfgids)) {
		}

		if (!empty($gids)) {
		}

		if (!empty($goods)) {
		}

		$sql = 'select * from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . ' ORDER BY id desc');

		if (empty($_GPC['export'])) {
			$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}
		else {
			$sql .= ' LIMIT 0,1000';
		}

		$list = pdo_fetchall($sql, $params);
		$operator = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_cashier_operator') . ' WHERE uniacid=:uniacid AND cashierid=:cashierid ORDER BY id DESC', array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');

		if ($_GPC['export'] == 1) {
			set_time_limit(0);
			$columns = array(
				array('title' => '??????', 'field' => 'status', 'width' => 12),
				array('title' => '?????????', 'field' => 'logno', 'width' => 24),
				array('title' => '????????????', 'field' => 'createtime', 'width' => 24),
				array('title' => '?????????', 'field' => 'operator', 'width' => 12),
				array('title' => '????????????', 'field' => 'paytype', 'width' => 12),
				array('title' => '??????', 'field' => 'money', 'width' => 12),
				array('title' => '????????????', 'field' => 'goodsprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'orderprice', 'width' => 12),
				array('title' => '?????????', 'field' => 'randommoney', 'width' => 12),
				array('title' => '?????????', 'field' => 'enough', 'width' => 12),
				array('title' => '????????????', 'field' => 'deduction', 'width' => 12),
				array('title' => '????????????', 'field' => 'discountmoney', 'width' => 12),
				array('title' => '???????????????', 'field' => 'usecouponprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'present_credit1', 'width' => 12)
			);

			foreach ($list as $k => &$v) {
				if ($v['status'] == '1') {
					$v['status'] = '?????????';
				}
				else if ($v['status'] == '-1') {
					$v['status'] = '?????????';
				}
				else {
					$v['status'] = '?????????';
				}

				$v['createtime'] = date('Y-m-d H:i', $v['createtime']);

				if (empty($v['operatorid'])) {
					$v['operator'] = '?????????';
				}
				else {
					$v['operator'] = isset($operator[$v['operatorid']]) ? $operator[$v['operatorid']]['title'] : '';
				}

				$v['paytype'] = CashierModel::$paytype[$v['paytype']];
				$v['money'] = $v['money'] + $v['deduction'];
			}

			unset($v);
			m('excel')->export($list, array('title' => '?????????????????????', 'columns' => $columns));
		}

		$total = (int) pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		$total_money = (double) pdo_fetchcolumn('select sum(money+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function refund($tid = 0, $fee = 0, $reason = '')
	{
		global $_W;
		global $_GPC;
		$res = $this->model->refund($_GPC['id']);

		if (is_error($res)) {
			show_json(0, $res['message']);
		}

		show_json(1);
	}
	public function change()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        $uniacid = $_W["uniacid"];
        $cashierid = $_W["cashierid"];
        $canshu = array(":id" => $id, ":uniacid" => $uniacid, ":cashierid" => $cashierid);
        $sql = " SELECT g.*,og.total,o.ispackage,og.price as orderprice,og.goodssn,og.productsn,og.realprice,o.goodsprice,o.price,o.olddispatchprice,og.optionname,l.status as state FROM " . tablename("ewei_shop_cashier_pay_log") . " l" . " left join " . tablename("ewei_shop_order") . " o on o.id = l.orderid " . " left join " . tablename("ewei_shop_order_goods") . " og on og.orderid = o.id " . " left join " . tablename("ewei_shop_goods") . " g on g.id = og.goodsid " . " WHERE l.id=:id AND l.uniacid=:uniacid AND l.cashierid=:cashierid  AND l.orderid !=''";
        $list = pdo_fetchall($sql, $canshu);
        $sql2 = " SELECT g.image as thumb,g.title,r.total,g.price as marketprice,g.goodssn,r.price as orderprice,r.price as realprice,l.status as state FROM " . tablename("ewei_shop_cashier_goods") . " g" . " left join " . tablename("ewei_shop_cashier_pay_log_goods") . " r on r.goodsid = g.id " . " left join " . tablename("ewei_shop_cashier_pay_log") . " l on l.id = r.logid " . " WHERE l.id=:id AND l.uniacid=:uniacid AND l.cashierid=:cashierid ";
        $list2 = pdo_fetchall($sql2, $canshu);
        if (!empty($list2)) {
            $list = array_merge($list, $list2);
        }
        $allprice = 0;
        $olddispatchprice = 0;
        foreach ($list as $kk => $vv) {
            $olddispatchprice += $vv["dispatchprice"];
            $allprice += $vv["realprice"];
        }
        include $this->template();
    }
}

?>
