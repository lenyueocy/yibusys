<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $condition = ' uniacid = :uniacid';
        $params = array(':uniacid' => $_W['uniacid']);

        if ($_GPC['status'] != '') {
            $condition .= ' and status = :status';
            $params[':status'] = $_GPC['status'];
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' and ( name like :keyword )';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }
        $table_brand = tablename('ewei_shop_brand');
        $sql = "select * from {$table_brand} where {$condition}";
        $list = pdo_fetchall($sql, $params);
        include $this->template();
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
        $id = intval($_GPC['id']);

        if ($_W['ispost']) {
            if (empty($_GPC['name'])) show_json(0, '请填写品牌名称');
            if (empty($_GPC['logo'])) show_json(0, '请上传品牌logo');

            $data = array(
                'uniacid' => $_W['uniacid'],
                'name' => $_GPC['name'],
                'logo' => $_GPC['logo'],
                'status' => intval($_GPC['status']),
            );
            if(!empty($_GPC['cate_id'])) $data['cate_id'] = $_GPC['cate_id'];
            $member = m('member')->getMember($data['openid']);

            if (!empty($id)) {
                pdo_update('ewei_shop_brand', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
            } else {
                pdo_insert('ewei_shop_brand', $data);
                $id = pdo_insertid();
            }

            show_json(1, array('url' => webUrl('brand')));
        }
        $item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_brand') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
        $category = pdo_getall('ewei_shop_brand_category',['status'=>1]);
        include $this->template();
    }

    public function delete()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_brand') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_delete('ewei_shop_brand', array('id' => $item['id']));
            plog('brand.index.delete', '删除医生 ID: ' . $item['id'] . ' 医生名称: ' . $item['name'] . ' ');
        }

        show_json(1, array('url' => referer()));
    }

    public function status()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,`name` FROM ' . tablename('ewei_shop_brand') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_brand', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
            plog('brand.index.edit', '修改品牌状态<br/>ID: ' . $item['id'] . '<br/>医生名称: ' . $item['name'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
        }
        show_json(1, array('url' => referer()));
    }

    public function query()
    {
        global $_W;
        global $_GPC;
        $kwd = trim($_GPC['keyword']);
        $params = array();
        $params[':uniacid'] = $_W['uniacid'];
        $condition = ' and s.uniacid=:uniacid';

        if (!empty($kwd)) {
            $condition .= ' AND ( m.nickname LIKE :keyword or m.realname LIKE :keyword or m.mobile LIKE :keyword or store.storename like :keyword )';
            $params[':keyword'] = '%' . $kwd . '%';
        }

        $ds = pdo_fetchall('SELECT s.*,m.nickname,m.avatar,m.mobile,m.realname,store.storename FROM ' . tablename('ewei_shop_saler') . '  s ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid=m.openid ' . ' left join ' . tablename('ewei_shop_store') . ' store on store.id=s.storeid ' . (' WHERE 1 ' . $condition . ' ORDER BY id asc'), $params);
        include $this->template();
        exit();
    }
}

?>
