<template>
	<view class="content">
		<view v-if="!changeSuccess">
			<view class="logo">
				<image src="http://appstore.bai918.com/static/app/images/index_fudai.png" mode=""></image>
			</view>
			<view class="uni-form-item uni-column">
				<input v-model="mobile" type="number" class="uni-input" placeholder="请输入手机号" />
			</view>
			<view class="uni-form-item uni-column column-with-btn" v-if="mobile.length==11">
				<input v-model="verifyImgCode" type="text" class="uni-input" placeholder="请输入图片验证码" />
				<image :src="$http.config.baseURL+'?mobile='+mobile+'&r=sms.captcha&i=1&random='+random" @click="random = Math.random()" class="img-captcha" ></image>
			</view>
			<view class="uni-form-item uni-column column-with-btn">
				<input v-model="verifycode" type="number" class="uni-input" placeholder="请输入验证码"/>
				<button :class="{active : !disableCodeBtn}" :disabled="disableCodeBtn" @tap="sendCode" class="code-captcha flex align-center justify-center">{{codeBtn.text}}</button>
			</view>
			<view class="uni-form-item uni-column">
				<input v-model="pwd" type="password" class="uni-input" placeholder="请输入新密码"/>
			</view>
			<button type="primary" @click="submit">重置密码</button>

		</view>

		<view v-if="changeSuccess">
			<view class="text-reset">重置成功，新密码已生效！</view>
			<button type="primary" @tap="$Router.back()">去登录</button>
		</view>

	</view>
</template>

<script>
    export default {
        data() {
            return {
                mobile:'',
                pwd:'',
                nickname:'',
                verifycode:'',
                verifyImgCode: '',
                random: Math.random(),
                seconds: 60,
                codeBtn: {
                    text: '获取验证码',
                    waitingCode: false,
                    count: this.seconds
                },
                changeSuccess:false,
            }
        },
        onLoad() {

        },
        onShow(){
            if(this.changeSuccess==true) this.$Router.push({name:'member_index'})
        },
        methods: {
            sendCode: function () {
                this.$http.get('sms.register',{mobile:this.mobile,verifyImgCode:this.verifyImgCode}).
                then((res)=>{
                    this.$utils.toast('验证码发送成功')
                    this.startCodeTime()
                })
            },
            startCodeTime(){
                this.codeBtn.waitingCode = true;
                this.codeBtn.count = this.seconds;
                this.codeBtn.text = this.codeBtn.count + 's';
                let countdown = setInterval(() => {
                    this.codeBtn.count--;
                    this.codeBtn.text = this.codeBtn.count + 's';
                    if (this.codeBtn.count < 0) {
                        clearInterval(countdown);
                        this.codeBtn.text = '重新发送';
                        this.codeBtn.waitingCode = false;
                    }
                }, 1000);
            },
            submit(){
                this.$http.get('account.forget',{mobile:this.mobile,nickname:this.nickname,pwd:this.pwd,verifycode:this.verifycode}).
                then((res)=>{
                    this.$utils.toast('重置密码成功')
					this.changeSuccess = true
                    //setTimeout(()=>{this.$Router.back()},500)
                })
            }
        },
        computed: {
            disableCodeBtn: function () {
                return this.codeBtn.waitingCode || this.verifyImgCode.length < 4;
            }
        }
    }
</script>

<style lang="scss" scoped>
	$color-primary: #b49950;
	.content {
		padding: 60rpx 100rpx 100rpx;
	}

	.logo {
		text-align: center;
		image {
			height: 150upx;
			width: 150upx;
			margin: 0 0 40rpx;
		}
	}

	.uni-form-item {
		margin-bottom: 40rpx;
		padding: 0;
		border-bottom: 1px solid #e3e3e3;
		.uni-input {
			margin: 10rpx;
			font-size: 30rpx;
		}
	}

	.column-with-btn {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;
		button {
			font-size: 24rpx;
			margin: 0;
			width: 180rpx;
			text-align: center;
			&:after {
				border: none
			}
			&.active {
				background-color: $color-primary;
				color: $uni-text-color-inverse;
			}
		}
	}

	.img-captcha,.code-captcha{
		width: 180rpx;
		height: 60rpx;
	}

	button[type="primary"] {
		background-color: $color-primary;
		border-radius: 0;
		font-size: 34rpx;
		margin-top: 60rpx;
	}

	.links {
		text-align: center;
		margin-top: 40rpx;
		font-size: 26rpx;
		color: #999;
		view {
			display: inline-block;
			vertical-align: top;
			margin: 0 10rpx;
		}
		.link-highlight {
			color: $color-primary
		}
	}
</style>
