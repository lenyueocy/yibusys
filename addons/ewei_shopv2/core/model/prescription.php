<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
class Prescription_EweiShopV2Model
{
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
