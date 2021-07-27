<template>
	<view>
		<view class="text-red padding-sm">绑定一张银行卡即可完成实名认证</view>
		<view class="padding-lr-sm text-white" v-for="(item,index) in listData">
			<view class="margin-top-sm bankcard-bgcolor radius">
				<view class="flex padding-top-sm align-center">
					<view style="width: 20%;text-align: center;"><text class="iconfont icon-yinhangqia" style="font-size: 80rpx"></text></view>
					<view>
						<view class="text-lg">{{item.bank_name}}</view>
						<view class="margin-top-xs" style="font-weight: 300;">{{item.bank_type}}</view>
					</view>
				</view>
				<view class="flex padding-tb-sm">
					<view style="width: 20%"></view>
					<view style="font-size: 35rpx;font-weight: 500;">{{item.card_no}}</view>
				</view>
			</view>
		</view>
		<view class="flex justify-center align-center" style="height: 50vh;" v-if="!listData">
			<view class="text-center">
				<view class="bg-white" style="display: inline-block;padding: 40rpx;border-radius: 50%;">
					<text class="iconfont icon-yinhangqia" style="width: 70rpx;height: 70rpx;display: block;"></text>
				</view>
				<view class="text-gray margin-top-lg">暂无银行卡</view>
			</view>
		</view>

		<view @click="$Router.push({name:'member_wallet_add_bankcard'})" class="bg-white padding-tb-xl text-xl flex justify-center align-center margin-tb-xl">
			<text class="cuIcon-roundadd" ></text>
			<text class="margin-left-xs text-lg">增加银行卡</text>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				listData:'',
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
				this.$http.get('member.bankcard').then((res)=>{
					this.listData = res.data
				})
            }
		}
	}
</script>

<style lang='scss'>
	.radius{
		border-radius: 22rpx;
	}
	.bankcard-bgcolor{
		background-image: linear-gradient(56deg,#008666 0%,#80a833 100%,#ffca00 100%,#8ac94e 100%,#14c89b 100%),linear-gradient(#ffffff,#ffffff);
		background-blend-mode: normal,normal;
		box-shadow: 0rpx 0rpx 20rpx 0rpx rgba(0, 134, 102, 0.35);
	}
</style>
