<template>
	<view>
		<view style="height: 500rpx;" class="flex align-center justify-center">暂无消息</view>
		<view class="notice-item" v-if="0">
			<text class="time">11:30</text>
			<view class="content">
				<text class="title">新品上市，全场满199减50</text>
				<view class="img-wrapper">
					<image class="pic" src="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3761064275,227090144&fm=26&gp=0.jpg"></image>
				</view>
				<text class="introduce">
					虽然做了一件好事，但很有可能因此招来他人的无端猜测，例如被质疑是否藏有其他利己动机等，乃至谴责。即便如此，还是要做好事。
				</text>
				<view class="bot b-t">
					<text>查看详情</text>
					<text class="more-icon yticon icon-you"></text>
				</view>
			</view>
		</view>
		<view class="notice-item" v-if="0">
			<text class="time">2019-07-26 12:30</text>
			<view class="content">
				<text class="title">新品上市，全场满199减50</text>
				<view class="img-wrapper">
					<image class="pic" src="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3761064275,227090144&fm=26&gp=0.jpg"></image>
					<view class="cover">
						活动结束
					</view>
				</view>
				<text class="introduce">新品上市全场2折起，新品上市全场2折起，新品上市全场2折起，新品上市全场2折起，新品上市全场2折起</text>
				<view class="bot b-t">
					<text>查看详情</text>
					<text class="more-icon yticon icon-you"></text>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		methods: {

		}
	}
</script>

<style lang='scss'>
	page {
		background-color: #f6f6f6;
		padding-bottom: 30upx;
	}

	.notice-item {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.time {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 80upx;
		padding-top: 10upx;
		font-size: 26upx;
		color: #7d7d7d;
	}

	.content {
		width: 710upx;
		padding: 0 24upx;
		background-color: #fff;
		border-radius: 4upx;
	}

	.title {
		display: flex;
		align-items: center;
		height: 90upx;
		font-size: 32upx;
		color: #303133;
	}

	.img-wrapper {
		width: 100%;
		height: 260upx;
		position: relative;
	}

	.pic {
		display: block;
		width: 100%;
		height: 100%;
		border-radius: 6upx;
	}

	.cover {
		display: flex;
		justify-content: center;
		align-items: center;
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .5);
		font-size: 36upx;
		color: #fff;
	}

	.introduce {
		display: inline-block;
		padding: 16upx 0;
		font-size: 28upx;
		color: #606266;
		line-height: 38upx;
	}

	.bot {
		display: flex;
		align-items: center;
		justify-content: space-between;
		height: 80upx;
		font-size: 24upx;
		color: #707070;
		position: relative;
	}

	.more-icon {
		font-size: 32upx;
	}
</style>
