<template>
	<view class="content">
		<view v-if="!changeSuccess">
			<view class="uni-form-item uni-column">
				<input type="password" class="uni-input" v-model="old_password" placeholder="请输入原密码" />
			</view>
			<view class="uni-form-item uni-column">
				<input type="password" class="uni-input" v-model="new_password" placeholder="请输入新密码" />
			</view>
			<view class="uni-form-item uni-column">
				<input type="password" class="uni-input" v-model="check_new_password" placeholder="请输入确认新密码" />
			</view>
			<button type="primary" @tap="submit">确认修改</button>
		</view>
		<view v-if="changeSuccess">
			<view class="text-reset">修改成功，新密码已生效！</view>
			<button type="primary" @tap="$Router.push({name:'login_login'})">立即登录</button>
		</view>
	</view>
</template>

<script>
    export default {
        data() {
            return {
                old_password: '',
                new_password: '',
                check_new_password: '',
                changeSuccess: false
            }
        },
        onLoad() {

        },
		onShow(){
            if(this.changeSuccess==true) this.$Router.push({name:'member_index'})
		},
        methods: {
            submit:function () {
                let params = {
                    old_password:this.old_password,
                    new_password:this.new_password,
                    check_new_password:this.check_new_password
				}
				this.$http.get('member.update_password',params).then((res)=>{
					if(res.error==0){
                        this.$store.commit('logout',true)
                        this.changeSuccess = true
					}
				})
            },
            sendCode: function () {
                this.codeBtn.waitingCode = true;
                this.codeBtn.count = this.seconds;
                this.codeBtn.text = this.codeBtn.count + 's';

                let countdown = setInterval( () => {
                    this.codeBtn.count--;
                    this.codeBtn.text = this.codeBtn.count + 's';
                    if( this.codeBtn.count < 0 ){
                        clearInterval(countdown);
                        this.codeBtn.text = '重新发送';
                        this.codeBtn.waitingCode = false;
                    }
                },1000);
            }
        },
        computed: {
            disableCodeBtn: function (){
                return this.codeBtn.waitingCode || this.captchaImg.length < 4;
            }
        }
    }
</script>

<style lang="scss" scoped>
	$color-primary: #b49950;
	.content{
		padding: 100upx;
	}
	.uni-form-item{
		margin-bottom: 40upx;
		padding: 0;
		border-bottom: 1px solid #e3e3e3;
		.uni-input{
			font-size: 30upx;
			/*padding: 7px 0;*/
		}
	}
	.column-with-btn{
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;
		button{
			font-size: 24upx;
			margin: 0;
			width: 180upx;
			text-align: center;
			&:after{
				border: none
			}
			&.active{
				background-color: $color-primary;
				color: $uni-text-color-inverse;
			}
		}
	}
	.img-captcha{
		width: 150upx;
		height: 60upx;
	}
	button[type="primary"]{
		background-color: $color-primary;
		border-radius: 0;
		font-size: 34upx;
		margin-top: 60upx;
	}
	.text-reset{
		text-align: center;
		margin-bottom: 100upx;
		font-size: 36upx;
	}
</style>
