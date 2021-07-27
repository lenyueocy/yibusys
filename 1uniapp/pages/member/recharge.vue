<template>
	<view>
		<view class="padding-xl bg-white">
			<view class="text-xl">充值金额</view>
			<view class="flex flex-wrap text-xl align-center" style="font-size: 60rpx;margin-top: 100rpx;">
				<text>¥</text>
				<view class="basis-xl margin-left-sm">
					<input style="font-size: 80rpx;height:90rpx;" type="digit" placeholder="0.00" v-model="money" @input="checkFloatInput" />
				</view>
			</view>
		</view>
		<view class="bg-white margin-top-sm ">
			<view class="padding-tb-lg padding-lr-sm" style="color: #999;">请选择充值方式</view>
			<view class="padding-tb-sm">
				<tui-list-cell unlined v-if="listData.wechat && listData.wechat.success">
					<label class="tui-pay-item">
						<image src="http://appstore.bai918.com/static/app/icon/pay/weixin.png" class="tui-pay-logo"></image>
						<text class="margin-left-sm">微信支付</text>
						<view class="tui-radio">
							<radio-group @change="payTypeChange">
								<radio color="#EB0909" value="wechat" :checked="payType=='wechat'"></radio>
							</radio-group>
						</view>
					</label>
				</tui-list-cell>
				<tui-list-cell unlined v-if="listData.alipay && listData.alipay.success">
					<label class="tui-pay-item">
						<image src="http://appstore.bai918.com/static/app/icon/pay/zhifubao.png" class="tui-pay-logo"></image>
						<text class="margin-left-sm">支付宝支付</text>
						<view class="tui-radio">
							<radio-group @change="payTypeChange">
								<radio color="#EB0909" value="alipay" :checked="payType=='alipay'"></radio>
							</radio-group>
						</view>
					</label>
				</tui-list-cell>
			</view>
		</view>

		<view class="margin-top-xl padding-lr-lg text-center">
			<!--<u-button @click="submit" :plain="false" shape="circle" size="default" type="error" >确定充值</u-button>-->
			<u-button @click="submit" shape="circle" size="medium"  type="error" :custom-style="customStyle">确定充值</u-button>
		</view>
	</view>
</template>

<script>
	export default{
        data() {
            return {
                listData:'',
                payType: false,
                money: '',
                customStyle:{
                    width:'90%',
					height:'90rpx',
                    boxShadow:'0rpx 0rpx 13rpx 0rpx rgba(255, 28, 80, 0.35)',
				},
            };
        },
        onLoad(){
			this.getList()
        },
        methods: {
            getList:function () {
                this.$http.get('member.recharge').then((res)=>{
                    this.listData = res
                })
            },
            payTypeChange(e){
                this.payType = e.detail.value
            },
			submit:function () {
				if(!this.money || this.money=='' || this.money==' ' || this.money==0){
				    this.$utils.toast('请输入正确的充值金额');
				    return;
				}
				if(['wechat','alipay'].indexOf(this.payType)<0){
                    this.$utils.toast('请选择支付方式');
                    return;
				}
				this.$http.get('member.recharge.submit',{money:this.money,type:this.payType}).then((res)=>{
                    if(res.error==0){
                        this.actionPay(this.payType,res)
					}
				})
            },
			actionPay:function (type,result) {
                switch (type){
                    case 'wechat':
						if(!result.wechat || !result.wechat.payinfo){
                            this.$utils.toast('支付失败,参数错误')
							return;
						}
                        this.$utils.weixinPay(result.wechat.payinfo).then((res)=>{
						    //this.$utils.toast('充值成功')
							//setTimeout(()=>{this.$Router.back()},1500)
							this.checkRechargeStatus(result.logid)
						}).catch((err)=>{
						    console.log(err)
                            this.$utils.toast('充值失败')
						});
					    break;
					default:
					    break;
				}
            },
			checkRechargeStatus:function (logid) {
                let timer = false
                timer = setInterval(()=>{
				    this.$http.get('member.recharge.getstatus',{logid,logid}).then((res)=>{
						if(res.status===true){
						    this.$utils.toast('充值成功')
                            clearInterval(timer)
                            setTimeout(()=>{this.$Router.back()},1500)
						}
					})
				},1000)
            },
            checkFloatInput:function (e) {
				this.$nextTick(()=>{this.money = this.$utils.checkFloatInput(e)})
            }
        }
	}
</script>

<style lang="scss">
	uni-radio-group{
		display: block;
	}
	.tui-pay-item__title {
		width: 100%;
		height: 90rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-amuont {
		color: #eb0909;
		font-weight: 500;
		font-size: 34rpx;
	}

	.tui-pay-item {
		width: 100%;
		height: 80rpx;
		display: flex;
		align-items: center;
		padding: 0 0rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-logo {
		width: 70rpx;
		height: 70rpx;
		margin-right: 15rpx;
	}

	.tui-radio {
		margin-left: auto;
		transform: scale(0.9);
		transform-origin: 100% center;
	}

	.tui-btn-pay {
		width: 100%;
		padding: 68rpx 35rpx 50rpx 35rpx;
		box-sizing: border-box;
	}

</style>
