<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Biddinghall_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W,$_GPC;
        //读取出所有 启动方式为自动 开始时间小于当前时间的
        /*$sql = "select * from {$this->table_buyer_bidding_project} as bp
                left join {$this->table_supplier_type} as st on st.id=bp.type_id";*/
        $time = time();
        $sql = "select * from {$this->table_buyer_bidding_project} where start_time<={$time} and end_time>{$time} and status=1 and is_delete=0 and approval_status=2";
        $resData = pdo_fetchall($sql);
        foreach ($resData as $key=>&$val){
            $val['start_time'] = date("Y-m-d H:i",$val['start_time']);
            $val['end_time'] = date("Y-m-d H:i",$val['end_time']);
        }
        include $this->template('buyer/biddinghall/index');
    }

    public function add()
    {
        $this->post();
    }

    public function edit()
    {
        $this->post();
    }

    protected function post()
    {
        global $_W;
        global $_GPC;
        if ($_W['ispost']) {
            $data = [
                'bus_type'=>$_GPC['bus_type'],
                'start_city'=>$_GPC['start_city'],
                'end_province'=>$_GPC['end_province'],
                'end_city'=>$_GPC['end_city'],
                'end_area'=>$_GPC['end_area'],
                'volume'=>$_GPC['volume'],
                'weight'=>$_GPC['weight'],
                'offer_way'=>$_GPC['offer_way'],
                'volume_price'=>$_GPC['volume_price'],
                'weight_price'=>$_GPC['weight_price'],
            ];
            if(empty($_GPC['id'])) $data['create_time'] = time();
            if(empty($_GPC['id'])) $data['status'] = 1;

            if(!empty($_GPC['id'])) pdo_update('buyer_line',$data,['id'=>$_GPC['id']]);
            else pdo_insert('buyer_line',$data);
            show_json(1, array('url' => webUrl('line/index')));
        }

        $resData = pdo_fetch("select * from {$this->table_buyer_line} where id={$_GPC['id']}");
        $resData['province'] = $resData['end_province'];
        $resData['city'] = $resData['end_city'];
        $resData['area'] = $resData['end_area'];
        include $this->template('line/index/post');
    }

    public function delete()
    {

    }

    public function detail(){
        global $_W,$_GPC;
        include $this->template('buyer/biddinghall/detail');
    }

    public function get_detail(){
        global $_W,$_GPC;
        //if(!in_array($_GPC['act_type'],['get_detail','get_rank','get_record'])) show_json(0,'请求出错');
        if($_GPC['act_type']=='infoData'){
            $sql = "select * from {$this->table_buyer_bidding_project} where id={$_GPC['id']}";
            $resData = pdo_fetch($sql);
            $resData['start_time'] = date("Y-m-d H:i",$resData['start_time']);
            $resData['end_time'] = date("Y-m-d H:i",$resData['end_time']);
            show_json(1,['infoData'=>$resData]);
        }
        if($_GPC['act_type']=='historyData'){
            $bid_mode = pdo_getcolumn('buyer_bidding_project',['id'=>$_GPC['id']],'bid_mode');
            if($bid_mode==1) $son_params = ["order by bi.create_time desc"];
            else $son_params = ["order by bi.create_time desc"];//更改逻辑
            $sql = "select bp.name as project_name,bi.price,bi.create_time,mu.merchname,bi.number,bp.price_adj_type 
                    from {$this->table_buyer_invite2} as bi 
                    left join {$this->table_buyer_bidding_project} as bp on bp.id=bi.project_id
                    left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id 
                    where bi.project_id={$_GPC['id']} {$son_params[0]}";
            $resData = pdo_fetchall($sql);
            foreach ($resData as $key=>&$val){
                $val['create_time'] = date("Y-m-d H:i",$val['create_time']);
                //if($val['price_adj_type']==0) $val['talk_price'] =
            }
            show_json(1,['historyData'=>$resData]);
        }
        if($_GPC['act_type']=='rankingData'){
            $bid_mode = pdo_getcolumn('buyer_bidding_project',['id'=>$_GPC['id']],'bid_mode');
            if($bid_mode==1) $son_params = ["bi.*,mu.merchname,max(bi.number) as last_number,max(bi.price)","order by  last_price desc"];
            else $son_params = ["bi.*,mu.merchname,max(bi.number) as last_number,min( bi.price )","order by last_price asc"];
            $son_sql = "SELECT {$son_params[0]} AS last_price FROM ims_buyer_invite2 as bi 
                        LEFT JOIN ims_ewei_shop_merch_user AS mu ON mu.id = bi.supplier_id  WHERE bi.project_id = {$_GPC['id']} 
                        GROUP BY bi.supplier_id {$son_params[1]}";
            $sql = "SELECT bis.*,@rownum := @rownum + 1 AS ranking FROM (SELECT @rownum := 0) r,({$son_sql}) as bis";
            $resData = pdo_fetchall($sql);
            show_json(1,['rankingData'=>$resData]);
        }
        show_json(0,'请求出错');
    }

}

?>
