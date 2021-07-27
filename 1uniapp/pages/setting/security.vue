<template>
	<view class="container">

		<tui-list-cell :size="30" @click="$Router.push({name:'setting_security'})" :arrow="true" >
			<view class="tui-item-box" style="width: 100%;">
				<view class="tui-list-cell_name">手机号码</view>
				<view class="tui-right">{{userInfo.mobile}}</view>
			</view>
		</tui-list-cell>
		<tui-list-cell :size="30" @click="$Router.push({name:'member_update_password'})" :arrow="true" >
			修改密码
		</tui-list-cell>

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
            ...mapState(['modalAction']),
            ...mapGetters(['hasLogin','userInfo'])
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
</style>
