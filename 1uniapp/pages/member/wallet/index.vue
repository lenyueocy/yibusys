<template>
	<view>
		<view class="text-white padding-bottom-xl" style="background-color: #F8B600;">
			<view class="flex justify-between padding-lr-xl padding-tb-xl text-lg">
				<view>钱包余额</view>
				<view @click="$Router.push({name:'member_recharge'})" style="font-size: 28rpx;">充值<text class="lg cuIcon-right"></text></view>
			</view>
			<view class="flex justify-between align-center padding-lr-xl padding-tb-xl">
				<view class="" style="font-size: 60rpx;"><text class="text-xl">¥</text><text class="text-bold margin-left-xs">{{listData.credit2?listData.credit2:0}}</text></view>
				<view>
					<button @click="$Router.push({name:'member_withdraw'})" class="cu-btn round bg-white lg" style="color: #F8B600;border: none;padding: 0 50rpx;height: 70rpx;">我要提现</button>
				</view>
			</view>
		</view>
		<view >
			<view @click="$Router.push({name:'member_integral'})" class="bg-white padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">我的积分</text></view>
				<view><text class="lg cuIcon-right margin-left-xs"></text></view>
			</view>

			<view @click="$Router.push({name:'member_wallet_bankcard'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">我的银行卡</text></view>
				<view><text>{{listData.bankcardNum}} 张</text><text class="lg cuIcon-right margin-left-xs"></text></view>
			</view>

			<view v-if="0" @click="$Router.push({name:'member_wallet_integral'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">积分钱包</text><text class="padding-xs margin-left-xs" style="color: #ff5838;background-color: #ffeddf;font-size: 25rpx;border-radius: 8rpx;">释放5%成余额</text></view>
				<view><text v-if="listData.is_release">今日已释放完成</text><text v-else>去释放</text><text class="lg cuIcon-right margin-left-xs"></text></view>
			</view>

			<view @click="$Router.push({name:'member_record_balance'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">余额明细</text></view>
				<view><text class="lg cuIcon-right"></text></view>
			</view>
			<view @click="$Router.push({name:'member_record_integral'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">积分明细</text></view>
				<view><text class="lg cuIcon-right"></text></view>
			</view>
			<view @click="$Router.push({name:'member_record_recharge'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">充值记录</text></view>
				<view><text class="lg cuIcon-right"></text></view>
			</view>
			<view @click="$Router.push({name:'member_record_withdraw'})" class="bg-white margin-top-sm padding-tb-sm padding-lr-sm radius text-lg flex justify-between" style="transform: translateY(-50%);">
				<view><text class="text-black text-bold">提现记录</text></view>
				<view><text class="lg cuIcon-right"></text></view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
                listData: '',
			}
		},
		onLoad(){
		    this.getList()
		},
		onShow(){
            this.getList()
		},
		methods: {
            getList:function () {
				this.$http.get('member.wallet').then((res)=>{
					this.listData = res
				})
            }
		}
	}
</script>

<style lang='scss'>
	.radius{
		border-radius: 22rpx;
	}
</style>
