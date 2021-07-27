<template>
	<view class="container">
		<!-- #ifndef MP -->
		<view class="tui-status-bar"></view>
		<!--<view class="tui-header">
			<view>ThorUI组件库</view>
			<tui-icon name="shut" :size="26" @click="back"></tui-icon>
		</view>-->
		<!-- #endif -->
        <block v-if="is_wxLogin">
            <view style="margin-top: 60%;padding: 0 10%;">
                <tui-button type="green" :shadow="true" shape="circle" @click="getUserInfo" >微信授权登录</tui-button>
                <view class="tui-mobile-cell-text tui-opcity" @click="is_wxLogin = false">手机号验证注册/登录</view>
            </view>
        </block>
        <block v-else>
            <view class="tui-page-title">登录</view>
            <view class="tui-form">
                <view class="tui-view-input">
                    <tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
                        <view class="tui-cell-input">
                            <tui-icon name="mobile" color="#6d7a87" :size="20"></tui-icon>
                            <input
                                :adjust-position="false"
                                :value="mobile"
                                placeholder="请输入手机号"
                                placeholder-class="tui-phcolor"
                                type="number"
                                maxlength="11"
                                @input="inputMobile"
                            />
                            <view class="tui-icon-close" v-show="mobile" @tap="clearInput(1)"><tui-icon name="close-fill" :size="16" color="#bfbfbf"></tui-icon></view>
                        </view>
                    </tui-list-cell>
                    <tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
                        <view class="tui-cell-input">
                            <tui-icon name="pwd" color="#6d7a87" :size="20"></tui-icon>
                            <input
                                :adjust-position="false"
                                :value="pwd"
                                placeholder="请输入密码"
                                :password="true"
                                placeholder-class="tui-phcolor"
                                type="text"
                                maxlength="36"
                                @input="inputPwd"
                            />
                            <view class="tui-icon-close" v-show="pwd" @tap="clearInput(2)"><tui-icon name="close-fill" :size="16" color="#bfbfbf"></tui-icon></view>
                        </view>
                    </tui-list-cell>
                </view>
                <view class="tui-cell-text">
                    <view class="tui-color-primary" hover-class="tui-opcity" :hover-stay-time="150" @tap="$Router.push({name:'login_forget'})">忘记密码？</view>
                    <view hover-class="tui-opcity" :hover-stay-time="150">
                        没有账号？
                        <text class="tui-color-primary" @tap="$Router.push({name:'login_register'})">注册</text>
                    </view>
                </view>
                <view class="tui-btn-box">
                    <tui-button :disabledGray="true" :disabled="disabled" :shadow="true" shape="circle" @click="submit">登录</tui-button>
                </view>
            </view>
            <view class="tui-login-way" v-if="!popupShow"><view hover-class="tui-opcity" :hover-stay-time="150" @tap="showOtherLogin">其他方式登录</view></view>
            <tui-bottom-popup :mask="false" backgroundColor="transparent" :show="popupShow">
                <view class="tui-auth-login">
                    <!-- #ifndef MP -->
                    <!--<view class="tui-icon-platform" hover-class="tui-opcity" :hover-stay-time="150"><image src="/static/images/share/icon_qq.png" class="tui-login-logo"></image></view>-->
                    <!-- #endif -->
                    <!-- #ifdef APP-PLUS || MP-WEIXIN || H5 -->
                    <view @click="is_wxLogin = true" class="tui-icon-platform" hover-class="tui-opcity" :hover-stay-time="150">
                        <image src="/static/images/share/icon_wechat.png" class="tui-login-logo"></image>
                    </view>
                    <!-- #endif -->
                    <!-- #ifndef MP -->
                    <!--<view class="tui-icon-platform" hover-class="tui-opcity" hover-stay-time="150">
                        <image src="/static/images/share/icon_sina.png" class="tui-login-logo"></image>
                    </view>-->
                    <!-- #endif -->
                </view>
            </tui-bottom-popup>
        </block>
	</view>
</template>

