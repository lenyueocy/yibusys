<template>
	<view class="container">
		<view class="tui-order-header" @tap="switchStatus">
			<!-- <image :src="webURL+'img_detail_bg.png'" mode="widthFix" class="tui-img-bg"></image> -->
			<view class="tui-header-content">
				<view>
					<view class="tui-status-text" v-if="listData.status==0">待付款</view><!--<text class="text-price margin-left-sm">{{listData.price}}</text>-->
					<view class="tui-status-text" v-if="listData.status==1">待发货</view>
					<view class="tui-status-text" v-if="listData.status==2">待收货</view>
					<view class="tui-status-text" v-if="listData.status==3">订单已完成</view>
					<view class="tui-status-text" v-if="listData.status==-1">交易关闭</view>
					<view class="tui-reason" v-if="listData.status==0"><text class="tui-reason-text text-white padding-top-sm">还差一步就下单成功咯！</text></view>
					<view class="tui-reason" v-if="listData.status==1"><text class="tui-reason-text text-white padding-top-sm">你的包裹正在出库！</text></view>
					<view class="tui-reason" v-if="listData.status==2"><text class="tui-reason-text text-white padding-top-sm">你期待的商品已经向你飞奔过来咯！</text></view>
					<view class="tui-reason" v-if="listData.status==3"><text class="tui-reason-text text-white padding-top-sm">交易完成，祝您生活愉快！</text></view>
				</view>
				<image v-if="listData.status==0" src="https://www.thorui.cn/wx/static/images/mall/order/img_order_payment3x.png" class="tui-status-img" mode="widthFix"></image>
				<image v-if="listData.status==1" src="https://www.thorui.cn/wx/static/images/mall/order/img_order_send3x.png" class="tui-status-img" mode="widthFix"></image>
				<image v-if="listData.status==2" src="https://www.thorui.cn/wx/static/images/mall/order/img_order_signed3x.png" class="tui-status-img" mode="widthFix"></image>
				<image v-if="listData.status==3" src="https://www.thorui.cn/wx/static/images/mall/order/img_order_received3x.png" class="tui-status-img" mode="widthFix"></image>
				<image v-if="listData.status==-1" src="https://www.thorui.cn/wx/static/images/mall/order/img_order_closed3x.png" class="tui-status-img" mode="widthFix"></image>
			</view>
		</view>

		<tui-list-cell v-if="listData.status>1" arrow backgroundColor="#fefefe" @click="navTo('/pages/order/express',{orderid:orderData.id})" style="border-radius: 22rpx 22rpx 0 0;">
			<view class="tui-flex-box">
				<image :src="webURL+'img_order_logistics3x.png'" class="tui-icon-img"></image>
				<view class="tui-logistics" v-if="express">
					<view class="tui-logistics-text">{{express.step}}</view>
					<view class="tui-logistics-time">{{express.time}}</view>
				</view>
				<view class="tui-logistics" v-else>
					<view class="tui-logistics-text">暂无物流信息</view>
					<view class="tui-logistics-time">暂无更新时间</view>
				</view>
			</view>
		</tui-list-cell>

		<tui-list-cell unlined :hover="false" :style="{'border-radius':listData.status<2?'22rpx 22rpx 0 0':''}">
			<view class="tui-flex-box">
				<image :src="webURL+'img_order_address3x.png'" class="tui-icon-img"></image>
				<view class="tui-addr">
					<view class="tui-addr-userinfo">{{address.realname}}<text class="tui-addr-tel text-sm">{{address.mobile}}</text></view>
					<view class="tui-addr-text">{{address.province}}{{address.city}}{{address.area}} {{address.address}}</view>
				</view>
			</view>
			<view class="tui-bg-img"></view>
		</tui-list-cell>

		<view class="tui-order-item">
			<tui-list-cell :hover="false" :lineLeft="false">
				<view class="tui-goods-title">
					商品信息
				</view>
			</tui-list-cell>
			<block v-for="(item,index) in goods" :key="index">
				<tui-list-cell @tap="navTo('/pages/goods/detail',{id:item.id})" padding="0">
					<view class="tui-goods-item">
						<image :src="item.thumb" class="tui-goods-img"></image>
						<view class="tui-goods-center flex justify-between">
							<view class="tui-goods-name">{{item.title}}</view>
							<view class="tui-goods-attr">{{item.optionname}}</view>
						</view>
						<view class="tui-price-right flex justify-between">
							<view>￥{{item.price}}</view>
							<view>x{{item.total}}</view>
						</view>
					</view>
				</tui-list-cell>
			</block>
			<view class="tui-goods-info">
				<view class="tui-price-flex tui-size24">
					<view>商品小计</view>
					<view>￥{{listData.goodsprice}}</view>
				</view>
				<view class="tui-price-flex  tui-size24">
					<view>运费</view>
					<view>￥{{orderData.dispatchprice}}</view>
				</view>
				<view class="tui-price-flex tui-size28">
					<view class="tui-flex-shrink">实付款</view>
					<view class="tui-goods-price tui-primary-color">
						<view class="tui-size-24">￥</view>
						<view class="tui-price-large">{{listData.price||0}}</view>
					</view>
				</view>
			</view>
		</view>

		<view class="tui-order-info">
			<tui-list-cell :hover="false">
				<view class="tui-order-title">
					订单信息
				</view>
			</tui-list-cell>
			<view class="tui-order-content">
				<view class="tui-order-flex">
					<view class="tui-item-title">订单编号:</view>
					<view class="tui-item-content">{{listData.ordersn}}</view>
				</view>
				<view class="tui-order-flex">
					<view class="tui-item-title">提交时间:</view>
					<view class="tui-item-content">{{listData.createtime}}</view>
				</view>
				<view class="tui-order-flex" v-if="listData.status>0">
					<view class="tui-item-title">支付时间:</view>
					<view class="tui-item-content">{{listData.paytime}}</view>
				</view>
				<view class="tui-order-flex" v-if="listData.status>0">
					<view class="tui-item-title">支付方式:</view>
					<view class="tui-item-content">{{listData.paytypestr}}</view>
				</view>
				<view class="tui-order-flex">
					<view class="tui-item-title">支付状态:</view>
					<view class="tui-item-content" style="color: #ff0960;">{{listData.statusstr}}</view>
				</view>
				<view class="tui-order-flex" v-if="listData.status>1">
					<view class="tui-item-title">发货时间:</view>
					<view class="tui-item-content">{{listData.sendtime}}</view>
				</view>
				<view class="tui-order-flex">
					<view class="tui-item-title">订单备注:</view>
					<view class="tui-item-content">{{listData.ramark}}</view>
				</view>
			</view>
		</view>
		<view class="tui-safe-area"></view>
		<view class="tui-tabbar tui-order-btn">
			<view class="tui-btn-mr" v-if="listData.status==1 && 0">
				<tui-button @click="navTo('/pages/order/refund/index',{id:listData.id})" type="black" :plain="true" width="152rpx" height="56rpx" :size="26" shape="circle">申请退款</tui-button>
			</view>
			<view class="tui-btn-mr" v-if="listData.status>=2 && 0">
				<tui-button @click="navTo('/pages/order/refund/index',{id:listData.id})" type="black" :plain="true" width="152rpx" height="56rpx" :size="26" shape="circle">申请售后</tui-button>
			</view>

			<view class="tui-btn-mr" v-if="listData.status>1">
				<tui-button type="black" :plain="true" width="152rpx" height="56rpx" :size="26" shape="circle" @click="navTo('/pages/logistics/index',{ordersn:orderData.ordersn,expresscom:orderData.expresscom,express:orderData.express,expresssn:orderData.expresssn})">查看物流</tui-button>
			</view>

			<view class="tui-btn-mr" v-if="listData.status>2 || listData.status==-1">
				<tui-button type="black" :plain="true" width="152rpx" height="56rpx" :size="26" shape="circle">删除订单</tui-button>
			</view>
			<view class="tui-btn-mr" v-if="listData.status==0">
				<tui-button type="danger" width="152rpx" height="56rpx" :size="26" shape="circle" @click="actionPay($Route.query.id)">立即支付</tui-button>
			</view>
			<view class="tui-btn-mr" v-if="listData.status==2">
				<tui-button type="danger" width="152rpx" height="56rpx" :size="26" shape="circle" @click="takeDelivery">确认收货</tui-button>
			</view>
		</view>
		<t-pay-way v-if="payInfo" :payInfo="payInfo" :show="showPayment" @close="paymentClose" @payment="payment"></t-pay-way>
		<!-- lenyue注释 -->
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>
	</view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
	import tPayWay from "@/components/t-pay-way/ti-pay-way"
	export default {
		components: {
			tPayWay
		},
        computed:{
            ...mapState(['modalAction']),
        },
		data() {
			return {
				webURL: "https://www.thorui.cn/wx/static/images/mall/order/",
				//1-待付款 2-付款成功 3-待收货 4-订单已完成 5-交易关闭
				status: 1,
                showPayment: false,
				goods: '',
				listData: '',
                orderData: '',
                express: '',
				address: '',
                payInfo:'',
                credit: 0,
				statusTimer: false,
			}
		},
		onLoad(){
		    this.getList()
		},
		onShow(){
		    if(this.$Route.query.listener) this.statusTimer = setInterval(()=>{this.getList()},1000)
		},
		methods: {
		    getList:function () {
		        if(!this.$Route.query.id){
		            this.$utils.toast('参数错误')
                    clearInterval(this.statusTimer)
					setTimeout(()=>{this.$Router.back()},1500)
					return;
				}
				this.$http.get('order.detail',{id:this.$Route.query.id}).then((res)=>{
				    this.listData = res.order
				    this.goods = res.goods
				    this.address = res.address
				    this.orderData = res.order
				    this.express = res.express
					if(this.$Route.query.listener && res.order.status!=1) clearInterval(this.statusTimer)
				})
            },
            takeDelivery:function () {
                this.$utils.modal.confirm('确认完成收货？').then((res)=>{
                    this.$http.get('order.confirm_receipt',{orderid:this.listData.id}).then((res)=>{
                        this.$set(this.listData,'status',3)
                    })
                })
            },
            actionPay:function (orderid) {
                if(!this.$Route.query.id){
                    this.$utils.toast('参数错误')
                    setTimeout(()=>{this.$Router.back()},1500)
                    return;
                }
                this.$http.get('order.pay',{id:orderid}).then((res)=>{
                    this.payInfo = res
                    this.credit = res.credit.current
                    this.showPayment = true
                })
            },
            paymentClose:function () {
                this.$utils.modal.confirm('确定取消支付吗？').then((res)=>{
                    this.showPayment = false
                })
            },
            payment:function (params) {
                switch (params.type){
                    case 'credit':
                        this.$http.get('order.pay.complete',{id:this.payInfo.order.id,type:params.type}).then((res)=>{
                            if(res.error==0){
                                this.$utils.toast('支付成功')
                                this.showPayment = false
                                this.downCallback()
                                if(res!==false) this.$Router.push({path:'/pages/order/pay/result',query:{type:'order',orderid:this.payInfo.order.id}})
                                //setTimeout(()=>{this.$Router.push({path:'/pages/order/detail',query:{id:this.payInfo.order.id}})},1500)
                            }else{
                                this.$utils.toast('支付出错')
                            }
                        })
                        break;
                    case 'wechat':
                        //h5 公众号 小程序支付 app支付-需要新开web页面
                        this.$utils.weixinPay(this.payInfo.wechat.payinfo).then((res)=>{
                            if(res!==false) this.$utils.toast('支付成功')
                            this.showPayment = false
                            this.downCallback()
                            if(res!==false) this.$Router.push({path:'/pages/order/pay/result',query:{type:'order',orderid:this.payInfo.order.id}})
                            else setTimeout(()=>{this.$Router.push({path:'/pages/order/detail',query:{id:this.payInfo.order.id,listener:true}})},1500)
                        }).catch((err)=>{
                            this.$utils.toast('支付失败')
                        });
                        break;
                    default:
                        this.$utils.toast('请先选择支付方式')
                        return;
                        break;
                }
            },
            navTo:function (url,params) {
                params = params||{}
                let tabArr = ['/pages/index/index','/pages/tabbar/integralmall','/pages/tabbar/luckybag','/pages/tabbar/cart','/pages/member/index']
                if(tabArr.indexOf(url)>=0) this.$Router.pushTab({path:url})
                else this.$Router.push({path:url,query:params})
            },
			btnPay() {
				this.show = true
			},
			popupClose() {
				this.show = false
			}
		}
	}
