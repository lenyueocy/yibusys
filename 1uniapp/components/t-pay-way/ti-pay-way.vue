<template>
	<view>
		<tui-bottom-popup :show="show" @close="close" :zIndex="999">

			<!--<tui-list-cell :hover="false">
				<view>
					<text class="lg text-gray cuIcon-roundclose"></text>
				</view>
			</tui-list-cell>-->

			<tui-list-cell :hover="false">
				<view style="position: absolute;right: 2%;top: 8%;">
					<text @click="close" class="text-gray cuIcon-roundclosefill" style="font-size: 50rpx;;"></text>
				</view>
				<view class="tui-pay-item__title">
					<!--<view>请选择支付方式</view>-->
					<view>支付金额：<text class="tui-pay-amuont text-price">{{payInfo.order.price||0}}</text></view>
				</view>
			</tui-list-cell>

			<tui-list-cell unlined v-if="payInfo.credit && payInfo.credit.success">
				<label class="tui-pay-item">
					<image src="http://appstore.bai918.com/static/app/icon/pay/balance.png" class="tui-pay-logo"></image>
					<text v-if="parseFloat(payInfo.credit.current) >= parseFloat(payInfo.order.price)">余额支付（余额:{{payInfo.credit.current}}元）</text>
					<text v-else>余额支付（余额:{{payInfo.credit.current}}元，余额不足）</text>
					<view v-if="parseFloat(payInfo.credit.current) >= parseFloat(payInfo.order.price)" class="tui-radio">
						<radio-group @change="payTypeChange">
							<radio color="#EB0909" value="credit" :checked="payType=='credit'"></radio>
						</radio-group>
					</view>
					<view @click="$Router.push({name:'member_wallet_index'})" class="tui-recharge" v-else>去充值</view>
				</label>
			</tui-list-cell>

			<tui-list-cell unlined v-if="payInfo.wechat && payInfo.wechat.success">
				<label class="tui-pay-item">
					<image src="http://appstore.bai918.com/static/app/icon/pay/weixin.png" class="tui-pay-logo"></image>
					<text>微信支付</text>
					<view class="tui-radio">
						<radio-group @change="payTypeChange">
							<radio color="#EB0909" value="wechat" :checked="payType=='wechat'"></radio>
						</radio-group>
					</view>
				</label>
			</tui-list-cell>
			<tui-list-cell unlined v-if="payInfo.alipay && payInfo.alipay.success">
				<label class="tui-pay-item">
					<image src="http://appstore.bai918.com/static/app/icon/pay/zhifubao.png" class="tui-pay-logo"></image>
					<text>支付宝支付</text>
					<view class="tui-radio">
						<radio-group @change="payTypeChange">
							<radio color="#EB0909" value="alipay" :checked="payType=='alipay'"></radio>
						</radio-group>
					</view>
				</label>
			</tui-list-cell>

			<view class="tui-btn-pay">
				<tui-button height="88rpx" type="danger" shape="circle" shadow @click="btnPay">去付款</tui-button>
			</view>
		</tui-bottom-popup>
	</view>
</template>

<script>
	export default {
		name: 'tPayWay',
		props: {
			//控制显示
			show: {
				type: Boolean,
				default: false
			},
            money:{
                type: String,
                default: '0.00'
			},
            credit:{
                type: String,
                default: '0.00'
			},
			page:{
				type:Number,
				default:1
			},
            payInfo:{
			    type:Object,
				default:{
				    order:{id:0,ordersn:'',price:'0.00',title:'订单'},
                    credit:{success:false,current:'0.00'},
                    wechat:{success:false},
                    alipay:{success:false},
				}
			}
		},
		data() {
			return {
                payType:false
			};
		},
		onLoad(){
			//this.getList()
		},
		methods: {
			close() {
				this.$emit("close",{})
			},
			btnPay(){
                this.$emit("payment",{type:this.payType})
			},
            payTypeChange(e){
				this.payType = e.detail.value
			}
		}
	}
</script>

<style scoped>
	uni-radio-group{
		display: block;
	}

	.tui-bottom-popup{
		z-index: 9999 !important;
	}

	.tui-pay-item__title {
		width: 100%;
		height: 90rpx;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 0 45rpx 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-amuont {
		color: #eb0909;
		font-weight: bold;
		font-size: 45rpx;
	}

	.tui-pay-item {
		width: 100%;
		height: 80rpx;
		display: flex;
		align-items: center;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-logo {
		width: 48rpx;
		height: 48rpx;
		margin-right: 15rpx;
	}

	.tui-radio {
		margin-left: auto;
		transform: scale(0.8);
		transform-origin: 100% center;
	}

	.tui-btn-pay {
		width: 100%;
		padding: 68rpx 35rpx 50rpx 35rpx;
		box-sizing: border-box;
	}

	.tui-recharge {
		color: #fc872d;
		margin-left: auto;
		padding: 12rpx 0;
	}
</style>
