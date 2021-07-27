<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Buyerinquiry_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $sql = "select sp.*,st.name as type_name from {$this->table_buyer_project} as sp left join {$this->table_supplier_type} as st on st.id=sp.type_id where sp.is_delete=0 order by sp.id desc";
        $resData = pdo_fetchall($sql);
        foreach ($resData as &$val){
            $val['create_time'] = date("Y-m-d H:i",$val['create_time']);
            $val['end_time'] = date("Y-m-d H:i",$val['end_time']);
        }
        include $this->template('buyer/buyerinquiry/index');
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
            if(empty($_GPC['type_id'])) show_json(0, '请选择采购类型');
            if(!isset($_GPC['offer_limit'])) show_json(0, '请选择报价限制');
            if(!isset($_GPC['end_type'])) show_json(0, '请选择投标截止方式');
            //if(!isset($_GPC['result_type'])) show_json(0, '请选择中标结果');
            if(!isset($_GPC['end_time'])) show_json(0, '请选择投标截止时间');
            foreach ($_GPC['content'] as $key=>$val){
                $lineData[$key]['file'] = $_GPC['file'][$key];
                $lineData[$key]['content'] = $_GPC['content'][$key];
            }
            /*foreach ($_GPC['bus_type'] as $key=>$val){
                if(empty(trim($val))) show_json(0, '第'.($key+1).'行，请填写业务类型');
                if(empty(trim($_GPC['start_city'][$key]))) show_json(0, '第'.($key+1).'行，请填写出发城市');
                if(empty(trim($_GPC['end_province'][$key]))) show_json(0, '第'.($key+1).'行，请填写到达省份');
                if(empty(trim($_GPC['end_city'][$key]))) show_json(0, '第'.($key+1).'行，请填写到达市');
                if(empty(trim($_GPC['end_area'][$key]))) show_json(0, '第'.($key+1).'行，请填写到达区');
                if(empty(trim($_GPC['file'][$key]))) show_json(0, '第'.($key+1).'行，请上传报价文件');
                $lineData[$key]['bus_type'] = $val;
                $lineData[$key]['start_city'] = $_GPC['start_city'][$key];
                $lineData[$key]['end_province'] = $_GPC['end_province'][$key];
                $lineData[$key]['end_city'] = $_GPC['end_city'][$key];
                $lineData[$key]['end_area'] = $_GPC['end_area'][$key];
                $lineData[$key]['file'] = $_GPC['file'][$key];
            }*/

            $data = [
                'name'=>$_GPC['name'],
                'project_no'=>"PXJ".date("Y").date("m").date('d').date('H').date('i').date('s'),
                'type_id'=>$_GPC['type_id'],
                'blame_name'=>$_GPC['blame_name'],
                'offer_limit'=>$_GPC['offer_limit'],
                'end_type'=>$_GPC['end_type'],
                //'result_type'=>$_GPC['result_type'],
                'end_time'=>strtotime($_GPC['end_time']),
                'mobile'=>$_GPC['mobile'],
                'desc'=>$_GPC['desc'],
                'qua_ask'=>$_GPC['qua_ask'],
                'bid_file'=>$_GPC['bid_file'],
            ];
            if(empty($_GPC['id'])) $data['create_time'] = time();
            if(empty($_GPC['id'])) $data['status'] = 0;
            pdo_insert('buyer_project',$data);
            $project_id = pdo_insertid();
            if(empty($project_id)) show_json(0, '创建项目失败');

            //添加线路数据
            $line_ids = [];
            foreach ($lineData as $key=>$val){
                $data = [
                    'file'=>$val['file'],
                    'content'=>$val['content'],
                ];
                /*$data = [
                    'bus_type'=>$val['bus_type'],
                    'start_city'=>$val['start_city'],
                    'end_province'=>$val['end_province'],
                    'end_city'=>$val['end_city'],
                    'end_area'=>$val['end_area'],
                    'file'=>$val['file'],
                    'line_no'=>"LL".time(),
                    'create_time'=>time(),
                ];*/
                pdo_insert('buyer_line',$data);
                $line_ids[] = pdo_insertid();
            }
            foreach ($line_ids as $key=>$val){
                $data = [
                    'project_id'=>$project_id,
                    'line_id'=>$val,
                    'create_time'=>time(),
                    'status'=>1,
                    'type'=>2,
                ];
                pdo_insert('buyer_project_line',$data);
            }
            show_json(1, array('url' => webUrl('buyer/buyerinquiry')));
        }

        $lineListData = pdo_fetchall("select * from {$this->table_buyer_line}");
        $supplierType = pdo_fetchall("select * from {$this->table_supplier_type}");
        include $this->template('buyer/buyerinquiry/post');
    }

    public function delete()
    {
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0, '请选择你要操作的数据');
        foreach ($_GPC['ids'] as $key=>$val){
            pdo_update("buyer_project",['is_delete'=>1],['id'=>$val]);
        }
        show_json(1, '操作成功');
    }

    public function invite(){
        global $_W,$_GPC;
        if($_W['ispost']){
            //生成报价信息
            /*if(empty($_GPC['ids'])) show_json(0, '请选择你要操作的数据');
            pdo_begin();
            foreach ($_GPC['ids'] as $key=>$val){
                $invite = pdo_getcolumn('buyer_invite',['project_id'=>$_GPC['project_id'],'supplier_id'=>$val],'id');
                if(!empty($invite)) continue;
                //获取项目的所有线路
                $lineListData = pdo_getall('buyer_project_line',['project_id'=>$_GPC['project_id'],'type'=>2]);
                foreach ($lineListData as $k=>$v){
                    $data = [
                        'project_id'=>$_GPC['project_id'],
                        'supplier_id'=>$val,
                        'line_id'=>$v['line_id'],
                        'create_time'=>time(),
                        'type'=>2,
                    ];
                    pdo_insert('buyer_invite',$data);
                    if(!pdo_insertid()){
                        pdo_rollback();
                        show_json(1, '提交失败！');
                    }
                }
            }*/
            pdo_update('buyer_project',['status'=>1],['id'=>$_GPC['project_id']]);
            //pdo_commit();
            show_json(1, ['url' => webUrl('buyer/buyerinquiry')]);
        }
        /*$sql = "select mu.id,mu.merchname,mu.realname,mu.mobile,si.id as invite,si2.id as history from {$this->table_ewei_shop_merch_user} as mu
                left join {$this->table_buyer_invite} as si on si.supplier_id=mu.id and project_id={$_GPC['id']}
                left join {$this->table_buyer_invite} as si2 on si2.supplier_id=mu.id";
        $supplierListData = pdo_fetchall($sql);
        $supplierListData = array_column($supplierListData,null,'id');*/

        $sql = "select mu.id,mu.merchname,mu.realname,mu.mobile,ps.id as invite,ps2.id as history from {$this->table_ewei_shop_merch_user} as mu
                left join {$this->table_buyer_project_supplier} as ps on ps.supplier_id=mu.id and ps.project_id={$_GPC['id']} and ps.type=2
                left join {$this->table_buyer_project_supplier} as ps2 on ps2.supplier_id=mu.id and ps2.type=2";
        $supplierListData = pdo_fetchall($sql);
        $supplierListData = array_column($supplierListData,null,'id');
        include $this->template('buyer/buyerinquiry/invite');
    }
    //邀请供应商
    public function action_invite(){
        global $_W,$_GPC;

        if(empty($_GPC['supplier_id'])) show_json(0, '请选择要邀请的供应商');

        if($_GPC['type']=='cancel'){
            pdo_delete('buyer_project_supplier',['project_id'=>$_GPC['project_id'],'supplier_id'=>$_GPC['supplier_id'],'type'=>2]);
            show_json(1, '操作成功');
        }
        if(!is_array($_GPC['supplier_id'])){
            $supplier_id = $_GPC['supplier_id'];
            $_GPC['supplier_id'] = [];
            $_GPC['supplier_id'][$supplier_id] = true;
        }
        if(is_array($_GPC['supplier_id'])){
            $_GPC['supplier_id'] = array_filter($_GPC['supplier_id']);
            foreach ($_GPC['supplier_id'] as $key=>$val){
                if($val==false || $val==='false') continue;
                $invite = pdo_getcolumn('buyer_project_supplier',['project_id'=>$_GPC['project_id'],'supplier_id'=>$key,'type'=>2],'id');
                if(!empty($invite)) continue;
                $data = [
                    'project_id'=>$_GPC['project_id'],
                    'supplier_id'=>$key,
                    'create_time'=>time(),
                    'type'=>2,
                ];
                pdo_insert('buyer_project_supplier',$data);
                $project_no = pdo_getcolumn('buyer_project',['id'=>$_GPC['project_id']],'project_no');
                notice([0,$_W['uid']],[$key,0],2,$project_no,"邀请您参与项目报价");
            }
            show_json(1, '操作成功');
        }

        $invite = pdo_getcolumn('buyer_project_supplier',['project_id'=>$_GPC['project_id'],'supplier_id'=>$_GPC['supplier_id'],'type'=>2],'id');
        if(!empty($invite)) show_json(0, '该供应商已邀请');
        $lineListData = pdo_getall('buyer_project_line',['project_id'=>$_GPC['project_id'],'type'=>2]);
        $data = [
            'project_id'=>$_GPC['project_id'],
            'supplier_id'=>$_GPC['supplier_id'],
            'type'=>2,
            'create_time'=>time(),
        ];
        pdo_insert('buyer_project_supplier',$data);

        show_json(1, '操作成功');
    }
    /*public function action_invite(){
        global $_W,$_GPC;
        if(empty($_GPC['supplier_id'])) show_json(0, '请选择要邀请的供应商');

        if($_GPC['type']=='cancel'){
            pdo_delete('buyer_invite',['project_id'=>$_GPC['project_id'],'supplier_id'=>$_GPC['supplier_id']]);
            show_json(1, '操作成功');
        }
        if(is_array($_GPC['supplier_id'])){
            $_GPC['supplier_id'] = array_filter($_GPC['supplier_id']);
            foreach ($_GPC['supplier_id'] as $key=>$val){
                if($val==false || $val=='false') continue;
                $invite = pdo_getcolumn('buyer_invite',['project_id'=>$_GPC['project_id'],'supplier_id'=>$key],'id');
                if(!empty($invite)) continue;
                //获取项目的所有线路
                $lineListData = pdo_getall('buyer_project_line',['project_id'=>$_GPC['project_id'],'type'=>2]);
                foreach ($lineListData as $k=>$v){
                    $data = [
                        'project_id'=>$_GPC['project_id'],
                        'supplier_id'=>$key,
                        'line_id'=>$v['line_id'],
                        'create_time'=>time(),
                    ];
                    pdo_insert('buyer_invite',$data);
                }
            }
            show_json(1, '操作成功');
        }
        $invite = pdo_getcolumn('buyer_invite',['project_id'=>$_GPC['project_id'],'supplier_id'=>$_GPC['supplier_id']],'id');
        if(!empty($invite)) show_json(0, '该供应商已邀请');
        $lineListData = pdo_getall('buyer_project_line',['project_id'=>$_GPC['project_id'],'type'=>2]);
        foreach ($lineListData as $key=>$val){
            $data = [
                'project_id'=>$_GPC['project_id'],
                'supplier_id'=>$_GPC['supplier_id'],
                'line_id'=>$val['line_id'],
                'create_time'=>time(),
            ];
            pdo_insert('buyer_invite',$data);
        }

        show_json(1, '操作成功');
    }*/
    public function openbid(){
        global $_W,$_GPC;
        $resData = pdo_fetch("select * from {$this->table_buyer_project} where id={$_GPC['id']}");
        $resData['end_time'] = date("Y-m-d H:i",$resData['end_time']);
        $sql = "select bi.*,mu.merchname from {$this->table_buyer_invite} as bi 
                left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id 
                where bi.project_id={$_GPC['id']} and bi.type=2 group by bi.supplier_id ";
        $inviteListData = pdo_fetchall($sql);

        //查询已报价线路
        /*$lineListData = pdo_fetchall("select * from {$this->table_buyer_project_line} as pl
                        left join {$this->table_supplier_line} as sl on sl.id=pl.line_id");
        $sql = "select * from {$this->table_buyer_invite} as si
                left join {$this->table_supplier_line} as sl on sl.id=si.line_id";
        $lineListData = pdo_fetchall($sql);*/

        //先项目线路，再根据线路去查询对应的邀请
        //先查询这个项目有几条线路然后每条线路去查询 邀请的供应商报价
        //$sql = "select *,group_concat(supplier_id) from {$this->table_buyer_invite} where project_id={$_GPC['id']} group by line_id ";
        $sql = "select * from {$this->table_buyer_project_line} as pl left join {$this->table_buyer_line} as bl on bl.id=pl.line_id where project_id={$_GPC['id']}";
        $lineListData = pdo_fetchall($sql);

        foreach ($lineListData as $key=>$val){
            $sql = "select bi.price,bi.talk_file,bi.volume_unit_price,bi.weight_unit_price,bi.tax_rate,mu.merchname from {$this->table_buyer_invite} as bi 
                          left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id 
                          where bi.line_id={$val['line_id']} and bi.project_id={$_GPC['id']}";/*and bi.is_quote=1*/
            $supplier_quote = pdo_fetchall($sql);
            foreach ($supplier_quote as $k=>&$v) if(!empty($v)) $v['talk_file'] = $_W['siteroot'].$v['talk_file'];
            $lineListData[$key]['supplier_quote'] = $supplier_quote;

        }

        //foreach ($inviteListData as $key=>$val)

        include $this->template('buyer/buyerinquiry/openbid');
    }
    public function detail(){
        global $_W,$_GPC;

        $resData = pdo_fetch("select * from {$this->table_buyer_project} where id={$_GPC['id']}");
        $resData['end_time'] = date("Y-m-d H:i",$resData['end_time']);

        $lineData = pdo_fetchall("select * from {$this->table_buyer_project_line} as pl 
                                      left join {$this->table_buyer_line} as bl on bl.id=pl.line_id where pl.project_id={$_GPC['id']} and pl.type=2");

        $supplierListData = pdo_fetchall("select mu.merchname,mu.mobile,mu.id,mu.realname from {$this->table_buyer_project_supplier} as ps 
                                          left join {$this->table_ewei_shop_merch_user} as mu on mu.id=ps.supplier_id where ps.project_id={$_GPC['id']} and ps.type=2");

        $sql = "select * from {$this->table_buyer_project_line} as pl left join {$this->table_buyer_line} as bl on bl.id=pl.line_id where project_id={$_GPC['id']}";
        $lineListData = pdo_fetchall($sql);
        foreach ($lineListData as $key=>$val){
            $sql = "select bi.price,bi.file,bi.talk_file,bi.volume_unit_price,bi.weight_unit_price,bi.tax_rate,mu.merchname from {$this->table_buyer_invite} as bi 
                          left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id 
                          where bi.line_id={$val['line_id']} and bi.project_id={$_GPC['id']}";
            $supplier_quote = pdo_fetchall($sql);
            foreach ($supplier_quote as $k=>&$v){
                if(!empty($v['talk_file'])) $v['talk_file'] = $_W['siteroot'].$v['talk_file'];
            }
            $lineListData[$key]['supplier_quote'] = $supplier_quote;
        }
        //获取中标结果
        $chooseListData = pdo_fetchall("select bi.*,bl.*,mu.merchname,bi.id as id from {$this->table_buyer_invite} as bi 
                  left join {$this->table_buyer_line} as bl on bl.id=bi.line_id
                  left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id where bi.project_id={$_GPC['id']} and bi.choose_status=1 and bi.type=2");
        include $this->template('buyer/buyerinquiry/detail');
    }
    public function action_openbid(){
        global $_W,$_GPC;
        if(!$_GPC['id']) show_json(0, '请选择你要操作的项目！');
        if($_GPC['act_type']=='stop'){
            if(!$_GPC['stop_desc']) show_json(0, '截止理由不能为空！');
            pdo_update("buyer_project",['is_stop'=>1,'stop_desc'=>$_GPC['stop_desc']],['id'=>$_GPC['id']]);
        }else if($_GPC['act_type']=='end'){
            //如果供应商没有报价是无法结束开标的
            $is_stop = pdo_getcolumn('buyer_project',['id'=>$_GPC['id']],'is_stop');
            if(empty($is_stop)) show_json(0, '投标未截止，不能结束开标！');

            $is_quote = pdo_fetchcolumn("select count(id) from {$this->table_buyer_invite} where project_id={$_GPC['id']} and `type`=2");
            if($is_quote>0) pdo_update("buyer_project",['status'=>2],['id'=>$_GPC['id']]);
            else show_json(0, '供应商未报价,不能结束开标');
            show_json(1, ['url' => webUrl('buyer/buyerinquiry')]);
        }else{
            show_json(0, '系统出错！');
        }
        show_json(1, '操作成功！');
    }
    public function choosebid(){
        global $_W,$_GPC;
        $resData = pdo_fetchall("select bi.*,bl.*,bi.talk_file,bl.file,mu.merchname,bi.id as id from {$this->table_buyer_invite} as bi 
                  left join {$this->table_buyer_line} as bl on bl.id=bi.line_id
                  left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id where bi.project_id={$_GPC['id']}");
        //合并取出供应商 取供应商报价文件
        $sql = "select bi.*,mu.merchname,group_concat(bi.id) as invite_ids from {$this->table_buyer_invite} as bi 
                left join {$this->table_buyer_line} as bl on bl.id=bi.line_id
                left join {$this->table_ewei_shop_merch_user} as mu on mu.id=bi.supplier_id
                where bi.project_id={$_GPC['id']} and bi.type=2 group by bi.supplier_id";
        $resData = pdo_fetchall($sql);
        foreach ($resData as $key=>$val){
            $invite_ids = explode(',',$val['invite_ids']);
            foreach ($invite_ids as $k=>$v){
                $invite = pdo_get("buyer_invite",['id'=>$v],['line_id','talk_file']);
                $content = pdo_getcolumn("buyer_line",['id'=>$invite['line_id']],'content');
                $resData[$key]['talk_files'][] = ['content'=>$content,'talk_file'=>$invite['talk_file'],'invite_id'=>$v];
            }
        }
        $resData = array_column($resData,null,'supplier_id');
        include $this->template('buyer/buyerinquiry/choosebid');
    }
    public function action_choosebid(){
        global $_W,$_GPC;
        //归档
        if($_GPC['act_type']=='placefile'){
            pdo_update('buyer_project',['status'=>3],['id'=>$_GPC['project_id']]);
            show_json(1,['url'=>webUrl('buyer/buyerinquiry')]);
        }
        //提交审批
        if($_GPC['act_type']=='approval'){
            $talk_status = pdo_getcolumn('buyer_invite',['talk_status'=>1,'project_id'=>$_GPC['project_id']],'id');
            if(!empty($talk_status)) show_json(0,'操作失败,项目有未确认的议价状态');
            pdo_update('buyer_project',['approval_prize_status'=>1],['id'=>$_GPC['project_id']]);
            show_json(1,['url'=>webUrl('buyer/buyerinquiry')]);
        }
        //再次竞价
        if($_GPC['act_type']=='bidding'){
            pdo_update('buyer_project',['status'=>1,'is_stop'=>0],['id'=>$_GPC['project_id']]);
            pdo_update('buyer_invite',['choose_status'=>0],['project_id'=>$_GPC['project_id'],'type'=>2]);
            //查询项目
            show_json(1,['url'=>webUrl('buyer/buyerinquiry')]);
        }
        if($_GPC['act_type']=='choose') $data = ['choose_status'=>1];
        else $data = ['choose_status'=>0];
        foreach ($_GPC['id'] as $key=>&$val) $val = $val==1||$val=='true'?true:false;
        $_GPC['id'] = array_filter($_GPC['id']);
        $_GPC['id'] = array_keys($_GPC['id']);
        foreach ($_GPC['id'] as $key=>$val){
            pdo_update('buyer_invite',$data,['project_id'=>$_GPC['project_id'],'supplier_id'=>$val,'type'=>2]);
        }
        show_json(1, ['resData'=>$_GPC['id']]);
    }
    public function submit_talk(){
        global $_W,$_GPC;
        if(empty($_GPC['ids'])) show_json(0, '请选择你要操作的数据！');
        foreach ($_GPC['ids'] as $key=>$val){
            $supplier_id = pdo_getcolumn('buyer_invite',['id'=>$key],'supplier_id');
            pdo_update('buyer_invite',['dis_file'=>$val,'talk_status'=>1],['id'=>$key]);
        }
        show_json(1, ['supplier_id'=>$supplier_id]);
    }
    public function action_project(){
        global $_W,$_GPC;
        if(!$_GPC['ids']) show_json(0, '请选择你要操作的项目！');
        if(!$_GPC['act_type']) show_json(0, '操作错误！');
        //提交审批
        if($_GPC['act_type']=='submit_approval'){
            pdo_begin();
            foreach ($_GPC['ids'] as $key=>$val){
                $approval_status = pdo_getcolumn('buyer_project',['id'=>$val],'approval_status');
                $approval_prize_status = pdo_getcolumn('buyer_project',['id'=>$val],'approval_prize_status');
                /*if($approval_status!=0 && $approval_prize_status!=0){
                    pdo_rollback();
                    show_json(0, '选择的项目中包含不可提交审批的项目！');
                }*/
                if($approval_status==0) pdo_update('buyer_project',['approval_status'=>1],['id'=>$val]);
                else if($approval_prize_status==0) pdo_update('buyer_project',['approval_prize_status'=>1],['id'=>$val]);
            }
            pdo_commit();
            show_json(1,['url'=>webUrl('buyer/buyerinquiry')]);
        }
        if(in_array($_GPC['act_type'],['inquiry_approval','choose_approval'])){
            pdo_begin();
            foreach ($_GPC['ids'] as $key=>$val){
                $approval_status = pdo_getcolumn('buyer_project',['id'=>$val],'approval_status');
                $approval_prize_status = pdo_getcolumn('buyer_project',['id'=>$val],'approval_prize_status');
                if(($_GPC['act_type']=='inquiry_approval'&&$approval_status!=1) || ($_GPC['act_type']=='choose_approval'&&$approval_prize_status!=1)){
                    pdo_rollback();
                    show_json(0, '选择的项目中包含不在审批的项目！');
                }
                if($_GPC['act_type']=='inquiry_approval') pdo_update('buyer_project',['approval_status'=>2],['id'=>$val]);
                if($_GPC['act_type']=='choose_approval') pdo_update('buyer_project',['approval_prize_status'=>2,'status'=>3],['id'=>$val]);
            }
            pdo_commit();
            show_json(1,['url'=>webUrl('buyer/buyerinquiry')]);
        }
    }
    public function placefile(){
        global $_W,$_GPC;
        //pdo_update("buyer_project",['status'=>1]);
        //归档项目

    }

}

?>
