<template>
	<view class="tui-set-box">
		<tui-list-cell :size="30" @click="$Router.push({name:'member_info'})" :arrow="true" >
			<image :src="userInfo.avatar?userInfo.avatar:'/static/images/avatar/default.png'" class="tui-avatar"></image>
			<view>{{hasLogin?userInfo.nickname:'未登录'}}</view>
		</tui-list-cell>

		<tui-list-cell unlined :size="30" @click="$Router.push({name:'address_index'})" :arrow="true" >
			我的收货地址
		</tui-list-cell>

		<tui-list-cell unlined :size="30" @click="$Router.push({name:'setting_security'})" :arrow="true" class="margin-top-sm">
			账户与安全
		</tui-list-cell>

		<tui-list-cell :size="30" @click="clearCache" :arrow="true" class="margin-top-sm">
			清除缓存
		</tui-list-cell>
		<tui-list-cell :size="30" :arrow="true" unlined>
			<view class="tui-item-box" style="width: 100%;">
				<view class="tui-list-cell_name">检查更新</view>
				<view class="tui-right">当前版本 {{version}}</view>
			</view>
		</tui-list-cell>


		<view class="tui-exit">
			<tui-button shape="circle" shadow type="danger" height="88rpx" @click="logout" v-if="hasLogin">退出登录</tui-button>
		</view>

		<!--leny注释-->
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>

	</view>
</template>

<script>
	import {mapMutations,mapState,mapGetters} from 'vuex';
	export default {
		data() {
			return {

			};
		},
        computed:{
            ...mapState(['modalAction']),
			...mapGetters(['hasLogin','userInfo','version'])
		},
		onLoad(){
		    if(this.hasLogin) this.getList()
		},
		methods:{
            ...mapMutations(['logout']),
            getList:function () {
				this.$http.get('member.info').then((res)=>{
                    this.updateUserInfo(res)
				})
            },
            checkAuth:function () {

            },
            updateUserInfo:function (userInfo) {
                if(userInfo.nickname) this.$store.commit('updateUserInfo',{nickname:userInfo.nickname})
                if(userInfo.avatar) this.$store.commit('updateUserInfo',{avatar:userInfo.avatar})
                if(userInfo.realname) this.$store.commit('updateUserInfo',{realname:userInfo.realname})
                if(userInfo.mobile) this.$store.commit('updateUserInfo',{mobile:userInfo.mobile})
                if(userInfo.weixin) this.$store.commit('updateUserInfo',{weixin:userInfo.weixin})
            },
            clearCache:function () {
				this.$utils.modal.confirm('确认清除缓存？').then((res)=>{
					this.$store.commit('clearCache')
                    setTimeout(()=>{this.$utils.modal.alert('清除缓存成功')},300)
				})
            },
			switchChange(e){
				let statusTip = e.detail.value ? '打开': '关闭';
				this.$api.msg(`${statusTip}消息推送`);
			},

		}
	}
</script>

<style lang='scss'>
	.tui-set-box {
		padding-bottom: 20rpx;
		color: #333;
	}

	.tui-list-cell {
		display: flex;
		align-items: center;
		padding: 24rpx 30rpx;
		font-size: 30rpx;
	}

	.tui-info-box {
		font-size: 34rpx;
	}

	.tui-avatar {
		width: 140rpx;
		height: 140rpx;
		border-radius: 50%;
		margin-right: 20rpx;
	}

	.tui-exit {
		padding: 100rpx 24rpx;
	}

	.tui-item-box {
		width: 100%;
		display: flex;
		align-items: center;
	}

	.tui-list-cell_name {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-ml-auto {
		margin-left: auto;
	}

	.tui-right {
		margin-left: auto;
		margin-right: 34rpx;
		font-size: 28rpx;
		color: #999;
	}

	/*page{
		background: $page-color-base;
	}
	.list-cell{
		display:flex;
		align-items:baseline;
		padding: 20upx $page-row-spacing;
		line-height:60upx;
		position:relative;
		background: #fff;
		justify-content: center;
		&.log-out-btn{
			margin-top: 40upx;
			.cell-tit{
				color: $uni-color-primary;
				text-align: center;
				margin-right: 0;
			}
		}
		&.cell-hover{
			background:#fafafa;
		}
		&.b-b:after{
			left: 30upx;
		}
		&.m-t{
			margin-top: 16upx;
		}
		.cell-more{
			align-self: baseline;
			font-size:$font-lg;
			color:$font-color-light;
			margin-left:10upx;
		}
		.cell-tit{
			flex: 1;
			font-size: $font-base + 2upx;
			color: $font-color-dark;
			margin-right:10upx;
		}
		.cell-tip{
			font-size: $font-base;
			color: $font-color-light;
		}
		switch{
			transform: translateX(16upx) scale(.84);
		}
	}*/
</style>
