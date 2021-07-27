<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Bidding_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        m('buyer')->updateBiddingStart();
        $sql = "select * from {$this->table_buyer_bidding_project} where is_delete=0 order by create_time desc";
        $resData = pdo_fetchall($sql);

        foreach ($resData as &$val){
            if($val['end_time']<time() && $val['status']==1){
                pdo_update('buyer_bidding_project',['status'=>2,'is_end'=>1],['id'=>$val['id']]);
                $val['status'] = 2;
            }
            $val['create_time'] = date("Y-m-d H:i",$val['create_time']);
            $val['start_time'] = date("Y-m-d H:i",$val['start_time']);
            $val['end_time'] = date("Y-m-d H:i",$val['end_time']);
        }
        include $this->template('buyer/bidding/index');
    }

    public function choosebid(){
        global $_W,$_GPC;
        $bid_mode = pdo_getcolumn('buyer_bidding_project',['id'=>$_GPC['id']],'bid_mode');
        if($bid_mode==1) $son_params = ["*,max(talk_price)","order by bi.last_price desc"];
        else $son_params = ["*,min(talk_price)","order by bi.last_price asc"];
        $sql = "select bi.*,mu.merchname,bp.price as init_price,bp.name as project_name,bp.project_no,bp.bid_mode from 
                (select {$son_params[0]} as last_price from {$this->table_buyer_invite2} where project_id ={$_GPC['id']} GROUP BY supplier_id ) AS bi
                left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id 
                left join {$this->table_buyer_bidding_project} as bp on bp.id=bi.project_id 
                {$son_params[1]}";
        $resData = pdo_fetchall($sql);
        include $this->template('buyer/bidding/choosebid');
    }
    public function action_choosebid(){
        global $_W,$_GPC;
        if(empty($_GPC['id'])) show_json(0,'请选择要操作的项目');
        if(empty($_GPC['ids'])) show_json(0,'请选择要操作的数据');
        $project_no = pdo_getcolumn('buyer_bidding_project',['id'=>$_GPC['id']],'project_no');
        foreach ($_GPC['ids'] as $key=>$val){
            pdo_update('buyer_invite2',['choose_status'=>1],['project_id'=>$_GPC['id'],'supplier_id'=>$val]);
            pdo_update('buyer_project_supplier',['choose_status'=>1],['project_id'=>$_GPC['id'],'supplier_id'=>$val,'type'=>1]);
            pdo_update('buyer_bidding_project',['status'=>3,'approval_prize_status'=>1],['id'=>$_GPC['id']]);
            //notice([0,$_W['uid']],[$val,0],5,$project_no,"恭喜您,在竞价项目[{$project_no}]中标");
        }
        show_json(1, array('url' => webUrl('buyer/bidding')));
    }

    public function add()
    {
        $this->post();
    }

    public function edit()
    {
        $this->post();
    }

    public function post()
    {
        global $_W;
        global $_GPC;
        if ($_W['ispost']) {
            $postData = $_GPC['resData'];
            if(empty(trim($postData['name']))) show_json(0,'请填写项目名称');
            if(empty(trim($postData['company']))) show_json(0,'请填写公司名称');
            if(empty(trim($postData['blame_name']))) show_json(0,'请填写负责人');
            if(empty(trim($postData['mobile']))) show_json(0,'请填写联系电话');
            if(empty($postData['bid_mode'])) show_json(0,'请选择竞价方式');
            if(empty(trim($postData['start_time']))) show_json(0,'请选择竞价开始时间');
            if(empty(trim($postData['end_time']))) show_json(0,'请选择竞价结束时间');
            if(strtotime($postData['start_time'])<time()) show_json(0,'竞价开始时间不能小于当前时间');
            if(strtotime($postData['start_time'])>=strtotime($postData['end_time'])) show_json(0,'竞价结束时间不能小于竞价开始时间');
            if(intval($postData['floor_price'])<=0) show_json(0,'请填写正确的项目底价');
            if(intval($postData['quote_num'])<1) show_json(0,'请填写正确的报价数');
            if(intval($postData['quote_interval'])<1) show_json(0,'请填写报价间隔');
            if(intval($postData['price'])<=0) show_json(0,'请填写正确的项目初始价格');
            if($postData['price_adj_type']!==0 && $postData['price_adj_type']!==1 && $postData['price_adj_type']!=='0' && $postData['price_adj_type']!=='1') show_json(0,'请选择价格调整幅度类型');
            if(intval($postData['price_adj_range']<=0)) show_json(0,'请填写价格调整幅度');
            if(empty($postData['openbid_mode'])) show_json(0,'请选择启动竞价方式');
            if(empty(trim($postData['delayend_rule']))) show_json(0,'请选择延期结束规则');
            if(intval($postData['delayend_rule'])==1 && (intval($postData['delayend_front'])<1 || intval($postData['delayend_delay'])<1 || intval($postData['delayend_num'])<1 )) show_json(0,'请填写完整延期结束规则');
            if(intval($postData['delayend_rule'])==2 && (intval($postData['delayend_front'])<1 || intval($postData['delayend_delay'])<1 )) show_json(0,'请填写完整延期结束规则');

            foreach ($_GPC['checkedSupplierData'] as $key=>&$val) $val = $val===true||$val=='true'?true:false;
            $_GPC['checkedSupplierData'] = array_filter($_GPC['checkedSupplierData']);
            if(empty($_GPC['checkedSupplierData'])) show_json(0,'请添加供应商');
            if(empty($postData['lineData'])) show_json(0,'请添加线路信息');
            $data = [
                'name'=>$postData['name'],
                'company'=>$postData['company'],
                'blame_name'=>$postData['blame_name'],
                'mobile'=>$postData['mobile'],
                'bid_mode'=>$postData['bid_mode'],
                'start_time'=>strtotime($postData['start_time']),
                'end_time'=>strtotime($postData['end_time']),
                'quote_num'=>$postData['quote_num'],
                'quote_interval'=>$postData['quote_interval'],
                'price'=>intval($postData['price']),
                'price_adj_range'=>intval($postData['price_adj_range']),
                'price_adj_type'=>intval($postData['price_adj_type']),
                'desc'=>$postData['desc'],
                'bid_file'=>$postData['bid_file'],
                //'buyer_visible'=>$postData['buyer_visible'],
                //'supplier_visible'=>$postData['supplier_visible'],
                'delayend_rule'=>$postData['delayend_rule'],
                'delayend_front'=>$postData['delayend_front'],
                'delayend_delay'=>$postData['delayend_delay'],
                'delayend_num'=>$postData['delayend_num'],
                'floor_price'=>$postData['floor_price'],
            ];
            if(empty($_GPC['id'])) $data['project_no'] = "PJJ".time();
            if(empty($_GPC['id'])) $data['create_time'] = time();
            if(empty($_GPC['id'])) $data['status'] = 0;

            if(empty($_GPC['id'])) pdo_insert('buyer_bidding_project',$data);
            else pdo_update('buyer_bidding_project',$data,['id'=>$_GPC['id']]);

            $project_id = empty($_GPC['id'])?pdo_insertid():(empty($_GPC['id'])?$postData['id']:$_GPC['id']);
            if(empty($_GPC['id']) && empty($project_id)) show_json(0,'新增项目出错');

            //添加路线 绑定项目与路线关系
            $line_ids = [];
            foreach ($postData['lineData'] as $key=>$val){
                $data = [
                    //'bus_type'=>$val['bus_type'],
                    //'start_city'=>$val['start_city'],
                    //'end_province'=>$val['end_province'],
                    //'end_city'=>$val['end_city'],
                    //'end_area'=>$val['end_area'],
                    //'end_area'=>$val['end_area'],
                    'content'=>$val['content'],
                    'file'=>$val['file'],
                    'type'=>1,
                ];
                pdo_insert('buyer_line',$data);
                $line_ids[] = pdo_insertid();
            }

            //关联路线关系
            if(!empty($postData['id'])) pdo_delete('buyer_project_line',['project_id'=>$postData['id'],'type'=>1]);
            foreach ($line_ids as $key=>$val){
                pdo_insert('buyer_project_line',['project_id'=>$project_id,'line_id'=>$val,'create_time'=>time(),'type'=>1]);
            }

            //关联供应商关系
            $_GPC['checkedSupplierData'] = array_keys($_GPC['checkedSupplierData']);
            if(!empty($postData['id'])) pdo_delete('buyer_project_supplier',['project_id'=>$project_id,'type'=>1]);
            foreach ($_GPC['checkedSupplierData'] as $key=>$val){
                pdo_insert('buyer_project_supplier',['project_id'=>$project_id,'supplier_id'=>$val,'create_time'=>time(),'type'=>1]);
            }
            show_json(1, array('url' => webUrl('buyer/bidding')));
        }

        //获取供应商列表
        //$sql = "select pu.* from {$this->table_ewei_shop_perm_role} as pr left join {$this->table_ewei_shop_perm_user} as pu on pu.roleid=pr.id where pr.type='supplier'";
        $sql = "select id,merchname,realname,mobile from {$this->table_ewei_shop_merch_user}";
        $supplierListData = pdo_fetchall($sql);
        $supplierListData = array_column($supplierListData,null,'id');

        if(!empty($_GPC['id'])){

            $sql = "select bl.* from {$this->table_buyer_project_line} as pl left join {$this->table_buyer_line} as bl on bl.id=pl.line_id where pl.project_id={$_GPC['id']} and pl.type=1 ";
            $lineData = pdo_fetchall($sql);

            $checkedLine = pdo_fetchall("select line_id from {$this->table_buyer_project_line} where project_id={$_GPC['id']} and `type`=1");
            $checkedLine = array_column($checkedLine,null,'line_id');
            foreach ($checkedLine as &$val) $val = true;

            $checkedSupplier = pdo_fetchall("select supplier_id from {$this->table_buyer_project_supplier} where project_id={$_GPC['id']} and `type`=1");
            $checkedSupplier = array_column($checkedSupplier,null,'supplier_id');
            foreach ($checkedSupplier as &$val) $val = true;

            $resData = pdo_fetch("select * from {$this->table_buyer_bidding_project} where id={$_GPC['id']}");//where id={$_GPC['id']}
            $resData['lineData'] = $lineData;
            if($resData['openbid_mode']==1) $resData['is_start'] = $resData['create_time']>time()?true:false;
            if(!empty($resData['create_time'])) $resData['create_time'] = date("Y-m-d H:i",$resData['create_time']);
            if(!empty($resData['start_time'])) $resData['start_time'] = date("Y-m-d H:i",$resData['start_time']);
            if(!empty($resData['end_time'])) $resData['end_time'] = date("Y-m-d H:i",$resData['end_time']);

        }else{
            $resData = ['lineData'=>[]];
        }
        include $this->template('buyer/bidding/post');
    }

    public function delete(){
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0,'请选择你要操作的项目');
        foreach ($_GPC['ids'] as $key=>$val){
            pdo_update('buyer_bidding_project',['is_delete'=>1],['id'=>$val]);
        }
        show_json(1);
    }
    public function void(){
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0,'请选择你要操作的项目');
        foreach ($_GPC['ids'] as $key=>$val){
            pdo_update('buyer_bidding_project',['status'=>-1],['id'=>$val]);
        }
        show_json(1);
    }
    //提交审批接口
    public function submit_approval(){
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0,'请选择你要操作的项目');
        pdo_begin();
        foreach ($_GPC['ids'] as $key=>$val){
            $status = pdo_getcolumn('buyer_bidding_project',['id'=>$val],'status');
            $approval_status = pdo_getcolumn('buyer_bidding_project',['id'=>$val],'approval_status');
            if(!in_array($status,[0,1]) || $approval_status) {
                pdo_rollback();
                show_json(0,'项目中包含不可提交审批的状态');
            }
            pdo_update('buyer_bidding_project',['approval_status'=>1],['id'=>$val]);
        }
        pdo_commit();
        show_json(1);
    }
    //确认审批接口
    public function confirm_approval(){
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0,'请选择你要操作的项目');
        if(!in_array($_GPC['act_type'],['bidding','prize'])) show_json(0,'操作错误！');
        pdo_begin();
        foreach ($_GPC['ids'] as $key=>$val){
            if($_GPC['act_type']=='bidding') $status = pdo_getcolumn('buyer_bidding_project',['id'=>$val],'approval_status');
            if($_GPC['act_type']=='prize') $status = pdo_getcolumn('buyer_bidding_project',['id'=>$val],'approval_prize_status');
            if($status!=1) {
                pdo_rollback();
                show_json(0,'项目中包含不可审批的状态');
            }
            if($_GPC['act_type']=='bidding') pdo_update('buyer_bidding_project',['approval_status'=>2],['id'=>$val]);
            if($_GPC['act_type']=='prize') pdo_update('buyer_bidding_project',['approval_prize_status'=>2,'status'=>4],['id'=>$val]);
            if($_GPC['act_type']=='bidding') $supplier = pdo_fetchall("select * from {$this->table_buyer_project_supplier} where project_id={$val}  and `type`=1 ");
            if($_GPC['act_type']=='prize') $supplier = pdo_fetchall("select * from {$this->table_buyer_project_supplier} where project_id={$val} and choose_status=1 and `type`=1");
            $project_no = pdo_getcolumn('buyer_bidding_project',['id'=>$val],'project_no');
            foreach ($supplier as $k=>$v){
                if($_GPC['act_type']=='bidding') notice([0,$_W['uid']],[$v['supplier_id'],0],5,$project_no,"邀请您参与项目[{$project_no}]竞价,请关注相关信息");
                if($_GPC['act_type']=='prize') notice([0,$_W['uid']],[$v['supplier_id'],0],5,$project_no,"恭喜您,在竞价项目[{$project_no}]中标");
            }
        }
        pdo_commit();
        show_json(1);
    }
    public function action_project(){
        global $_W,$_GPC;
        if(empty($_GPC['act_type'])||empty($_GPC['id'])) show_json(0,'操作错误');
        if($_GPC['act_type']=='start'){
            $status = pdo_getcolumn('buyer_bidding_project',['id'=>$_GPC['id']],'approval_status');
            if($status!=2) {
                show_json(0,'操作失败！该项目审批状态未通过');
            }
            pdo_update("buyer_bidding_project",['status'=>1,'start_time'=>time()],['id'=>$_GPC['id']]);
        }
        show_json(1, array('url' => webUrl('buyer/bidding/edit',['id'=>$_GPC['id']])));
    }
    public function upload(){
        global $_W,$_GPC;
        if (empty($_FILES['file'])) exit(json_encode(['code'=>1,'msg'=>'请选择要上传的文件']));
        cache_delete('setting');
        $url = file_upload($_FILES['file'],'audio');
        if($url['success']==1) exit(json_encode(['code'=>1,'msg'=>'上传成功！','data'=>['src'=>tomedia($url['path'])]]));
        else exit(json_encode(['code'=>1,'msg'=>'上传失败！']));
    }
    public function test(){
        $str = 'a:3:{s:5:"image";a:3:{s:10:"extentions";a:4:{i:0;s:3:"gif";i:1;s:3:"jpg";i:2;s:4:"jpeg";i:3;s:3:"png";}s:5:"limit";i:5000;s:5:"thumb";i:0;}s:9:"attachdir";s:10:"attachment";s:5:"audio";a:2:{s:10:"extentions";a:1:{i:0;s:3:"mp3";}s:5:"limit";i:5000;}}';
        $str = unserialize($str);
        $str['audio']['extentions'] = [
            'mp3','doc','docx','pdf','csv','xls','xlsx','zip','rar','gz'
        ];
        echo "<pre>";
        print_r(serialize($str));
        exit;
    }
}

?>
