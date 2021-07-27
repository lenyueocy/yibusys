<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
class Appoint_EweiShopV2Model
{
	public function getGoods($id){
        $table_luckybag_goods = tablename('ewei_luckybag_goods');
        $table_shop_goods = tablename('ewei_shop_goods');
        $sql = "select g.*,lg.num from {$table_luckybag_goods} as lg left join {$table_shop_goods} as g on lg.goods_id=g.id where lg.luckybag_id={$id}";
        $data = pdo_fetchall($sql);
        $data = set_medias($data,'thumb');
        return $data?:[];
	}

	public function getGoodsPrice($id){
        $table_luckybag_goods = tablename('ewei_luckybag_goods');
        $table_shop_goods = tablename('ewei_shop_goods');
        $sql = "select g.*,lg.num from {$table_luckybag_goods} as lg left join {$table_shop_goods} as g on lg.goods_id=g.id where lg.luckybag_id={$id}";
        $data = pdo_fetchall($sql);
        $data = set_medias($data,'thumb');
        $countPrice = array_sum(array_column($data, 'marketprice'));
        return $countPrice?:0;
    }

    /**
     * 根据订单id获取福袋的平台价格
     * @author: leny
     * @date: 2020/11/27 16:51
     */
    public function getPlatformPrice($id){
        $sell_credit = $this->getSellCredit($id);
        $sell_integral = $this->getSellIntegral($id);
        $sell_wallet_integral = $this->getSellWalletIntegral($id);
        //$sell_income = round($sell_credit + $sell_integral + $sell_wallet_integral,2);
        $sell_income = $sell_credit + $sell_wallet_integral;
        $orderData = pdo_get('ewei_luckybag_order',['id'=>$id]);
        $charge_ratio = pdo_getcolumn('ewei_luckybag',['id'=>$orderData['luckybag_id']],'charge_ratio');
        $result = $sell_income + ($orderData['price'] * ($charge_ratio/100));
        return round($result,2);
    }
    /**
     * 根据订单号获取会员收益价格
     * @author: leny
     * @date: 2020/11/27 17:15
     */
    public function getProfitPrice($id){
        $sell_credit = $this->getSellCredit($id);
        $sell_integral = $this->getSellIntegral($id);
        $sell_wallet_integral = $this->getSellWalletIntegral($id);
        $result = $sell_credit + $sell_integral + $sell_wallet_integral;
        return round($result,2);
    }

    /**
     * 获取福袋总价值
     * @author: leny
     * @date: 2020/11/10 17:47
     */
    public function getSellPrice($id){
        $order = pdo_get('ewei_luckybag_order',['id'=>$id]);
        $qifuData = pdo_getall('ewei_luckybag_qifu',['orderid'=>$order['id']]);
        $qifuPriceRatio = array_sum(array_column($qifuData, 'price_ratio'));
        //$qifu_up_price = round($order['price'] * ($qifuPriceRatio/100),2);
        //$lucky_price = round(($order['price'] + $qifu_up_price) + $order['revalue'] - $order['devalue'],2);
        //$lucky_price = round($order['price'] + $order['qifu_value'] + $order['revalue'] - $order['devalue'],2);
        $lucky_price = round($order['price'],2);
        return $lucky_price;
    }

    /**
     * 获取福袋 卖出去的价值
     * @author: leny
     * @date: 2020/11/10 17:40
     */
    public function getSellCredit($id){
        $lucky_price = $this->getSellPrice($id);
        $luckybag_id = pdo_getcolumn('ewei_luckybag_order',['id'=>$id],'luckybag_id');
        $branch_ratio = pdo_getcolumn('ewei_luckybag',['id'=>$luckybag_id],'branch_ratio');
        $sell_price = round($lucky_price * ((100 - $branch_ratio)/100), 2);
        return $sell_price;
    }

    /**
     * 获取福袋 卖出的积分价值
     * @author: leny
     * @date: 2020/11/10 17:44
     */
    public function getSellCountIntegral($id){
        $order = pdo_get('ewei_luckybag_order',['id'=>$id]);
        $qifuData = pdo_getall('ewei_luckybag_qifu',['orderid'=>$order['id']]);
        $qifuIntegralRatio = array_sum(array_column($qifuData, 'integral_ratio'));
        $sell_price = $this->getSellCredit($id);
        $lucky_price = $this->getSellPrice($id);
        $qifu_up_integral = round(($lucky_price - $sell_price) * ($qifuIntegralRatio/100),2);
        $sell_count_integral = round(($lucky_price - $sell_price) + $qifu_up_integral,2);
        //$sell_integral = round($sell_count_integral*0.9,2);
        //$sell_wallet_integral = round($sell_count_integral - $sell_integral, 2);
        return $sell_count_integral;
    }
    public function getSellIntegral($id){
        $order = pdo_get('ewei_luckybag_order',['id'=>$id]);
        $sell_price = $this->getSellCredit($id);
        $lucky_price = $this->getSellPrice($id);
        $sell_integral = round($lucky_price - $sell_price,2);
        return $sell_integral;
    }
    public function getSellWalletIntegral($id){
        $order = pdo_get('ewei_luckybag_order',['id'=>$id]);
        //$qifuData = pdo_getall('ewei_luckybag_qifu',['orderid'=>$order['id']]);
        //$lucky_price = $this->getSellPrice($id);
        $sell_wallet_integral = round($order['revalue'] + $order['qifu_value'],2);
        return $sell_wallet_integral;
    }

