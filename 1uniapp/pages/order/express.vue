<template>
	<view class="container">
		<view class="tui-order-header">
			<!--<view class="tui-text">订单编号：
				<text class="tui-bold">{{res.ordersn}}</text>
			</view>-->
			<view class="tui-text">快递公司：<text class="">{{res.com||'暂无'}}</text></view>
			<view class="tui-text">快递单号：<text class="">{{res.sn||'暂无'}}</text></view>
		</view>
		<view class="tui-order-tracking">
			<view v-if="expresslist">
				<tui-time-axis>
					<!--<tui-timeaxis-item backgroundColor="transparent">
						<template v-slot:node>
							<view class="tui-node" :style="{backgroundColor:backgroundColor}">
								<tui-icon name="check" color="#fff" :size="14" :bold="true"></tui-icon>
							</view>
						</template>

						<template v-slot:content>
							<view>
								<view class="tui-order-title">已签收</view>
								<view class="tui-order-desc">您的订单已由本人签收。感谢您在商城购物，欢迎再次光临。</view>
								<view class="tui-order-time text-gray">2019-05-01 18:48:26</view>
							</view>
						</template>
					</tui-timeaxis-item>-->

						<tui-timeaxis-item backgroundColor="transparent" v-for="(item,index) in expresslist" :key="index">
							<template v-slot:node>
								<view class="tui-node" :style="{backgroundColor:index==0?backgroundColor:''}">
									<tui-icon :name="index==0 && expressData.State==3?'check':'transport'" color="#fff" :size="13"></tui-icon>
								</view>
							</template>
							<template v-slot:content>
								<view class="tui-order-title" :class="[index==0?'text-black':'text-gray']" v-if="index==0 && expressData.State==3">{{res.status}}}</view>
								<view class="tui-order-title" :class="[index==0?'text-black':'text-gray']" v-else>运输中</view>
								<view class="tui-order-desc tui-light-gray">{{item.step}}</view>
								<view class="tui-order-time text-gray">{{item.time}}</view>
							</template>
						</tui-timeaxis-item>
				</tui-time-axis>
			</view>
			<view class="text-center text-grey" v-else>暂无物流信息</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
			    res:'',
			    data:{},
                expresslist:'',
                expressData:'',
                backgroundColor:"#5677fc"
			}
		},
		onLoad(){
			this.getList()
			this.data.ordersn = this.$Route.query.ordersn
			this.data.express = this.$Route.query.express
			this.data.expresscom = this.$Route.query.expresscom
			this.data.expresssn = this.$Route.query.expresssn
		},
		methods:{
		    getList:function () {
		        if(!this.$Route.query.orderid){
					this.$utils.toast('缺少快递公司！')
					return;
				}
				this.$http.get('order.express',{id:this.$Route.query.orderid}).then((res)=>{
					this.res = res
					this.expresslist = res.expresslist
				})
            }
		}
	}
</script>

<style>
	.tui-order-header {
		padding: 30rpx;
		box-sizing: border-box;
		background: #fff;
	}

	.tui-text {
		font-size: 28rpx;
		color: #333;
		padding: 4rpx;
	}

	.tui-bold {
		font-weight: bold;
	}

	.tui-node {
		height: 44rpx;
		width: 44rpx;
		border-radius: 50%;
		background-color: #ddd;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		flex-shrink: 0;
	}

	.tui-node-dot {
		height: 16rpx;
		width: 16rpx;
		background-color: #ddd;
		border-radius: 50%;
		/* transform: translateY(45%); */
		margin-top: 6rpx;
	}

	.tui-bg-primary {
		background: #EB0909 !important;
	}

	.tui-order-tracking {
		padding: 30rpx 30rpx 30rpx 40rpx;
		background: #fff;
		margin-top: 20rpx;
		box-sizing: border-box;
	}

	.tui-order-title {
		padding-bottom: 12rpx;
		font-size: 32rpx;
		color: #333;
		font-weight: bold;
	}

	.tui-order-desc {
		padding-bottom: 12rpx;
		font-size: 28rpx;
		color: #333;
	}

	.tui-ptop {
		display: flex;
		justify-content: flex-start;
		line-height: 28rpx;
	}

	.tui-order-time {
		font-size: 24rpx;
		font-weight: bold;
	}

	.text-gray {
		color: #848484 !important;
	}

	.tui-light-gray {
		color: #888 !important;
	}

	.tui-primary {
		color: #5677fc;
	}
</style>
