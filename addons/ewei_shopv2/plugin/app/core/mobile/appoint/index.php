<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php";
class Index_EweiShopV2Page extends AppMobilePage
{
    public $dateList = [];
    public function __construct(){
        parent::__construct();
        $this->dateList = [
            '7:00-8:00'=>['time_slot'=>'7:00-8:00','starttime'=>strtotime(date('Y-m-d 7:00')),'endtime'=>strtotime(date('Y-m-d 7:00'))],
            '8:00-9:00'=>['time_slot'=>'8:00-9:00','starttime'=>strtotime(date('Y-m-d 8:00')),'endtime'=>strtotime(date('Y-m-d 9:00'))],
            '9:00-10:00'=>['time_slot'=>'9:00-10:00','starttime'=>strtotime(date('Y-m-d 9:00')),'endtime'=>strtotime(date('Y-m-d 10:00'))],
            '10:00-11:00'=>['time_slot'=>'10:00-11:00','starttime'=>strtotime(date('Y-m-d 10:00')),'endtime'=>strtotime(date('Y-m-d 11:00'))],
            '11:00-12:00'=>['time_slot'=>'11:00-12:00','starttime'=>strtotime(date('Y-m-d 11:00')),'endtime'=>strtotime(date('Y-m-d 12:00'))],
            '14:00-15:00'=>['time_slot'=>'14:00-15:00','starttime'=>strtotime(date('Y-m-d 14:00')),'endtime'=>strtotime(date('Y-m-d 15:00'))],
            '15:00-16:00'=>['time_slot'=>'15:00-16:00','starttime'=>strtotime(date('Y-m-d 15:00')),'endtime'=>strtotime(date('Y-m-d 16:00'))],
            '16:00-17:00'=>['time_slot'=>'16:00-17:00','starttime'=>strtotime(date('Y-m-d 16:00')),'endtime'=>strtotime(date('Y-m-d 17:00'))],
            '17:00-17:30'=>['time_slot'=>'17:00-17:30','starttime'=>strtotime(date('Y-m-d 17:00')),'endtime'=>strtotime(date('Y-m-d 17:30'))],
            '18:00-19:00'=>['time_slot'=>'18:00-19:00','starttime'=>strtotime(date('Y-m-d 18:00')),'endtime'=>strtotime(date('Y-m-d 19:00'))],
            '19:00-20:00'=>['time_slot'=>'19:00-20:00','starttime'=>strtotime(date('Y-m-d 19:00')),'endtime'=>strtotime(date('Y-m-d 20:00'))],
        ];
    }

    public function get_date()
    {
        global $_GPC;
        global $_W;
        $list = $this->dateList;
        return app_json(['list'=>$list]);
    }

    public function submit(){
        global $_GPC,$_W;
        $dateList = $this->dateList;
        if(empty($_GPC['time_slot'])) return app_error(AppError::$ParamsError,'参数错误');
        if(empty($_GPC['doctorid'])) return app_error(AppError::$ParamsError,'参数错误');
        if(empty($dateList[$_GPC['time_slot']])) return app_error(AppError::$ParamsError,'参数错误');
        if(time() > $dateList[$_GPC['time_slot']]['starttime']) return app_error(AppError::$ParamsError,'已超过当前可预约时间');
        //提交订单
        $ordersn = m('appoint')->createNO('ewei_appoint_order', 'ordersn', 'YY');
        $price = pdo_getcolumn('ewei_doctor',['id'=>$_GPC['doctorid'],'is_delete'=>0,'status'=>1],'price');
        if(empty($price) && ($price!==0 || $price!==0.00)) return app_error(AppError::$ParamsError,'未找到你要预约的医生');
        $time_slot = pdo_getcolumn('ewei_appoint_order',['time_slot'=>$dateList[$_GPC['time_slot']]['time_slot'],'date_slot'=>date('Y-m-d')],'time_slot');
        //if(!empty($time_slot)) return app_error(AppError::$ParamsError,"您已预约 ".date('Y-m-d')." {$dateList[$_GPC['time_slot']]['time_slot']}");
        $insertData = [
            'ordersn'=>$ordersn,
            'openid'=>$_W['openid'],
            'price'=>$price,
            'createtime'=>time(),
            'time_slot'=>$dateList[$_GPC['time_slot']]['time_slot'],
            'date_slot'=>date('Y-m-d'),
            'doctorid'=>$_GPC['doctorid'],
        ];
        pdo_insert('ewei_appoint_order',$insertData);
        $orderid = pdo_insertid();
        if(!$orderid) return app_error(AppError::$ParamsError,'预约失败,请稍后重试');
        return app_json(['orderid'=>$orderid]);
    }

}

?>