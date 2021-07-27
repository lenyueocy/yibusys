<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Type_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $resData = pdo_fetchall("select * from {$this->table_supplier_type}");
        foreach ($resData as &$val) $val['create_time'] = date("Y-m-d H:i",$val['create_time']);
        include $this->template('supplier/type');
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
                'name' => $_GPC['name'],
                'create_time' => time(),
            ];
            if(!empty($_GPC['id'])){
                pdo_update('supplier_type',$data,['id'=>$_GPC['id']]);
            }else{
                pdo_insert('supplier_type',$data);
            }
            show_json(1,array('url' => webUrl('supplier/type')));
        }
        $resData = pdo_fetch("select * from {$this->table_supplier_type} where id={$_GPC['id']}");
        include $this->template('supplier/type/post');
    }

    public function delete()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall("select id,name from {$this->table_supplier_type} where id in ({$id})");
        foreach ($items as $item) {
            pdo_delete('supplier_type', array('id' => $item['id']));
            plog('supplier.type.delete', '删除供应商分类 ID: ' . $item['id'] . ' 名称: ' . $item['name'] . ' ');
        }
        show_json(1, array('url' => referer()));
    }

}

?>
