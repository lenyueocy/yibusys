<template>
	<view class="bg-image" >
		<view class="text-center flex justify-center" style="padding-top: 100rpx;">
			<view class="padding-sm bg-white flex justify-center align-center" style="border-radius: 50%;">
				<text class="iconfont icon-jifen1" style="color: #ff0000;width: 80rpx;height: 80rpx;"></text>
			</view>
		</view>
		<view class="text-center text-xl margin-top-lg text-white">我的积分</view>
		<view class="bg-white margin-lr-sm radius margin-top-sm">
			<view class="text-center" style="padding-top: 80rpx;">积分<text class="lg cuIcon-right"></text></view>
			<view class="text-center  text-black margin-top-lg" style="font-size: 60rpx;">{{data.integral||0}}</view>
            <view class="text-center"><text class="padding-xs" style="color: #ff5838;background-color: #ffeddf;font-size: 25rpx;border-radius: 8rpx;">积分兑好礼</text></view>
			<view class="text-center" v-if="0">
				<button @click="$Router.push({name:'member_import_integral'})" class="cu-btn lg" style="height:60rpx;background-color: #ff6a4d;color: #fff;">兑换积分</button>
			</view>
			<view class="flex text-gray" style="margin-top: 100rpx;">
				<view class="flex-sub text-center" style="border-right: 1rpx solid #e5e5e5;">
					<view>今日获得</view>
					<view class="margin-top-lg"><text class="text-black text-xl">{{data.today||0}}</text><text class="margin-left-xs">积分</text></view>
				</view>
				<view class="flex-sub text-center">
					<view>昨日获得</view>
					<view class="margin-top-lg"><text class="text-black text-xl">{{data.yesterday||0}}</text><text class="margin-left-xs">积分</text></view>
				</view>
			</view>
            <view style="margin-top: 100rpx;margin-bottom: 100rpx;">
                <button @click="$Router.push({name:'integralmall_index'})" style="width: 60%;background-color: #ff6a4d;color: #fff;">兑换礼品</button>
                <button @click="$Router.push({name:'member_record_integral'})" class="margin-top-lg" style="width: 60%;background-color: #ffe5e0;color: #ff6a4d;">积分明细</button>
            </view>
			<view class="padding-tb-lg padding-lr-sm flex justify-between margin-top-lg " style="border-top: 10rpx solid #eeeeee;">
				<text class="text-blue text-sml">了解积分说明</text>
				<text class="lg cuIcon-right"></text>
			</view>
		</view>
		<view class="margin-top-xl text-center">
		</view>
	</view>
</template>

<script>
	export default{
		data(){
		    return {
				data: '',
			}
		},
		onLoad(){
		    this.getList()
		},
		onShow(){
		    this.getList()
		},
		methods:{
			getList:function () {
				this.$http.get('member.integral').then((res)=>{
					this.data = res.data
				})
            }
		}
	}
</script>

<style lang="scss">
	.radius{
		border-radius: 22rpx;
	}
	.bg-image{
		min-height: 100vh;
		background: url("http://appstore.bai918.com/static/app/images/member_wallet_integral_bg.png");
		background-size:100% 100%;
		background-repeat:no-repeat;
	}
</style>
