<template>
	<view class="app">
		<view class="price-box">
			<text>支付金额</text>
			<text class="price">{{orderInfo.price?orderInfo.price:'0.00'}}</text>
		</view>
		<view v-if="0" class="text-center margin-top-lg text-gery">订单号：{{orderInfo.ordersn}}</view>
		<tui-list-view unlined="all" class="pay-type-list" title="请选择支付方式" style="background-color: #f6f6f6;" >

			<tui-list-cell v-if="payInfo.alipay.success" @click="changePayType('alipay')" class="type-item b-b" :arrow="false" padding="30rpx 50rpx">
				<tui-icon name="alipay" :size="45" color="#01aaef"></tui-icon>
				<view class="con margin-left-sml">
					<text class="tit">支付宝支付</text>
					<text class="margin-top-sm">推荐使用支付宝支付</text>
				</view>
				<label class="radio">
					<radio value="" color="#fa436a" :checked="payType == 'alipay'" />
				</label>
			</tui-list-cell>
			<tui-list-cell v-if="payInfo.wechat.success" @click="changePayType('wechat')" class="type-item b-b" :arrow="false" padding="30rpx 50rpx">
				<tui-icon name="wechat" :size="45" color="#36cb59"></tui-icon>
				<view class="con margin-left-sml">
					<text class="tit">微信支付</text>
				</view>
				<label class="radio">
					<radio value="" color="#fa436a" :checked="payType == 'wechat'" />
				</label>
			</tui-list-cell>
			<tui-list-cell v-if="payInfo.credit.success" @click="changePayType('credit')" class="type-item b-b" :arrow="false" padding="30rpx 50rpx">
				<tui-icon name="wealth-fill" :size="45" color="#fe8e2e"></tui-icon>
				<view class="con margin-left-sml">
					<text class="tit">余额支付</text>
					<view class="margin-top-sm">
						<text>可用余额</text>
						<text class="text-price margin-left-xs">{{payInfo.credit.current}}</text>
					</view>
				</view>
				<label class="radio">
					<radio value="" color="#fa436a" :checked="payType == 'credit'" />
				</label>
			</tui-list-cell>


		</tui-list-view>

		<tui-button margin="80rpx auto" width="90%" height="88rpx" type="mix" shadow :disabled="!payType" @click="submit" >确认支付</tui-button><!--disabledGray-->

		<view class="pay-type-list" v-if="0">

			<view class="type-item b-b" @click="changePayType(2)">
				<text class="icon yticon icon-alipay"></text>
				<view class="con">
					<text class="tit">支付宝支付</text>
				</view>
				<label class="radio">
					<radio value="" color="#fa436a" :checked='payType == 2' />
				</label>
			</view>
			<view class="type-item" @click="changePayType(3)">
				<text class="icon yticon icon-erjiye-yucunkuan"></text>
				<view class="con">
					<text class="tit">预存款支付</text>
					<text>可用余额 ¥198.5</text>
				</view>
				<label class="radio">
					<radio value="" color="#fa436a" :checked='payType == 3' />
				</label>
			</view>
		</view>

		<tui-modal :show="alertModal" :custom="true">
			<view class="tui-modal-custom">
				<image src="/static/images/chat/fail.png" class="tui-tips-img"></image>
				<view class="tui-modal-custom-text">订单数据错误!</view>
				<tui-button height="72rpx" :size="28" type="danger" shape="circle" @click="alertClose">确定</tui-button>
			</view>
		</tui-modal>

	</view>
</template>

