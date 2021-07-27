<template>
	<view class="container">

		<view class="tui-userinfo-box">

			<tui-list-cell padding="0" :arrow="true" @click="changeAvatar">
				<view class="tui-list-cell tui-pr30">
					<view>头像</view>
					<image :src="listData.avatar?listData.avatar:'/static/images/avatar/default.png'" class="tui-avatar"></image>
				</view>
			</tui-list-cell>

			<tui-list-cell padding="0" :hover="false">
				<view class="tui-list-cell tui-pr30">
					<view>用户名</view>
					<input type="text" class="text-right" placeholder="请输入用户名" v-model="listData.nickname" placeholder-class="tui-phcolor"></input>
				</view>
			</tui-list-cell>

			<tui-list-cell padding="0" :hover="false">
				<view class="tui-list-cell tui-pr30">
					<view>手机号</view>
					<view @click="bindMobile">{{listData.mobile?listData.mobile:'未绑定(点击绑定)'}}</view>
				</view>
			</tui-list-cell>

			<tui-list-cell padding="0" :hover="false" style="margin-top:20rpx;" >
				<view class="tui-list-cell tui-pr30">
					<view>真实姓名</view>
					<input type="text" class="text-right" :value="listData.realname" disabled="true" placeholder-class="tui-phcolor"></input>
				</view>
			</tui-list-cell>
			<tui-list-cell padding="0" :hover="false" v-if="0">
				<view class="tui-list-cell tui-pr30">
					<view>身份证号码</view>
					<input type="text" class="text-right" :value="listData.card_id" disabled="true" placeholder-class="tui-phcolor"></input>
				</view>
			</tui-list-cell>

			<tui-list-cell padding="0" :hover="false" >
				<view class="tui-list-cell tui-pr30">
					<view>微信号</view>
					<input type="text" class="text-right" placeholder="请输入微信号" v-model="listData.weixin" placeholder-class="tui-phcolor"></input>
				</view>
			</tui-list-cell>

			<!--<tui-list-cell padding="0">
				<view class="tui-list-cell tui-pr30">
					<view>性别</view>
					<view class="tui-content">男</view>
				</view>
			</tui-list-cell>-->

			<!--<tui-list-cell padding="0" :arrow="true" unlined >
				<view class="tui-list-cell tui-pr30">
					<view>出生日期</view>
					<view class="tui-content">1986-09-27</view>
				</view>
			</tui-list-cell>-->

		</view>

		<view class="list-cell log-out-btn" @click="submit" hover-class="cell-hover" :hover-stay-time="50">
			<text class="cell-tit">保存</text>
		</view>
		<!-- lenyue 注释 -->
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>
	</view>

</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    //import { pathToBase64, base64ToPath } from 'image-tools'
    export default {
        data() {
            return {
				listData:this.$store.getters.userInfo,
                tempFilePaths:'',
            };
        },
        computed:{
            ...mapState(['modalAction'])
        },
		onLoad(){
            this.getList()
		},
        methods:{
            getList:function () {
				this.$http.get('member.info').then((res)=>{
					this.updateUserInfo(res)
				})
            },
            submit:function () {
				this.$http.get('member.info.submit',{memberdata:this.listData}).then((res)=>{
					if(res.error==0) {
					    this.$utils.toast('保存成功')
						this.listData.card_id = res.card_id
					    this.updateUserInfo(this.listData)
                        setTimeout(()=>{this.$Router.back()},1500)
					}
				})
            },
            bindMobile:function () {
				if(this.listData.mobile) return false;
                this.$Router.push({name:'login_bidding'})
            },
			updateUserInfo:function (userInfo) {
                if(userInfo.nickname) this.$store.commit('updateUserInfo',{nickname:userInfo.nickname})
                if(userInfo.avatar) this.$store.commit('updateUserInfo',{avatar:userInfo.avatar})
                if(userInfo.realname) this.$store.commit('updateUserInfo',{realname:userInfo.realname})
                if(userInfo.mobile) this.$store.commit('updateUserInfo',{mobile:userInfo.mobile})
                if(userInfo.weixin) this.$store.commit('updateUserInfo',{weixin:userInfo.weixin})
                if(userInfo.card_id) this.$store.commit('updateUserInfo',{card_id:userInfo.card_id})
            },
            changeAvatar:function () {
                uni.chooseImage({
                    count: 1,
                    sizeType: ['original', 'compressed'],
                    sourceType: ['album', 'camera'],
                    success: result => {
                        var tempFilePaths = result.tempFilePaths[0];
                        this.tempFilePaths = result.tempFilePaths[0];
                        //this.$Router.push({path:'/pages/member/cropper',query:{src:tempFilePaths}})
                        this.$http.upload('util.uploader.upload',{filePath:tempFilePaths,name:'file'}).then((subResult)=>{
                            let avatar = subResult.files[0].url
                            this.$http.get('member.info.submit',{memberdata:{avatar:avatar}}).then((res)=>{
                                if(res.error==0) {
                                    this.listData.avatar = avatar
                                    this.$utils.toast('头像更换成功')
                                    this.$store.commit('updateUserInfo',{avatar:avatar})
                                }
                            })
                        }).catch((err)=>{
                            this.$utils.toast('头像更换失败')
                        })
                    }
                });
            },
			uploadAvatar:function (callback) {
                base64ToPath(callback.base64)
                    .then(path => {
                        console.log(path)
                        //path = this.tempFilePaths
                        console.log(path)
                        this.$http.upload('util.uploader.upload',{filePath:path}).then((subResult)=>{
                            let avatar = subResult.files[0].url
                            this.$http.get('member.info.submit',{memberdata:{avatar:avatar}}).then((res)=>{
                                if(res.error==0) {
                                    this.listData.avatar = avatar
                                    this.$utils.toast('头像更换成功')
                                    this.$store.commit('updateUserInfo',{avatar:avatar})
                                }
                            })
                        }).catch((err)=>{
                            this.$utils.toast('头像更换失败')
                        })
                    })
                    .catch(error => {
                        console.error(error)
                    })

            }
        }
    }
</script>

<style lang='scss'>
	page{
		background: $page-color-base;
	}

	.tui-userinfo-box {
		margin: 20rpx 0;
		color: #333;
	}

	.tui-list-cell {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 24rpx 60rpx 24rpx 30rpx;
		box-sizing: border-box;
		font-size: 30rpx;
	}

	.tui-pr30 {
		padding-right: 30rpx;
	}

	.tui-avatar {
		width: 100rpx;
		height: 100rpx;
		border-radius: 50%;
		display: block;
	}

	.tui-content {
		font-size: 26rpx;
		color: #666;
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
	}
</style>
