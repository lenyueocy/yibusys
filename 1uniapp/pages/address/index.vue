<template>
	<view class="content b-t">
		<!--<view class="list b-b" v-for="(item, index) in addressList" :key="index" @click="checkAddress(item)">
			<view class="wrapper">
				<view class="address-box">
					<text v-if="item.default" class="tag">默认</text>
					<text class="address">{{item.addressName}} {{item.area}}</text>
				</view>
				<view class="u-box">
					<text class="name">{{item.name}}</text>
					<text class="mobile">{{item.mobile}}</text>
				</view>
			</view>
			<text class="yticon icon-bianji" @click.stop="addAddress('edit', item)"></text>
		</view>-->

		<view class="tui-address">
			<block v-for="(item,index) in addressList" :key="index" >
				<tui-list-cell padding="0" @click="chooseAddress(item)" >
					<view class="tui-address-flex">
						<view class="tui-address-left">
							<view class="tui-address-main">
								<view class="tui-address-name tui-ellipsis">{{item.realname}}</view>
								<view class="tui-address-tel">{{item.mobile}}</view>
							</view>
							<view class="tui-address-detail">
								<view class="tui-address-label" v-if="parseInt(item.isdefault)==1">默认</view>
								<text>{{item.province}} {{item.city}} {{item.area}} {{item.address}}</text>
							</view>
						</view>
						<view class="tui-address-imgbox" @click.stop="editAddress(item.id)">
							<u-icon name="edit-pen" color="#999" size="40"></u-icon>
						</view>
					</view>
				</tui-list-cell>
			</block>
		</view>

		<view class="tui-address-new">
			<tui-button shadow shape="circle" type="danger" height="88rpx" @click="editAddress">+ 新增收货地址</tui-button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				source: 0,
				addressList: []
			}
		},
		onLoad(option){
			this.source = option.source;
			this.getList()
		},
		onShow(){
			this.getList()
		},
		methods: {
		    getList:function () {
				this.$http.get('member.address.get_list').then((res)=>{
					this.addressList = res.list
				})
            },
            chooseAddress(item){
                this.$utils.prePage().chooseAddrCallback(item)
                this.$Router.back()
			},
			editAddress(id){
			    const params = {}
			    if(id>0) params.id = id
				this.$Router.push({path:'/pages/address/edit',query:params})
			},
			refreshList(data, type){
				this.addressList.unshift(data);
			}
		}
	}
</script>

<style lang='scss'>
	page{
		padding-bottom: 120upx;
	}
	.content{
		position: relative;
	}
	.list{
		display: flex;
		align-items: center;
		padding: 20upx 30upx;;
		background: #fff;
		position: relative;
	}
	.wrapper{
		display: flex;
		flex-direction: column;
		flex: 1;
	}
	.address-box{
		display: flex;
		align-items: center;
		.tag{
			font-size: 24upx;
			color: $base-color;
			margin-right: 10upx;
			background: #fffafb;
			border: 1px solid #ffb4c7;
			border-radius: 4upx;
			padding: 4upx 10upx;
			line-height: 1;
		}
		.address{
			font-size: 30upx;
			color: $font-color-dark;
		}
	}
	.u-box{
		font-size: 28upx;
		color: $font-color-light;
		margin-top: 16upx;
		.name{
			margin-right: 30upx;
		}
	}
	.icon-bianji{
		display: flex;
		align-items: center;
		height: 80upx;
		font-size: 40upx;
		color: $font-color-light;
	}


	.tui-address {
		width: 100%;
		padding-top: 20rpx;
		padding-bottom: 160rpx;
	}
	.tui-address-flex {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.tui-address-main {
		width: 600rpx;
		height: 70rpx;
		display: flex;
		font-size: 30rpx;
		line-height: 86rpx;
		padding-left: 30rpx;
	}

	.tui-address-name {
		width: 120rpx;
		height: 60rpx;
	}

	.tui-address-tel {
		margin-left: 10rpx;
	}

	.tui-address-detail {
		font-size: 24rpx;
		word-break: break-all;
		padding-bottom: 25rpx;
		padding-left: 25rpx;
		padding-right: 120rpx;
	}

	.tui-address-label {
		padding: 5rpx 8rpx;
		flex-shrink: 0;
		background: #e41f19;
		border-radius: 6rpx;
		color: #fff;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 25rpx;
		line-height: 25rpx;
		transform: scale(0.8);
		transform-origin: center center;
		margin-right: 6rpx;
	}

	.tui-address-imgbox {
		width: 80rpx;
		height: 100rpx;
		position: absolute;
		display: flex;
		/*justify-content: center;*/
		align-items: center;
		right: 10rpx;
	}

	.tui-address-img {
		width: 36rpx;
		height: 36rpx;
	}
	.tui-address-new {
		width: 100%;
		position: fixed;
		left: 0;
		bottom: 0;
		z-index: 999;
		padding: 20rpx 25rpx 30rpx;
		box-sizing: border-box;
	}

</style>
