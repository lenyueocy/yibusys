<template>
    <view class="container">
        <view class="tui-page-title">绑定手机号码</view>
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
            </view>
            <view class="tui-btn-box"><tui-button :disabledGray="true" :disabled="disabled" :shadow="true" shape="circle" @click="submit">确定</tui-button></view>
        </view>
    </view>
</template>

<script>
export default {
    computed: {
        disabled: function() {
            let bool = true;
            if (this.mobile && this.verifycode) {
                bool = false;
            }
            return bool;
        }
    },
    data() {
        return {
            successVal: 0,
            resetVal: 0,
            mobile: '',
            verifycode: '',
            isSend: false,
            btnSendText: '获取验证码' //倒计时格式：(60秒)
        };
    },
    methods: {
        inputCode(e) {
            this.verifycode = e.detail.value;
        },
        inputMobile: function(e) {
            this.mobile = e.detail.value;
        },
        clearInput() {
            this.mobile = '';
        },
        send(e){
            if(!/^[1][3,4,5,6,7,8,9][0-9]{9}$/.exec(this.mobile)){
                this.resetVal++
                this.$utils.toast('请输入正确的手机号码')
                return false;
            }
            this.$http.get('sms.changemobile',{mobile:this.mobile}).then((res)=>{
                if(res.code) this.$utils.toast('您的验证码为：'+res.code)
                this.successVal++
            })
        },
        submit(){
            this.$http.get('account.changemobile',{mobile:this.mobile,verifycode:this.verifycode,token:this.$store.getters.token}).then((res)=>{
                this.$store.commit('set',{hasLogin:true})
                this.$utils.toast('绑定成功')
                setTimeout(()=>{
                    this.$Router.replace({name:'index_index'})
                },1500)
            })
        },
        end(){

        }
    }
};
</script>

<style lang="scss">
    page{
        background: #fff;
    }
    .container {
        .tui-page-title {
            width: 100%;
            font-size: 48rpx;
            font-weight: bold;
            color: $uni-text-color;
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
                        color: $uni-color-primary;
                    }
                    .tui-gray {
                        color: $uni-text-color-placeholder;
                    }
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
