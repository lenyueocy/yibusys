<template>
    <view class="page">
        <view class="text-sm text-center padding-tb-sm margin-bottom-xl" style="color:#666;" v-if="hasLogin"></view>
        <view class="text-sm text-center padding-tb-sm margin-bottom-xl" style="color:#666;" v-else>如曾注册过云福袋商城账号请绑定原账号</view>
        <view class="uni-form-item uni-column">
            <input v-model="mobile" type="number" class="uni-input" placeholder="请输入手机号" />
        </view>
        <view class="uni-form-item uni-column column-with-btn" v-if="mobile.length==11">
            <input v-model="verifyImgCode" type="text" class="uni-input" placeholder="请输入图片验证码" />
            <image :src="baseURL+'?mobile='+mobile+'&r=sms.captcha&i=1&random='+random" @click="random = Math.random()" class="img-captcha" ></image>
        </view>
        <view class="uni-form-item uni-column column-with-btn">
            <input v-model="verifycode" type="number" class="uni-input" placeholder="请输入验证码"/>
            <button :class="{active : !disableCodeBtn}" :disabled="disableCodeBtn" @tap="sendCode" class="code-captcha flex align-center justify-center">{{codeBtn.text}}</button>
        </view>

        <view v-if="hasLogin">
            <button class="cu-btn round block lg" type="primary" @click="submit('bind')">确定</button>
        </view>
        <view v-else>
            <button class="cu-btn round block lg" type="primary" @click="submit('old')">绑定原账号</button>
            <view @click="checkSubmit" class="text-center margin-top-xl">注册新账号</view>
        </view>

        <!-- 推荐人模块 -->
        <view class="cu-modal" :class="{'show':showModal}">
            <view class="cu-dialog">
                <view class="cu-bar bg-white justify-end">
                    <view class="content">推荐人</view>
                    <view class="action" @tap="showModal=false">
                        <text class="cuIcon-close text-red"></text>
                    </view>
                </view>
                <view class="padding-xl">
                    <view class="">
                        <input placeholder="请输入推荐人" name="input" v-model="invitationcode" >
                    </view>
                </view>
                <view class="cu-bar bg-white flex padding-lr-lg">
                    <button class="cu-btn round " @tap="submit('new')" style="width: 40%;color: #666;">没有推荐人</button>
                    <button class="cu-btn round bg-button" @tap="submit('new')" style="width: 40%;">确定</button>
                </view>
            </view>
        </view>

        <!-- 获取微信手机号码弹窗 -->
        <view class="cu-modal" :class="{'show':getMobileModal}">
            <view class="cu-dialog">
                <view class="cu-bar bg-white justify-end">
                    <view class="content">获取微信手机号码</view>
                    <!--<view class="action" @tap="showModal=false">
                        <text class="cuIcon-close text-red"></text>
                    </view>-->
                </view>
                <!--<view class="padding-sm bg-white text-lg">
                    <view class="">需要获取微信手机号码?</view>
                </view>-->
                <view class="cu-bar bg-white flex padding-lr-lg">
                    <button class="cu-btn round " @tap="getMobileModal=false" style="width: 40%;color: #666;">取消</button>
                    <button class="cu-btn round bg-button" open-type="getPhoneNumber" @getphonenumber="getPhoneNumber" style="width: 40%;">获取</button>
                </view>
            </view>
        </view>

    </view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    export default {
        data() {
            return {
                mobile: '',
                pwd: '',
                verifycode: '',
                verifyImgCode: '',
                invitationcode: '',
                random: Math.random(),
                seconds: 60,
                baseURL: this.$http.config.baseURL,
                codeBtn: {
                    text: '获取验证码',
                    waitingCode: false,
                    count: this.seconds
                },
                showModal: false,
                getMobileModal: false,
            }
        },
        onLoad() {

        },
        onShow(){

        },
        computed: {
            ...mapState(['modalAction']),
            ...mapGetters(['hasLogin','userInfo','tabbarIndex']),
        },
        methods: {
            sendCode: function () {
                this.$http.get('sms.register',{mobile:this.mobile,verifyImgCode:this.verifyImgCode}).
                then((res)=>{
                    this.$utils.toast('验证码发送成功')
                    this.startCodeTime()
                })
            },
            startCodeTime:function () {
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
            checkSubmit:function () {
                this.showModal = true
            },
            getPhoneNumber: function(e) {
                if (e.detail.errMsg == 'getPhoneNumber:ok') {
                    this.$http.get('account.bidMobile', {encryptedData:e.detail.encryptedData,iv:e.detail.iv}).then((res)=>{
                        if(res.error==0){
                            this.$store.commit('updateUserInfo',{mobile:res.data.mobile})
                            uni.showToast({icon: 'none',position: 'bottom',title: '绑定手机号码成功'});
                            setTimeout(()=>{this.$Router.back(1)},1500)
                        }
                    })
                } else {

                }
            },
            submit:function (type) {
                this.showModal = false
                var params = {}
                if(type=='bind'){

                }else{
                    var wx_info = uni.getStorageSync('wx_info');
                    if(!wx_info.unionid) {
                        this.$utils.toast('微信授权出错,请重新授权')
                        return false;
                    }
                    params = wx_info
                }
                params.type = type
                params.mobile = this.mobile
                params.verifycode = this.verifycode
                if(this.invitationcode) params.invitationcode = this.invitationcode
                if(this.$Route.query.share_openid) params.share_openid = this.$Route.query.share_openid
                this.$http.get('account.bidMobile', params).then((res)=>{
                    if(res.error==0){
                        if(type=='bind'){
                            this.$store.commit('updateUserInfo',{mobile:this.mobile})
                            uni.showToast({icon: 'none',position: 'bottom',title: '绑定手机号码成功'});
                            setTimeout(()=>{this.$Router.back(1)},1500)
                        }else{
                            this.$store.commit('login',res)
                            uni.showToast({icon: 'none',position: 'bottom',title: '登录成功'});
                            this.$Router.back(1)
                        }
                    }
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    $color-primary: #b49950;
    .page {
        background-color: #fff;
        min-height: 100vh;
        padding: 0rpx 80rpx 80rpx;
    }
    .bg-button{
        color: #fff;
        background-color: $color-primary;
    }
    .cuIcon-close{
        color: $color-primary;
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
