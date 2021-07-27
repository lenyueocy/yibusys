<template>
	<mescroll-uni :ref="'mescrollRef'+i" @init="mescrollInit" height="100%" top="80" :down="downOption" @down="downCallback" :up="upOption" @up="upCallback" @emptyclick="emptyClick">
		<mescroll-empty v-if="!listData[i]"></mescroll-empty>
		<view class="" :class="{'tui-order-list':scrollTop>=0}" v-else>
			<view class="tui-order-item" v-for="(item,listIndex) in listData[i]" :key="listIndex">
				<tui-list-cell @tap="navTo('/pages/order/detail',{id:item.id})" :hover="false" :lineLeft="false">
					<view class="tui-goods-title">
						<view>订单号：{{item.ordersn}}</view>
						<view class="tui-order-status" v-if="item.status==0">等待买家付款</view>
						<view class="tui-order-status" v-if="item.status==1">买家已付款</view>
						<view class="tui-order-status" v-if="item.status==2">卖家已发货</view>
						<view class="tui-order-status" v-if="item.status==3">交易成功</view>
						<view class="tui-order-status" v-if="item.status==-1">交易关闭</view>
					</view>
				</tui-list-cell>
				<block v-for="(goodsItem,goodsIndex) in item.goods[0].goods" :key="index">
					<tui-list-cell @tap="navTo('/pages/order/detail',{id:item.id})" padding="0"><!--@tap="$Router.push({path:'/pages/goods/detail',query:{id:goodsItem.goodsid}})"-->
						<view class="tui-goods-item">
							<image :src="goodsItem.thumb" class="tui-goods-img"></image>
							<view class="tui-goods-center">
								<view class="tui-goods-name">{{goodsItem.title}}</view>
								<view class="tui-goods-attr">{{goodsItem.optiontitle}}</view>
							</view>
							<view class="tui-price-right">
								<view>￥{{goodsItem.price}}</view>
								<view>x{{goodsItem.total}}</view>
							</view>
						</view>
					</tui-list-cell>
				</block>
				<tui-list-cell :hover="false" unlined>
					<view class="tui-goods-price">
						<view>共{{item.goods[0].goods.length}}件商品 合计：</view>
						<view class="tui-size-24">￥</view>
						<view class="tui-price-large">{{item.price}}</view>
						<!--<view class="tui-size-24">.{{(item.price||'0.00').split('.')[1]}}</view>-->
					</view>
				</tui-list-cell>
				<view class="tui-order-btn">

                    <view class="tui-btn-ml" v-if="item.status==1">
                        <tui-button v-if="item.refundstate==1" type="black" plain @tap="$Router.push({name:'order_refund_submit',params:{id:item.id}})" width="152rpx" height="56rpx" :size="26" shape="circle">退款中</tui-button>
                        <tui-button v-else type="black" plain @tap="$Router.push({name:'order_refund_submit',params:{id:item.id}})" width="152rpx" height="56rpx" :size="26" shape="circle">申请退款</tui-button>
                    </view>

					<!--<view class="tui-btn-ml">
						<tui-button @tap="navTo('/pages/order/detail',{id:item.id})" type="black" plain width="152rpx" height="56rpx" :size="26" shape="circle">查看详情</tui-button>
					</view>-->
					<view class="tui-btn-ml" v-if="item.status==0">
						<tui-button @tap="cancel(item.id)" type="black" plain width="152rpx" height="56rpx" :size="26" shape="circle">取消订单</tui-button>
					</view>

					<!--<view class="tui-btn-ml" v-if="item.status>2 || item.status==-1">
						<tui-button type="black" plain width="152rpx" height="56rpx" :size="26" shape="circle">删除订单</tui-button>
					</view>-->

					<view class="tui-btn-ml" v-if="item.status==2">
						<tui-button @tap="takeDelivery(item.id)" type="danger" width="152rpx" height="56rpx" :size="26" shape="circle">确认收货</tui-button>
					</view>
					<view class="tui-btn-ml" v-if="item.status==0">
						<tui-button type="danger" @tap="actionPay(item.id)" width="152rpx" height="56rpx" :size="26" shape="circle">付款</tui-button>
					</view>
					<view class="tui-btn-ml" v-if="item.status==3 && item.iscomment==0">
						<tui-button type="danger" plain @tap="$Router.push({name:'order_comment_submit',params:{id:item.id}})" width="152rpx" height="56rpx" :size="26" shape="circle">评价</tui-button>
					</view>
				</view>
			</view>

			<t-pay-way v-if="(index==0||index==1) && payInfo" :payInfo="payInfo" :show="showPayment" @close="paymentClose" @payment="payment"></t-pay-way>

		</view>
	</mescroll-uni>