<script>
import { mapMutations } from 'vuex';
export default {
	computed: {
		disabled: function() {
			let bool = true;
			if (this.mobile && this.pwd) {
				bool = false;
			}
			return bool;
		}
	},
	data() {
		return {
			mobile: '',
			pwd: '',
			is_wxLogin: true,
			popupShow: false,
		};
	},
	onLoad(options) {
		this.threeLogin()
	},
    onShow(){
	    if(this.$store.getters.hasLogin){
            this.$Router.back()
        }
    },
	methods: {
		...mapMutations(['login', 'logout']),
		back() {
			uni.navigateBack();
		},
		inputMobile: function(e) {
			this.mobile = e.detail.value;
		},
		inputPwd: function(e) {
			this.pwd = e.detail.value;
		},
		clearInput(type) {
			if (type == 1) {
				this.mobile = '';
			} else {
				this.pwd = '';
			}
		},
		showOtherLogin() {
			//打开后 不再关闭
			this.popupShow = true;
		},
        threeLogin(){
            uni.getProvider({
                service: 'oauth',
                success: (oauthRes) => {
                    if (~oauthRes.provider.indexOf('weixin')) {
                        uni.login({
                            provider: 'weixin',
                            success: (loginRes) => {
                                this.$http.get('wxapp.login',{code:loginRes.code}).then((res)=>{
                                    this.session_key = res.session_key
                                    this.openid = res.openid
                                })
                            },
                            fail: () => {
                                this.$utils.toast('加载微信登录失败')
                            }
                        })

                    }else{
                        uni.showToast({title:"请先安装微信或升级版本",icon:"none"})
                    }
                }
            })
        },
        getUserInfo(){
            if(this.$utils.getPlatform()!='mp-weixin'){
                this.$utils.toast('该平台不支持微信登录')
                return;
            }
            uni.getUserProfile({
                desc:'用于完善会员资料',
                lang:'zh_CN',
                success:(profileRes)=>{
                    this.auth(profileRes)
                }
            })
        },
        auth(data){
            if(!this.openid || !this.session_key) {
                this.$utils.toast('加载中，请稍后重试')
                return false;
            }
            uni.checkSession({
                success:(res)=>{
                    const params = {
                        data:data.encryptedData,
                        iv:data.iv,
                        sessionKey:this.session_key,
                        openid:this.openid
                    }
                    this.$http.get('wxapp.auth',params).then((res)=>{
                        uni.hideLoading();
                        if(res.error==0){
                            if(res.member){
                                this.$store.commit('login',res)
                                uni.showToast({title:'微信登录成功',icon:'none'})
                                setTimeout(()=>{this.$Router.back()},300)
                            }else{
                                uni.setStorageSync('wx_info',res);
                                this.$Router.push({path:'/pages/login/bidding'})
                            }
                        }
                    })
                },
                fail:(res)=>{
                    this.$utils.toast('登录态已过期,请重新点击授权')
                    this.threeLogin()
                },
            })

        },
        submit(){
            this.$http.get('account.login',{mobile:this.mobile,pwd:this.pwd,verifycode:this.verifycode}).then((res)=>{
                this.$store.commit('login',res)
                this.$utils.toast('登录成功')
                setTimeout(()=>{this.$Router.back()},500)
            })
        }
	}
};
</script>

<style lang="scss">
.container {
	.tui-status-bar {
		width: 100%;
		height: var(--status-bar-height);
	}

	.tui-header {
		width: 100%;
		padding: 40rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		box-sizing: border-box;
	}

	.tui-page-title {
		width: 100%;
		font-size: 48rpx;
		font-weight: bold;
		//color: $uni-text-color;
		line-height: 42rpx;
		padding: 40rpx;
		box-sizing: border-box;
	}

	.tui-form {
		padding-top: 50rpx;

		.tui-view-input {
			width: 100%;
			box-sizing: border-box;
			padding: 0 40rpx;

			.tui-cell-input {
				width: 100%;
				display: flex;
				align-items: center;
				padding-top: 48rpx;
				padding-bottom: $uni-spacing-col-base;
				input {
					flex: 1;
					padding-left: $uni-spacing-row-base;
				}
				.tui-icon-close {
					margin-left: auto;
				}
			}
		}

		.tui-cell-text {
			width: 100%;
			padding: $uni-spacing-col-lg $uni-spacing-row-lg;
			box-sizing: border-box;
			font-size: $uni-font-size-sm;
			//color: $uni-text-color-grey;
			display: flex;
			align-items: center;
			justify-content: space-between;
			.tui-color-primary {
				//color: $uni-color-primary;
			}
		}

		.tui-btn-box {
			width: 100%;
			padding: 0 $uni-spacing-row-lg;
			box-sizing: border-box;
			margin-top: 80rpx;
		}
	}

	.tui-login-way {
		width: 100%;
		font-size: 26rpx;
		//color: $uni-color-primary;
		display: flex;
		justify-content: center;
		position: fixed;
		left: 0;
		bottom: 80rpx;

		view {
			padding: 12rpx 0;
		}
	}

	.tui-auth-login {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		padding-bottom: 80rpx;
		padding-top: 20rpx;

		.tui-icon-platform {
			width: 90rpx;
			height: 90rpx;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			margin-left: 40rpx;

			&::after {
				content: '';
				position: absolute;
				width: 200%;
				height: 200%;
				transform-origin: 0 0;
				transform: scale(0.5, 0.5) translateZ(0);
				box-sizing: border-box;
				left: 0;
				top: 0;
				border-radius: 180rpx;
				border: 1rpx solid $uni-text-color-placeholder;
			}
		}

		.tui-login-logo {
			width: 60rpx;
			height: 60rpx;
		}
	}
    .tui-mobile-cell-text{
        font-size: 28rpx;
        margin-top: 50rpx;
        text-align: center;
    }
}
</style>