<script>

    export default {
        data() {
            return {
                payType: '',
                payInfo: {
                    credit:{success:true,current:'0.00'},
                    alipay:{success:true},
                    wechat:{success:true},
				},
                orderInfo: {price:'0.00'},
				alertModal:false,
            };
        },
        computed: {

        },
        onLoad() {
            if(!this.$Route.query.type) this.alertModal = true
            else this.getList()
        },
        methods: {
            getList(){
                this.$http.get(this.$Route.query.type+'.pay',{id:this.$Route.query.orderid}).then((res)=>{
					this.payInfo = res
					this.orderInfo = res.order
				})
			},
            alertClose(){
                this.alertModal = false
				setTimeout(()=>{
                    this.$Router.back()
				},300)

			},
            changePayType(type) {
                this.payType = type;
            },
            submit(){
				if(!this.payType){
				    this.$utils.toast('请选择支付方式')
					return false;
				}
                switch (this.payType){
                    case 'credit':
                        this.$http.get(this.$Route.query.type+'.pay.complete',{id:this.orderInfo.id,type:this.payType}).then((res)=>{
                            if(res.error==0){
								this.$Router.push({name:'order_pay_result',params:{orderid:this.orderInfo.id,type:this.$Route.query.type}})
                            }else{
                                this.$utils.toast('支付出错,请稍后重试')
                            }
                        })
                        break;
                    case 'wechat':
                        if(!this.payInfo.wechat || !this.payInfo.wechat.payinfo){
                            this.$utils.toast('支付失败,参数错误')
                            return;
                        }
                        this.$utils.weixinPay(this.payInfo.wechat.payinfo).then((res)=>{
                            if(res!==false){
                                this.$utils.toast('支付成功')
                                this.showPayment = false
                                this.luckybagModal = true
                            }else{
                                this.loadModal = true
                                this.checkPayStatus(this.payInfo.order.id)
                            }
                        }).catch((err)=>{
                            this.$utils.toast('支付失败')
                        });
                        break;
                    default:
                        this.$utils.toast('请先选择支付方式')
                        return;
                        break;
                }
			}
        }
    }
</script>

<style lang='scss'>
	page{
		background-color: #fff;
	}

	.tui-modal-custom {
		text-align: center;
	}
	.tui-tips-img {
		width: 80rpx;
		height: 80rpx;
		margin-top: 20rpx;
	}

	.tui-modal-custom-text {
		font-size: 30rpx;
		color: #333;
		padding: 30rpx 0 50rpx;
	}

	.price-box {
		background-color: #fff;
		height: 265upx;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		font-size: 28upx;
		color: #909399;
		.price{
			font-size: 50upx;
			color: #303133;
			margin-top: 12upx;
			&:before{
				content: '￥';
				font-size: 40upx;
			}
		}
	}

	.pay-type-list {
		margin-top: 20upx;
		background-color: #fff;

		.type-item{
			padding: 20upx 0;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding-right: 60upx;
			font-size: 30upx;
			position:relative;
		}

		.icon{
			width: 100upx;
			font-size: 52upx;
		}
		.icon-erjiye-yucunkuan {
			color: #fe8e2e;
		}
		.icon-weixinzhifu {
			color: #36cb59;
		}
		.icon-alipay {
			color: #01aaef;
		}
		.tit{
			font-size: $font-lg;
			color: $font-color-dark;
			margin-bottom: 4upx;
		}
		.con{
			flex: 1;
			display: flex;
			flex-direction: column;
			font-size: $font-sm;
			color: $font-color-light;
		}
	}
	.mix-btn {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 88%;
		height: 80upx;
		margin: 80upx auto 30upx;
		font-size: $font-lg;
		color: #fff;
		background-color: $base-color;
		border-radius: 10upx;
		box-shadow: 1px 2px 5px rgba(219, 63, 96, 0.4);
	}
	/*     */
	.tui-item-box {
		width: 100%;
		display: flex;
		align-items: center;
	}

	.tui-list-cell_name {
		display: flex;
		align-items: center;
		justify-content: center;
		color: #303133;
		font-size: 32rpx;
	}

	.tui-ml-auto {
		margin-left: auto;
	}

	.tui-right {
		margin-left: auto;
		margin-right: 34rpx;
		font-size: 26rpx;
		color: #999;
	}

	.tui-msg-box {
		display: flex;
		align-items: center;
	}

	.tui-msg-pic {
		width: 120rpx;
		height: 120rpx;
		border-radius: 10rpx;
		display: block;
		margin-right: 24rpx;
		flex-shrink: 0;
	}

	.tui-msg-item {
		max-width: 500rpx;
		min-height: 80rpx;
		height: 100%;
		overflow: hidden;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.tui-msg-name {
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		font-size: 32rpx;
		line-height: 1;
		color: #262b3a;
	}

	.tui-msg-content {
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		margin-top: 35rpx;
		color: #9397a4;
	}

	.tui-msg-right {
		max-width: 120rpx;
		height: 88rpx;
		margin-left: auto;
		text-align: right;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		align-items: flex-end;
	}
	﻿.radio-group {
		margin-left: auto;
		transform: scale(0.8);
		transform-origin: 100% center;
		flex-shrink: 0;
	}

	.tui-radio {
		display: inline-block;
		padding-left: 28rpx;
		font-size: 36rpx;
		vertical-align: middle;
	}

</style>
