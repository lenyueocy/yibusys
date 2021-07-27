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

        $condition = ' s.uniacid = :uniacid';
        $params = array(':uniacid' => $_W['uniacid']);

        if ($_GPC['status'] != '') {
            $condition .= ' and s.status = :status';
            $params[':status'] = $_GPC['status'];
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' and ( s.name like :keyword or m.realname like :keyword or m.mobile like :keyword or m.nickname like :keyword)';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }

        $sql = 'SELECT s.*,m.nickname,m.avatar as m_avatar,m.realname FROM ' . tablename('ewei_kefu') . '  s ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid=m.openid and m.uniacid = s.uniacid '  . (' WHERE ' . $condition . ' ORDER BY id asc');
        $list = pdo_fetchall($sql, $params);
        foreach ($list as $key=>&$val){
            $val['createtime'] = date('Y-m-d H:i:s',$val['createtime']);
        }
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
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => trim($_GPC['openid']),
                'status' => intval($_GPC['status']),
                'name' => trim($_GPC['name']),
                'avatar' => trim($_GPC['avatar']),
            );

            if (empty($data['openid'])) show_json(0, '请选择会员');
            if (empty($data['name'])) show_json(0, '请填写客服名称');

            $m = m('member')->getMember($data['openid']);

            if (!empty($id)) {
                pdo_update('ewei_kefu', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
                plog('kefu.index.edit', '编辑客服 ID: ' . $id . ' <br/>客服信息: ID: ' . $m['id'] . ' / ' . $m['openid'] . '/' . $m['nickname'] . '/' . $m['realname'] . '/' . $m['mobile'] . ' ');
            } else {
                $data['createtime'] = time();
                $sCount = pdo_count('ewei_kefu',['openid'=>$data['opneid']]);
                if (0 < $sCount) show_json(0, '此会员已经成为医生，无法重复添加');

                pdo_insert('ewei_kefu', $data);
                $id = pdo_insertid();
                plog('kefu.index.add', '添加客服 ID: ' . $id . '  <br/>客服信息: ID: ' . $m['id'] . ' / ' . $m['openid'] . '/' . $m['nickname'] . '/' . $m['realname'] . '/' . $m['mobile'] . ' ');
            }

            show_json(1, array('url' => webUrl('kefu/index')));
        }
        $item = pdo_fetch('SELECT * FROM ' . tablename('ewei_doctor') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
        $store = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $item['storeid']));
        $saler = m('member')->getMember($item['openid']);
        $department = pdo_getall('ewei_department',['status'=>1,'is_delete'=>0]);
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

        $items = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_doctor') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_delete('ewei_doctor', array('id' => $item['id']));
            plog('doctor.index.delete', '删除医生 ID: ' . $item['id'] . ' 医生名称: ' . $item['name'] . ' ');
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

        $items = pdo_fetchall('SELECT id,`name` FROM ' . tablename('ewei_kefu') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_kefu', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
            plog('kefu.index.edit', '修改客服状态<br/>ID: ' . $item['id'] . '<br/>客服名称: ' . $item['name'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
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
    public function test(){
        global $_GPC,$_W;
        if (!function_exists('redis') || is_error(redis())) {
            $this->message('请联系管理员开启 redis 支持，才能使用客服系统', '', 'error');
            exit();
        }
        $msg_id = '6b22542d9d20ae76d336b24644150acc';
        $rlength = redis()->lLen($this->getRedisTable('chat_records',2));
        $msgResult1 = $msgResult = redis()->lrange($this->getRedisTable('chat_records',2),0,-1);
        $msgResult = array_reverse($msgResult);
        foreach ($msgResult as $key=>&$val){
            $val = json_decode($val,true);
        }
        $result = array_column(array_column($msgResult,'msg'),'id');
        $msgIndex = array_search($msg_id,$result);
        $result = array_slice($msgResult,$msgIndex+1,10);
        echo "<pre>";
        print_r($msgIndex);
        print_r($result);
        print_r($msgResult1);
        exit;
        //array_search('1616406012',array_map('array_shift',$result))


    }
    public function getRedisTable($table, $roomid)
    {
        return 'ewei_shop_kefu_' . $table . '_' . $roomid;
    }
}

?>