</template>

<script>
    import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
    import MescrollMoreItemMixin from "@/components/mescroll-uni/mixins/mescroll-more-item.js";
    import tPayWay from "@/components/t-pay-way/ti-pay-way"
    export default {
        mixins: [MescrollMixin,MescrollMoreItemMixin],
        data() {
            return {
                downOption:{
                    auto:false
                },
                upOption:{
                    auto:false,
                    noMoreSize: 4,
                    empty:{
                        tip: '~ 空空如也 ~',
                        btnText: '去看看'
                    }
                },
                listData: [],
                scrollTop:0,
                payInfo: '',
                credit: 0,
                realprice: 0,
                showPayment:false,
            }
        },
		components: {
            tPayWay
        },
        props:{
            i: Number,
            index: {
                type: Number,
                default(){
                    return 0
                }
            },
            tabs: {
                type: Array,
                default(){
                    return []
                }
            }
        },
        methods: {
            /*mescrollInit(mescroll) {
                this.mescroll = mescroll;
            },*/
            checkPayStatus(){
                console.log('检测支付状态')
			},
            getList:function () {
                let params = {page:this.mescroll.num,pagesize:this.mescroll.size}
				if(this.index>0) params.status = this.index - 1
                this.$http.get('order.get_list',params).then((res)=>{
                    this.mescroll.endBySize(this.mescroll.size, 20);
                    if(this.mescroll.num == 1) this.listData[this.index] = []
                    //this.listData[this.index] = res.list
					//this.$set(this.listData,this.index,res.list)
                    //this.listData[this.index] = this.listData[this.index].concat(res.list)
					if(res.list) this.$set(this.listData,this.index,this.listData[this.index].concat(res.list))

                })
            },
            downCallback:function () {
                this.mescroll.resetUpScroll()
                this.getList()
            },
            upCallback() {
                this.getList()
            },
            cancel(orderid){
                this.$http.get('order.op.cancel',{id:orderid}).then((res)=>{
                    this.$utils.toast('操作成功')
                })
            },
            actionPay:function (orderid) {
                this.$http.get('order.pay',{id:orderid}).then((res)=>{
                    this.payInfo = res
                    this.payInfo.payCredit = res.credit.current
                    this.payInfo.payPrice = res.order.price
                    this.showPayment = true
                })
            },
            takeDelivery:function (orderid) {
                this.$utils.modal.confirm('确认完成收货？').then((res)=>{
                    this.$http.get('order.confirm_receipt',{orderid:orderid}).then((res)=>{
                        this.downCallback()
                    })
                })
            },
            paymentClose:function () {
                this.$utils.modal.confirm('确定取消支付吗？').then((res)=>{
                    this.showPayment = false
                })
            },
            navTo:function (url,params) {
                params = params||{}
                let tabArr = ['/pages/index/index','/pages/tabbar/integralmall','/pages/tabbar/luckybag','/pages/tabbar/cart','/pages/member/index']
                if(tabArr.indexOf(url)>=0) this.$Router.pushTab({path:url})
                else this.$Router.push({path:url,query:params})
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
            emptyClick(){
                uni.showToast({
                    title:'点击了按钮,具体逻辑自行实现'
                })
            }
        },
        onPageScroll(e) {
            this.scrollTop = e.scrollTop;
        }
    }
</script>
<style>
	.container {
		padding-bottom: env(safe-area-inset-bottom);
	}

	.tui-order-list {
		/*margin-top: 80rpx;*/
	}

	.tui-order-item {
		margin-top: 20rpx;
		border-radius: 10rpx;
		overflow: hidden;
	}

	.tui-goods-title {
		width: 100%;
		font-size: 28rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.tui-order-status {
		color: #eb0909;
		font-size: 26rpx;
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
	}

	.tui-goods-center {
		flex: 1;
		padding: 20rpx 8rpx;
		box-sizing: border-box;
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
		padding-top: 20rpx;
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
		font-weight: 500;
	}

	.tui-order-btn {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		background: #fff;
		padding: 10rpx 30rpx 20rpx;
		box-sizing: border-box;
	}

	.tui-btn-ml {
		margin-left: 20rpx;
	}
</style>
