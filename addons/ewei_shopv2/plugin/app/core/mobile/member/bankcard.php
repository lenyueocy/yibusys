<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class bankcard_EweiShopV2Page extends AppMobilePage
{
	public function __construct(){
		parent::__construct();
    }

    public function main(){
		global $_W,$_GPC;
		$listData = pdo_getall('ewei_shop_member_bankcard',['openid'=>$_W['openid']]);
        return app_json(['data'=>$listData?:[]]);
	}
	public function add(){
        global $_W,$_GPC;
        $member = $this->member;
        if(empty($_GPC['name'])) return app_error(AppError::$ParamsError,'请输入持卡人');
        if(empty($_GPC['card_no'])) return app_error(AppError::$ParamsError,'请输入银行卡号');
        if(empty($_GPC['card_id']) && $member['is_certification']!=1) return app_error(AppError::$ParamsError,'请输入身份证件号码');
        //if(empty($_GPC['bank_name'])) return app_error(AppError::$ParamsError,'请选择开户银行');
        if(empty($_GPC['bank_branch'])) return app_error(AppError::$ParamsError,'请输入开户支行');
        if(pdo_getcolumn('ewei_shop_member_bankcard',['openid'=>$_W['openid'],'card_no'=>$_GPC['card_no']],'id')) return app_error(AppError::$ParamsError,'该银行卡号已绑定');

        $card_id = $member['is_certification']==1?$member['card_id']:$_GPC['card_id'];
        //银行卡三要素处理
		$result = m('util')->checkBank(['acct_name'=>$_GPC['name'],'acct_pan'=>$_GPC['card_no'],'cert_id'=>$card_id],3);

        /*$result = [
        	'showapi_res_error'=>'',
			'showapi_res_id'=>'5fb263708d57ba227a092b88',
			'showapi_res_code'=>0,
			'showapi_res_body'=>[
                'code'=>0,
                'msg'=>'认证通过',
				'ret_code'=>0,
				'order'=>1605526384615,
				'belong'=>[
					'cardNum'=>6210985631006272074,
					'bankName'=>'邮储银行',
					'cardType'=>'借记卡',
					'brand'=>'绿卡通',
					'area'=>'湖南 - 郴州',
				]
			]
		];
        $result = $result['showapi_res_body'];*/
        if($result['code']==5) return app_error(AppError::$ParamsError,'银行卡号跟持卡人姓名不符');
        if($result['code']!=0) return app_error(AppError::$ParamsError,$result['msg']);
		//如果三要素验证通过 并且已经实名认证 则必须绑定本人身份证号码的银行卡
        $insertData = [
        	'name'=>$_GPC['name'],
        	'card_no'=>$_GPC['card_no'],
        	//'card_id'=>$_GPC['card_id'],
        	'bank_name'=>$result['belong']['bankName'],
        	'bank_branch'=>$_GPC['bank_branch'],
        	'mobile'=>$_GPC['mobile'],
			'openid'=>$_W['openid'],
		];

        if(!empty($result['belong']['cardType'])) $insertData['bank_type'] = $result['belong']['cardType'];
        if(!empty($result['belong']['brand'])) $insertData['bank_brand'] = $result['belong']['brand'];
        if(!empty($result['belong']['area'])) $insertData['bank_area'] = $result['belong']['area'];
        $insertId = pdo_insert('ewei_shop_member_bankcard',$insertData);
        if($insertId){
        	if($member['is_certification']==0) pdo_update('ewei_shop_member',['is_certification'=>1,'card_id'=>$_GPC['card_id'],'realname'=>$_GPC['name']],['openid'=>$_W['openid']]);
        	$message = $member['is_certification']==1?'绑定银行卡成功！':'绑定银行卡成功,恭喜您实名认证通过！';
        	return app_json(['message'=>$message]);
		}
		return app_error();
	}

	public function getBankNameList(){
        global $_W,$_GPC;
        $bankNameList = ['交通银行', '中国光大银行', '中国建设银行', '中国银行', '中国工商银行', '中国农业银行', '中国民生银行','招商银行','中信银行','中国邮政储蓄银行'];
        $member = $this->member;
        return app_json(['bankNameList'=>$bankNameList,'is_certification'=>$member['is_certification']==1?true:false]);
	}
}

?>
