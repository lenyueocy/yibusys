<template>
	<view class="container">
		<view class="tui-page-title">注册</view>
		<view class="tui-form">
			<view class="tui-view-input">
				<tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
					<view class="tui-cell-input">
						<tui-icon name="mobile" color="#6d7a87" :size="20"></tui-icon>
						<input :value="mobile" placeholder="请输入手机号" placeholder-class="tui-phcolor" type="number" maxlength="11" @input="inputMobile" />
						<view class="tui-icon-close" v-show="mobile" @tap="clearInput(1)"><tui-icon name="close-fill" :size="16" color="#bfbfbf"></tui-icon></view>
					</view>
				</tui-list-cell>
				<tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
					<view class="tui-cell-input">
						<tui-icon name="shield" color="#6d7a87" :size="20"></tui-icon>
						<input placeholder="请输入验证码" placeholder-class="tui-phcolor" type="text" maxlength="6" @input="inputCode" />
                        <tui-countdown-verify
                            width="200rpx"
                            text="获取验证码"
                            sendText="发送中..."
                            borderColor="#FFF"
                            countdownText="秒后重新获取"
                            :successVal="successVal"
                            @send="send"
                            :params="7"
                            :size="28"
                            @end="end"
                            :seconds="60"
                            :resetVal="resetVal"
                        ></tui-countdown-verify>
					</view>
				</tui-list-cell>
				<tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
					<view class="tui-cell-input">
						<tui-icon name="pwd" color="#6d7a87" :size="20"></tui-icon>
						<input :value="pwd" placeholder="请输入密码" :password="true" placeholder-class="tui-phcolor" type="text" maxlength="40" @input="inputPwd" />
						<view class="tui-icon-close" v-show="pwd" @tap="clearInput(2)"><tui-icon name="close-fill" :size="16" color="#bfbfbf"></tui-icon></view>
					</view>
				</tui-list-cell>
				<tui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
					<view class="tui-cell-input">
						<tui-icon name="pwd" color="#6d7a87" :size="20"></tui-icon>
						<input :value="checkpwd" placeholder="请再次确认您的密码" :password="true" placeholder-class="tui-phcolor" type="text" maxlength="40" @input="inputCheckPwd" />
						<view class="tui-icon-close" v-show="checkpwd" @tap="clearInput(3)"><tui-icon name="close-fill" :size="16" color="#bfbfbf"></tui-icon></view>
					</view>
				</tui-list-cell>
			</view>
			<view class="tui-btn-box">
                <tui-button :disabledGray="true" :disabled="disabled" :shadow="true" shape="circle" @click="submit">注册</tui-button>
            </view>
			<view class="tui-cell-text">
				注册代表同意
				<view class="tui-color-primary" hover-class="tui-opcity" :hover-stay-time="150" @tap="protocol">商城用户服务协议、隐私政策</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	computed: {
		disabled: function() {
			let bool = true;
			if (this.mobile && this.verifycode && this.pwd && this.checkpwd) {
				bool = false;
			}
			return bool;
		}
	},
	data() {
		return {
            mobile: '',
            verifycode: '',
            pwd: '',
            checkpwd: '',
            successVal: 0,
            resetVal: 0,
            isSend: false,
            btnSendText: '获取验证码' //倒计时格式：(60秒)
		};
	},
	methods: {
        send(e){
            if(!/^[1][3,4,5,6,7,8,9][0-9]{9}$/.exec(this.mobile)){
                this.resetVal++
                this.$utils.toast('请输入正确的手机号码')
                return false;
            }
            this.$http.get('sms.register',{mobile:this.mobile}).then((res)=>{
                if(res.code) this.$utils.toast('您的验证码为：'+res.code)
                this.successVal++
            })
        },
		inputCode(e) {
			this.verifycode = e.detail.value;
		},
		inputMobile: function(e) {
			this.mobile = e.detail.value;
		},
		inputPwd: function(e) {
			this.pwd = e.detail.value;
		},
        inputCheckPwd: function(e) {
			this.checkpwd = e.detail.value;
		},
		clearInput(type) {
			if (type == 1) {
				this.mobile = '';
			} else if(type == 2) {
				this.pwd = '';
			}else if(type == 3) {
				this.checkpwd = '';
			}
		},
		protocol(){
            return false;
			this.tui.href("/pages/doc/protocol/protocol")
		},
        submit(){
            if(this.pwd!=this.checkpwd){
                this.$utils.toast('两次输入的密码不正确')
                return;
            }
            this.$http.get('account.register',{mobile:this.mobile,pwd:this.pwd,verifycode:this.verifycode}).then((res)=>{
                this.$store.commit('login',res)
                this.$utils.toast('注册成功')
                setTimeout(()=>{this.$Router.back()},500)
            })
        },
	}
};
</script>

<style lang="scss" scoped>
.container {
	.tui-page-title {
		width: 100%;
		font-size: 48rpx;
		font-weight: bold;
		//color: $uni-text-color;
		line-height: 42rpx;
		padding: 110rpx 40rpx 40rpx 40rpx;
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
				.tui-btn-send {
					width: 156rpx;
					text-align: right;
					flex-shrink: 0;
					font-size: $uni-font-size-base;
					//color: $uni-color-primary;
				}
				.tui-gray {
					//color: $uni-text-color-placeholder;
				}
			}
		}
		.tui-cell-text {
			width: 100%;
			padding: 40rpx $uni-spacing-row-lg;
			box-sizing: border-box;
			font-size: $uni-font-size-sm;
			color: $uni-text-color-grey;
			display: flex;
			align-items: center;
            justify-content: center;
			.tui-color-primary {
				//color: $uni-color-primary;
				padding-left: $uni-spacing-row-sm;
			}
		}
		.tui-btn-box {
			width: 100%;
			padding: 0 $uni-spacing-row-lg;
			box-sizing: border-box;
			margin-top: 80rpx;
		}
	}
}
</style>
