<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Index_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_W, $_GPC;
        $sql1 = 'select * from '.tablename('jsr_subject').' order by rand() limit 5 ';
        $list = pdo_fetchall($sql1);
        $list = json_encode($list);
        $e=mt_rand(1000,9999);
        $yz=md5('123cesd'.time().$e);
        $time=time().$e;

        $sql2 = 'select name,message,create_time from ' . tablename('jsr_message_board') .
            ' where uniacid=:uniacid and enabled = 1 order by sort desc ,id desc ';
        if($_GPC['ces']){
            $sql2 = 'select name,message,create_time from ' . tablename('jsr_message_board') .
                ' where uniacid=:uniacid and enabled = 1 order by sort desc ,id desc limit 100';
        }
        $msglist = pdo_fetchall($sql2,[':uniacid'=>$_W['uniacid']]);
        foreach ($msglist as $key => $value) {
            $msglist[$key]['create_time'] = date("Y-m-d H:i", $value['create_time']);
        }
        $msglist = json_encode($msglist);

        $sql3 = 'select sm.avatar,sm.nickname,ar.name,ar.id from ' . tablename('jsr_award_record') . " as ar " .
            ' left join ' . tablename('ewei_shop_member') . ' as sm on ar.openid=sm.openid order by type ,id desc';
        $hasawardlist = pdo_fetchall($sql3);


        // $hasawardlist = json_encode($msglist);


        // if (time() < 1584547225) {
            $sql = ' update ' . tablename('jsr_award') . " set click_count=click_count+1"." where id =1 ";
            pdo_query($sql);

        // }
        // else{
            $is_saa = 1;
        // }


        $sql2 = 'select click_count from ' . tablename('jsr_award') . " where id=1";
        $click_count = pdo_fetchcolumn($sql2);
        $_W['shopshare']['title'] = '中英街3·18鸣钟仪式线上活动';
        $_W['shopshare']['link'] =  mobileUrl('index.index', array(), true);
        $_W['shopshare']['desc'] =  '勿忘国耻·振兴中华！铭记历史不是为了延续仇恨，而是为了更好地开创未来。';
        $_W['shopshare']['imgUrl'] =  'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/sharewuwangguochi2.jpg';
        include $this->template();

    }


    public function notice(){
        global $_W, $_GPC;
        $sql3 = 'select sm.avatar,sm.nickname,ar.name,ar.id from ' . tablename('jsr_award_record') . " as ar " .
            ' left join ' . tablename('ewei_shop_member') . ' as sm on ar.openid=sm.openid order by type ,id desc';
        $hasawardlist = pdo_fetchall($sql3);
        include $this->template('index/notice');

    }
    public function checksubject(){
        global $_W, $_GPC;

        $model = $_GPC['model'];
        $sql = 'SELECT * FROM ' . tablename('jsr_subject');
        $res = pdo_fetchall($sql);
        $res = array_column($res,  NULL,'id');
        $errCount = 0;//错题数量
        foreach ($model as $key=>$value) {
            if ($value['answer'] != $res[$value['id']]['answer']) {
                $errCount++;

            }
        }
        if ($errCount > 0) {
            show_json(0,['msg'=>"您有{$errCount}道题答错啦,重新答题吧!"]);
        }



        //记录答题成功 , 查询是否可以抽奖
        $sql = 'select count(*) from ' . tablename('jsr_award_record') . ' WHERE openid=:open_id ';
        $has_award = pdo_fetchcolumn($sql, [':openid' => $_W['openid']]);

        //已抽奖
        if ($has_award) {
            show_json(1);
        }

        //添加可以抽
        $insertData = [
            'openid' => $_W['uniacid'],
            'create_time' => time()
        ];

    }

    //抽奖
    // 1:1等奖 2:2等奖 3:三等奖 4:特别奖 5:谢谢参与
    // public function lottery(){
    //     global $_W, $_GPC;
    //     $act_start_time = strtotime('2020-03-17 00:00:00');
    //     $act_end_time = strtotime('2020-03-18 23:59:59');
    //     $now_time = time();
    //     /*if ($_W['openid'] == 'o34wHwjGv5oOltblzsA6B8GPo-O4') {
    //         show_json(1,['type'=>3]);
    //     }*/
    //     // $sql = ' update ' . tablename('jsr_award') . " set click_count=click_count+1"." where id =1 ";
    //     // pdo_query($sql);
    //     if ($now_time >= $act_start_time && $now_time <= $act_end_time || $_W['openid'] == 'o34wHwtYklJBD1h0b4ImFOu82R3s' || $_W['openid'] == 'o34wHwjGv5oOltblzsA6B8GPo-O4' || $_W['openid'] == 'o34wHwmW3jin-yzzkps2c-Tv6f80') {
    //         $sql = 'select * from ' . tablename('jsr_award_record') . ' WHERE openid=:openid ';
    //         $has_award = pdo_fetch($sql, [':openid' => $_W['openid']]);
    //         //已中奖过
    //         if ($has_award) {
    //             //如果地址未填写 , 返回提交页面
    //             if ($has_award['type'] == 4 && ($has_award['mobile'] == "" || $has_award['realname'] == "" || $has_award['address'] == "")) {
    //                 show_json(1,['msg'=>'您已中奖,请填写您的信息','code'=>1,'type'=>4]);
    //             }
    //
    //         }
    //
    //         if ($has_award) {
    //             // show_json(1,['type'=>6,'msg'=>'谢谢参与!',]);
    //             show_json(1,['type'=>6,'msg'=>'您已中奖了,把机会让给别人吧!',]);
    //         }
    //
    //         $sql = 'select * from ' . tablename('jsr_award')." where id=1 ";
    //         $res = pdo_fetch($sql);
    //         $gl = 100 - $res['award1_pro'] - $res['award2_pro'] - $res['award3_pro'] - $res['award4_pro'];
    //         $data = [
    //             '1' => $res['award1_pro'], //1等奖概率
    //             '2' => $res['award2_pro'], //2等奖
    //             '3' => $res['award3_pro'], //3等奖
    //             '4' => $res['award4_pro'],  //4特别奖
    //             '5' =>  $res['award5_pro'], //5谢谢参与
    //         ];
    //
    //         //抽奖
    //         $type = $this->random($data);
    //         $money = 0;
    //         $award_count = 0;
    //         switch ($type) {
    //             case 1 :
    //                 $number = $res['award1'];
    //                 $msg = '一等奖';
    //                 $money = 318;
    //                 $award_count = $res['award1_count']; //总数量
    //                 break;
    //             case 2 :
    //                 $number = $res['award2'];
    //                 $msg = '二等奖';
    //                 $money = 31.8;
    //                 $award_count = $res['award2_count'];
    //
    //                 break;
    //             case 3 :
    //                 $number = $res['award3'];
    //                 $msg = '三等奖';
    //                 $money = 3.18;
    //                 $award_count = $res['award3_count'];
    //
    //                 break;
    //             case 4 :
    //                 $number = $res['award4'];
    //                 $msg = '特别奖';
    //                 $money = 0;
    //                 $award_count = $res['award4_count'];
    //
    //                 break;
    //             case 5 :
    //                 $msg = '谢谢参与';
    //                 $money = 0;
    //                 break;
    //         }
    //
    //         //谢谢参与
    //         if ($type == 5) {
    //
    //             show_json(1,['type'=>'5','msg'=>$msg]);
    //         }
    //
    //
    //
    //         //查询当前小时的中奖数量
    //         $sql3 = 'select count(*)  from ' . tablename('jsr_award_record').' where create_time >= :start_time and create_time <= :end_time and type=:type';
    //         $start_time = strtotime(date('Y-m-d H:00:00'));
    //         $end_time = strtotime(date('Y-m-d H:59:59'));
    //         $count = pdo_fetchcolumn($sql3, [':start_time' => $start_time, ':end_time' => $end_time,':type'=>$type]);
    //         //超过了当前小时中奖数量
    //         if ($count >= $number) {
    //             $type = 6;
    //             $msg = '谢谢参与';
    //             $money = 0;
    //
    //             show_json(1,['type'=>$type,'msg'=>$msg]);
    //         }
    //
    //         $sql4 = 'select count(*)  from ' . tablename('jsr_award_record').' where type=:type';
    //         $has_award_count = pdo_fetchcolumn($sql4, [':type' => $type]);
    //         //查询是否超过总数量
    //         if ($has_award_count >= $award_count) {
    //             $type = 6;
    //             $msg = '谢谢参与';
    //             $money = 0;
    //
    //             show_json(1,['type'=>$type,'msg'=>$msg]);
    //         }
    //
    //         $sql3 = 'select sum(money)  from ' . tablename('jsr_award_record').' where type in (1,2,3,4) ';
    //         $sum = pdo_fetchcolumn($sql3);
    //         $totalamount = $res['totalamount']; // 总金额
    //
    //
    //         //发放金额超过了可发放金额
    //         if ($sum > $totalamount) {
    //             $type = 6;
    //             $msg = '谢谢参与';
    //             $money = 0;
    //
    //             show_json(1,['type'=>$type,'msg'=>$msg]);
    //         }
    //
    //         $order_sn = $this->order_sn();
    //         //添加一条抽奖记录
    //         $insertData = [
    //             'openid' => $_W['openid'],
    //             'type' => $type,
    //             'create_time' =>time(),
    //             'order_sn' => $order_sn,
    //             'money' => $money,
    //             'name' => $msg,
    //         ];
    //
    //         if ($type != 4) {
    //             //奖品发放
    //             $result = m('finance')->pay($_W['openid'],1,$money*100,$order_sn,'318活动专用奖金');
    //             //$result = m('finance')->pay($_W['openid'],1,1*100,$order_sn,'红包发放');
    //             if (is_error($result)) {
    //                 // print_r($result);die();
    //                 show_json(0, '抽奖失败,再试试吧!');
    //             }
    //         }
    //
    //
    //         pdo_insert('jsr_award_record', $insertData);
    //         show_json(1,['type'=>$type,'msg'=>'恭喜您获得'.$msg,'code'=>$type == 4 ? 1 : 0]);
    //     }
    //     else{
    //         if ($now_time < $act_start_time) {
    //             $message = '活动尚未开始!';
    //         }
    //         else{
    //             $message = '活动结束!';
    //
    //         }
    //         show_json(0,['message'=>$message]);
    //
    //     }
    //
    // }

    public function message(){
        global $_GPC,$_W;
        $sql = 'select * from ' . tablename('jsr_message_board') .
            ' where uniacid=:uniacid and enabled = 1 order by sort,id desc limit 20';
        $list = pdo_fetchall($sql,[':uniacid'=>$_W['uniacid']]);
        show_json(1,['list'=>$list]);
    }

    //提交地址
    public function address(){
        global $_GPC, $_W;
        if ($_W['ispost']) {
            $inserData = [
                'mobile'=>trim($_GPC['mobile']),
                'realname'=>trim($_GPC['realname']),
                'address'=>trim($_GPC['address']),
            ];
            //查询特等级记录
            $sql = 'select * from ' . tablename('jsr_award_record') . " where type=4 and openid=:openid limit 1";
            $res = pdo_fetch($sql, [':openid' => $_W['openid']]);
            if ($res) {
                //更新地址
                pdo_update('jsr_award_record', $inserData, ['id' => $res['id']]);
                show_json(1,['msg'=>'提交成功']);
            }
        }
        show_json(0);


    }


    //留言
    public function addmessage(){
        global $_GPC,$_W;
        $message = trim($_GPC['message']);
        $openid = $_W['openid'];
        $member = m('member')->getMember($openid);

        $insertDdata = [
            'uniacid' => $_W['uniacid'],
            'message'=>$message,
            'name'=>$member['nickname'],
            'openid'=>$openid,
            'create_time'=>time()
        ];

        pdo_insert('jsr_message_board',$insertDdata);
        show_json(1,['msg'=>'留言成功！']);
    }


    protected function random($ps)
    {
        static $arr = array();
        $key = md5(serialize($ps));
        if (!isset($arr[$key])) {
            $max = array_sum($ps);
            foreach ($ps as $k => $v) {
                $v = $v / $max * 10000;
                for ($i = 0; $i < $v; $i++) $arr[$key][] = $k;
            }
        }
        return $arr[$key][mt_rand(0, count($arr[$key]) - 1)];
    }

    protected function order_sn()
    {
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

        $osn = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $osn;
    }



}

?>