    public function createNO($table, $field, $prefix){

        $billno = date('YmdHis') . random(6, true);

        while (1) {
            $count = pdo_fetchcolumn('select count(*) from ' . tablename($table) . (' where ' . $field . '=:billno limit 1'), array(':billno' => $billno));

            if ($count <= 0) {
                break;
            }

            $billno = date('YmdHis') . random(6, true);
        }

        return $prefix . $billno;

    }

    /**
     * 支付成功接口 支付成功则通知医生
     * @author: leny
     * @date: 2020/10/26 15:35
     */
    public function payResult($ordersn = '',$paytype = '') {
        global $_W;
        if(empty($ordersn) || empty($paytype)) return false;
        $order = pdo_get('ewei_appoint_order',['ordersn'=>$ordersn]);
        if (1 <= $order['status']) return true;
        if (1) {
            pdo_update('ewei_appoint_order', ['status'=>1,'paytype'=>$paytype,'paytime'=>time()],['id' => $order['id']]);
            return true;
        }
        return false;
    }
    public function payResult_bak($ordersn = '',$paytype = '') {
        global $_W;
        //$fee          = intval($params['fee']);
        //$data         = ['status' => $params['result'] == 'success' ? 1 : 0];
        //$ordersn_tid  = $params['tid'];
        //$ordersn      = rtrim($ordersn_tid, 'TR');
        if(empty($ordersn)) return false;
        if(empty($paytype)) return false;

        $order = pdo_get('ewei_luckybag_order',['ordersn'=>$ordersn]);

        if (1 <= $order['status']) return true;

        if (1) { //$params['from'] == 'return'
            $luckybagData = pdo_get('ewei_luckybag',['id'=>$order['luckybag_id']]);
            if($luckybagData['orderid']>0){
                //开始结算上一个用户所得到的数据 结算时去拿上一个用户的订单信息 订单金额加上 升值价格
                $prevOrder = pdo_get('ewei_luckybag_order',['id'=>$luckybagData['orderid'],'uniacid'=>$_W['uniacid']]);
                // 50% 进入余额
                $credit2 = $this->getSellCredit($prevOrder['id']);//round($prevOrder['price']*0.5, 2)
                // 剩下 50% 进入积分账户
                $integralSum = $this->getSellIntegral($prevOrder['id']);
                $credit3 = round($integralSum * 0.1,2);
                $credit1 = round($integralSum - $credit3,2);

                //$prewPrice = round($prevOrder['price'] + $prevOrder['revalue'] - $prevOrder['devalue'] , 2);
                //$credit3 = round($prewPrice * 0.1,2);
                //$credit1 = $prewPrice - $credit3;
                // 50% 进入余额 剩下50% 10%进入积分钱包 90%进入积分账户
                $prevMember = m('member')->getMember($luckybagData['openid']);
                //进入积分钱包
                $result = m('member')->setCredit($luckybagData['openid'], 'credit3',$credit3, array($prevMember['uid'], "福袋卖出 积分钱包获得{$credit3}积分" ));
                if (is_error($result)) return app_error(AppError::$ParamsError, $result['message']);
                //剩下的进入积分账户
                $result = m('member')->setCredit($luckybagData['openid'], 'credit1',$credit1, array($prevMember['uid'], "福袋卖出 积分账户获得{$credit1}积分" ));
                if (is_error($result)) return app_error(AppError::$ParamsError, $result['message']);
                //50% 进入账户余额
                $result = m('member')->setCredit($luckybagData['openid'], 'credit2',$credit2, array($prevMember['uid'], "福袋卖出 余额增加{$credit2}元" ));
                if (is_error($result)) return app_error(AppError::$ParamsError, $result['message']);

                //修改上一个用户的卖出数据
                pdo_update('ewei_luckybag_order',['status'=>4,'selltime'=>time(),'sell_openid'=>$order['openid'],'profit'=>$credit2+$integralSum],['id'=>$prevOrder['id']]);
            }

            $change_data = ['status'=>1,'paytime'=>time()];
            if(!empty($paytype)) $change_data['paytype'] = $paytype;
            pdo_update('ewei_luckybag_order', $change_data,['id' => $order['id']]);

            pdo_update('ewei_luckybag', ['status'=>1,'openid'=>$_W['openid'],'orderid'=>$order['id']],['id' => $order['luckybag_id']]);

            return true;
        }
        return false;
    }
}


?>