</script>

<style>
	.container {
		padding-bottom: 118rpx;
	}
	.tui-bg-img {
		position: absolute;
		width: 100%;
		height: 4rpx;
		left: 0;
		bottom: 0;
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAAFCAYAAAAaAWmiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Rjk3RjkzMjM2NzMxMTFFOUI4RkU4OEZGMDcxQzgzOEYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Rjk3RjkzMjQ2NzMxMTFFOUI4RkU4OEZGMDcxQzgzOEYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGOTdGOTMyMTY3MzExMUU5QjhGRTg4RkYwNzFDODM4RiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGOTdGOTMyMjY3MzExMUU5QjhGRTg4RkYwNzFDODM4RiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PrEOZlQAAAiuSURBVHjazJp7bFvV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") no-repeat;
		background-size: 100% 100%;
	}
	.tui-order-header {
		width: 100%;
		height: 300rpx;
		position: relative;
		margin-bottom: -100rpx;
		background-color: #ff0960;
	}

	.tui-img-bg {
		width: 100%;
		height: 160rpx;
	}

	.tui-header-content {
		width: 100%;
		height: 160rpx;
		position: absolute;
		z-index: 10;
		left: 0;
		top: 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 10rpx 70rpx 0rpx 70rpx;
		box-sizing: border-box;
	}

	.tui-status-text {
		font-size: 34rpx;
		line-height: 34rpx;
		color: #FEFEFE;
	}

	.tui-reason {
		font-size: 24rpx;
		line-height: 24rpx;
		color: rgba(254, 254, 254, 0.75);
		padding-top: 15rpx;
		display: flex;
		align-items: center;
	}

	.tui-reason-text {
		padding-right: 12rpx;
	}

	.tui-status-img {
		width: 80rpx;
		height: 80rpx;
		display: block;
	}

	.tui-flex-box {
		width: 100%;
		display: flex;
		align-items: center;
	}

	.tui-icon-img {
		width: 44rpx;
		height: 44rpx;
		flex-shrink: 0;
	}

	.tui-logistics {
		display: flex;
		flex-direction: column;
		justify-content: center;
		padding: 0 24rpx 0 20rpx;
		box-sizing: border-box;
	}

	.tui-logistics-text {
		font-size: 26rpx;
		line-height: 32rpx;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.tui-logistics-time {
		font-size: 24rpx;
		line-height: 24rpx;
		padding-top: 16rpx;
		color: #666
	}

	.tui-addr {
		display: flex;
		flex-direction: column;
		justify-content: center;
		padding-left: 20rpx;
		box-sizing: border-box;
	}

	.tui-addr-userinfo {
		font-size: 30rpx;
		line-height: 30rpx;
	}

	.tui-addr-text {
		font-size: 28rpx;
		line-height: 32rpx;
		padding-top: 16rpx;
	}

	.tui-addr-tel {
		padding-left: 40rpx;
	}

	.tui-order-item {
		margin-top: 20rpx;
		border-radius: 10rpx;
		overflow: hidden;
	}

	.tui-goods-title {
		width: 100%;
		font-size: 28rpx;
		line-height: 28rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}


	.tui-goods-item {
		width: 100%;
		padding: 20rpx 30rpx;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
	}

	.tui-goods-img {
		width: 180rpx;
		height: 180rpx;
		display: block;
		flex-shrink: 0;
		border-radius: 10rpx;
	}

	.tui-goods-center {
		flex: 1;
		padding: 20rpx 8rpx;
		box-sizing: border-box;
		display: flex;
		flex-direction: column;
	}

	.tui-goods-name {
		max-width: 310rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		font-size: 26rpx;
		line-height: 32rpx;
	}

	.tui-goods-attr {
		font-size: 22rpx;
		color: #888888;
		line-height: 32rpx;
		padding-top: 20rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.tui-price-right {
		text-align: right;
		font-size: 24rpx;
		color: #888888;
		line-height: 30rpx;
		/*padding-top: 20rpx;*/
		flex-direction: column;
		padding: 20rpx 0rpx 20rpx 8rpx;
	}

	.tui-color-red {
		color: #E41F19;
		padding-right: 30rpx;
	}

	.tui-goods-price {
		width: 100%;
		display: flex;
		align-items: flex-end;
		justify-content: flex-end;
		font-size: 24rpx;
	}

	.tui-size-24 {
		font-size: 24rpx;
		line-height: 24rpx;
	}

	.tui-price-large {
		font-size: 32rpx;
		line-height: 30rpx;
	}

	.tui-goods-info {
		width: 100%;
		padding: 30rpx;
		box-sizing: border-box;
		background: #fff;
	}

	.tui-price-flex {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.tui-size24 {
		padding-bottom: 20rpx;
		font-size: 24rpx;
		line-height: 24rpx;
		color: #888;
	}

	.tui-size32 {
		font-size: 32rpx;
		line-height: 32rpx;
		font-weight: 500;
	}

	.tui-pbtm20 {
		padding-bottom: 20rpx;
	}

	.tui-flex-shrink {
		flex-shrink: 0;
	}

	.tui-primary-color {
		color: #EB0909;
	}

	.tui-order-info {
		margin-top: 20rpx;
	}

	.tui-order-title {
		position: relative;
		font-size: 28rpx;
		line-height: 28rpx;
		padding-left: 12rpx;
		box-sizing: border-box;
	}

	.tui-order-title::before {
		content: '';
		position: absolute;
		left: 0;
		top: 0;
		border-left: 4rpx solid #EB0909;
		height: 100%;
	}

	.tui-order-content {
		width: 100%;
		padding: 24rpx 30rpx;
		box-sizing: border-box;
		background: #fff;
		font-size: 24rpx;
		line-height: 30rpx;
	}

	.tui-order-flex {
		display: flex;
		padding-top: 18rpx;
	}

	.tui-order-flex:first-child {
		padding-top: 0
	}

	.tui-item-title {
		width: 132rpx;
		flex-shrink: 0;
	}

	.tui-item-content {
		color: #666;
		line-height: 32rpx;
	}

	.tui-safe-area {
		height: 1rpx;
		padding-bottom: env(safe-area-inset-bottom);
	}

	.tui-tabbar {
		width: 100%;
		height: 98rpx;
		background: #fff;
		position: fixed;
		left: 0;
		bottom: 0;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		font-size: 26rpx;
		box-shadow: 0 0 1px rgba(0, 0, 0, .3);
		/*padding-bottom: env(safe-area-inset-bottom);*/
		z-index: 996;
	}

	.tui-btn-mr {
		margin-right: 30rpx;
	}
</style>
