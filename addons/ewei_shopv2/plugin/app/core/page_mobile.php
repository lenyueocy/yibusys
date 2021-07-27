<?php
function filterEmptyData($result)
{
	foreach ($result as $k => $v) {
		if (empty($v) && is_array($v) || $v === NULL) {
			unset($result[$k]);
			continue;
		}

		if (is_array($v)) {
			$result[$k] = filterEmptyData($v);
		}
	}

	return $result;
}

function app_error($errcode = 0, $message = '')
{
	global $iswxapp;
	global $openid;
	$res = array('error' => $errcode, 'message' => empty($message) ? AppError::getError($errcode) : $message);
	exit(json_encode($res));
}

function app_json($result = NULL)
{
	global $iswxapp;
	global $openid;
	global $_W;
	global $_GPC;
	$ret = array();

	if (!is_array($result)) {
		$result = array();
	}

	$ret['error'] = 0;
	if (!empty($result) && !$iswxapp) {
		$result = filteremptydata($result);
	}

	$ret['sysset'] = array(
		'shopname'     => $_W['shopset']['shop']['name'],
		'shoplogo'     => $_W['shopset']['shop']['logo'],
		'description'  => $_W['shopset']['shop']['description'],
		'saleout_icon' => isset($_W['shopset']['shop']['saleout']) ? tomedia($_W['shopset']['shop']['saleout']) : '',
		'share'        => $_W['shopset']['share'],
		'texts'        => array('credit' => $_W['shopset']['trade']['credittext'], 'money' => $_W['shopset']['trade']['moneytext']),
		'isclose'      => $_W['shopset']['app']['isclose'],
		'force_auth'   => isset($_W['shopset']['app']['force_auth']) ? $_W['shopset']['app']['force_auth'] : 0
	);
	$ret['sysset']['share']['logo'] = tomedia($ret['sysset']['share']['logo']);
	$ret['sysset']['share']['icon'] = tomedia($ret['sysset']['share']['icon']);
	$ret['sysset']['share']['followqrcode'] = tomedia($ret['sysset']['share']['followqrcode']);

	if (!empty($_W['shopset']['app']['isclose'])) {
		$ret['sysset']['closetext'] = $_W['shopset']['app']['closetext'];
	}

	return exit(json_encode(array_merge($ret, $result)));
}

function jsonFormat($data, $indent = NULL)
{
	array_walk_recursive($data, 'jsonFormatProtect');
	$data = json_encode($data);
	$data = urldecode($data);
	$ret = '';
	$pos = 0;
	$length = strlen($data);
	$indent = isset($indent) ? $indent : '    ';
	$newline = '
';
	$prevchar = '';
	$outofquotes = true;
	$i = 0;

	while ($i <= $length) {
		$char = substr($data, $i, 1);
		if ($char == '"' && $prevchar != '\\') {
			$outofquotes = !$outofquotes;
		}
		else {
			if (($char == '}' || $char == ']') && $outofquotes) {
				$ret .= $newline;
				--$pos;
				$j = 0;

				while ($j < $pos) {
					$ret .= $indent;
					++$j;
				}
			}
		}

		$ret .= $char;
		if (($char == ',' || $char == '{' || $char == '[') && $outofquotes) {
			$ret .= $newline;
			if ($char == '{' || $char == '[') {
				++$pos;
			}

			$j = 0;

			while ($j < $pos) {
				$ret .= $indent;
				++$j;
			}
		}

		$prevchar = $char;
		++$i;
	}

	return $ret;
}

function jsonFormatProtect(&$val)
{
	if ($val !== true && $val !== false && $val !== NULL) {
		$val = urlencode($val);
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/error_code.php';
$iswxapp = false;
$openid = '';
class AppMobilePage extends PluginMobilePage
{
	protected $member;
	protected $iswxapp = false;
	protected $authkey = '';
	protected $expire = 0;
	public function __construct()
	{
		global $_GPC;
		global $_W;
		global $iswxapp;
		global $openid;
		$this->model = m('plugin')->loadModel($GLOBALS['_W']['plugin']);
		$this->set = $this->model->getSet();

		$this->checkToken();

		if ($_GPC['r'] != 'app.cacheset' && strexists($_GPC['openid'], 'sns_wa') || isset($_GPC['comefrom']) && $_GPC['comefrom'] == 'wxapp') {
			$iswxapp = true;
			$this->iswxapp = true;
		}
		if(!empty($_GPC['__input'])){
			foreach ($_GPC['__input'] as $key=>$val) $_GPC[$key] = $val;
			unset($_GPC['__input']);
		}
	}

    //验证token有效性和用户信息
	public function checkToken(){
		global $_W,$_GPC;
        $this->authkey = $_W['setting']['site']['token'] . '_' . $_W['uniacid'];
        $this->expire = 3600 * 24 * 30;
		$token = !empty($_SERVER['HTTP_AUTHORIZATION'])?$_SERVER['HTTP_AUTHORIZATION']:$_GPC['token'];
        $tokenResult = authcode(base64_decode($token), 'DECODE', $this->authkey, $this->expire);
		if(empty($tokenResult)) return app_error(AppError::$UserTokenFail);
        $tokenResult = explode('|',$tokenResult);
        $member_id = $tokenResult[0];
        $openid = pdo_getcolumn('ewei_shop_member',['id'=>$member_id],'openid');
        $this->member = m('member')->getMember($openid);
        $GLOBALS['_W']['openid'] = $_W['openid'] = $_GPC['openid'] = $this->member['openid'];
	}

	public function logging($message = '')
	{
		$filename = IA_ROOT . '/data/logs/' . date('Ymd') . '.php';
		load()->func('file');
		mkdirs(dirname($filename));
		$content = date('Y-m-d H:i:s') . ' 
------------
';
		if (is_string($message) && !in_array($message, array('post', 'get'))) {
			$content .= 'String:
' . $message . '
';
		}

		if (is_array($message)) {
			$content .= 'Array:
';

			foreach ($message as $key => $value) {
				$content .= sprintf('%s : %s ;
', $key, $value);
			}
		}

		if ($message === 'get') {
			$content .= 'GET:
';

			foreach ($_GET as $key => $value) {
				$content .= sprintf('%s : %s ;
', $key, $value);
			}
		}

		if ($message === 'post') {
			$content .= 'POST:
';

			foreach ($_POST as $key => $value) {
				$content .= sprintf('%s : %s ;
', $key, $value);
			}
		}

		$content .= '
';
		$filename = IA_ROOT . '/data/logs/' . date('Ymd') . '.log';
		$fp = fopen($filename, 'a+');
		fwrite($fp, $content);
		fclose($fp);
	}

	/**
     * 检测绑定Uniacid
     */
	private function checkUniacid()
	{
		global $_W;
		global $_GPC;

		if (empty($_GPC['formwe7'])) {
		}

		$bind = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_bind') . ' WHERE wxapp=:wxapp LIMIT 1', array(':wxapp' => $_W['uniacid']));

		if (!empty($bind)) {
			$GLOBALS['_W']['uniacid'] = $GLOBALS['_W']['acid'] = $bind['uniacid'];
		}
	}
}

?>
