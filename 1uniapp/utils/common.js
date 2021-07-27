import Vue from "vue";
import uView from "uview-ui";
import router from './router/index'
import cuCustom from 'uni-colorui/theme/components/cu-custom.vue'
import $http from '@/utils/http/index'
import $store from '@/utils/store/index'
import $uniCopy from '@/utils/js_sdk/uni-copy'
import $permision from '@/utils/js_sdk/permission'
//import $socket from '@/utils/socket/index'

import MescrollBody from "@/components/mescroll-uni/mescroll-body.vue"
import MescrollUni from "@/components/mescroll-uni/mescroll-uni.vue"
import MescrollEmpty from '@/components/mescroll-uni/components/mescroll-empty.vue';

const common = (Vue,app) => {
    Vue.use(uView)
    Vue.component('cu-custom',cuCustom)
    Vue.prototype.$utils = utils
    Vue.prototype.$http = $http
    Vue.prototype.$store = $store
    //Vue.use($socket)
    //Vue.prototype.$socket = $socket

    Vue.component('mescroll-body', MescrollBody)
    Vue.component('mescroll-uni', MescrollUni)
    Vue.component('mescroll-empty', MescrollEmpty)
}

const utils = {
    permision:$permision,
    modal:{
        alert:function (content,title) {
            $store.state.modalAction.status = true
            $store.state.modalAction.cancel = false
            $store.state.modalAction.title = title||'提示'
            $store.state.modalAction.content = content||'提示'
            $store.state.modalAction.confirmCallback = function () {

            }
        },
        confirm:function (content,confirmText,cancelText,title) {
            return new Promise((resolve,reject)=>{
                $store.state.modalAction.status = true
                $store.state.modalAction.cancel = true
                $store.state.modalAction.confirmText = confirmText||'确定'
                $store.state.modalAction.cancelText = cancelText||'取消'
                $store.state.modalAction.content = content||'确认此操作？'
                $store.state.modalAction.confirmCallback = function (res) {
                    if(res) resolve(res)
                    else reject(res)
                }
            })
        }
    },
    previewImage(index,list = [],field = false){
        let urls = []
        if(field){
            list.forEach((item,index)=>{
                urls.push(item[field])
            })
        }
        if(field) list = urls
        uni.previewImage({
            current: index,
            urls: list
        });
    },
    getPlatform:function () {
        let platform = false
        // #ifdef H5
        platform = 'h5'
        // #endif
        // #ifdef MP-WEIXIN
        platform = 'mp-weixin'
        // #endif
        // #ifdef APP-PLUS
        platform = 'app'
        // #endif
        return platform;
    },
    uniCopy:function (content,successMsg,errorMsg) {
        successMsg = successMsg?successMsg:'复制成功！'
        errorMsg = errorMsg?errorMsg:'复制失败！'
        //return new Promise((resolve,reject)=>{})
        $uniCopy({
            content:content,
            success:(res)=>{
                uni.showToast({title: successMsg,icon: 'none'})
            },
            error:(res)=>{
                uni.showToast({title: errorMsg,icon: 'none'})
            }
        })
    },
    checkFloatInput:function (e) {
        //return (e.match(/^\d*(\.?\d{0,2})/g)[0]) || null
        e.target.value = (e.target.value.match(/^\d*(\.?\d{0,2})/g)[0]) || null
        return e.target.value;
    },
    toast:function (title, duration = 1500) {
        uni.showToast({
            title: title,
            icon: 'none',
            duration: duration
        })
    },
    prePage:function(){
        let pages = getCurrentPages();
        let prePage = pages[pages.length - 2];
        // #ifdef H5
        return prePage;
        // #endif
        return prePage.$vm;
    },
    navTo:function (url) {
        let tabArr = ['/pages/index/index','/pages/tabbar/integralmall','/pages/tabbar/luckybag','/pages/tabbar/cart','/pages/member/index']
        if(tabArr.indexOf(url)>=0) router.pushTab({path:url})
        else router.push({path:url})
    },
    is_weixin:function () {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    },
    exit:function(){
        // #ifdef APP-PLUS
        plus.runtime.quit();
        //plus.ios.import("UIApplication").sharedApplication().performSelector("exit")
        // #endif
        // #ifdef H5
        uni.navigateBack()
        // #endif
    },
    weixinPay:function (payInfo) {
        let platform = ''
        // #ifdef H5
        platform = 'h5'
        // #endif
        // #ifdef MP-WEIXIN
        platform = 'mp-weixin'
        // #endif
        // #ifdef APP-PLUS
        platform = 'app'
        // #endif
        return new Promise((resolve,reject)=>{
            if(platform == 'app'){
                var webView = plus.webview.create(decodeURIComponent(payInfo.mweb_url), 'id_webview_h5_pay', {additionalHttpHeaders:{Referer:$http.config.baseURL}})
                webView.addEventListener('loaded', function() {
                    resolve(false)
                }, false);
            }
            if(platform == 'mp-weixin'){
                uni.requestPayment({
                    provider: 'wxpay',
                    timeStamp: payInfo.timeStamp,
                    nonceStr: payInfo.nonceStr,
                    package: payInfo.package,
                    signType: payInfo.signType,
                    paySign: payInfo.paySign,
                    success:  (res) => {
                        resolve(res)
                    },
                    fail: (err) => {
                        reject(err)
                    }
                });
            }
            if(platform == 'h5'){
                if (this.is_weixin()) {
                    var jweixin = require('jweixin-module');
                    jweixin.config({
                        //debug: true,
                        appId: payInfo.sdkConfig.appId,
                        timestamp: payInfo.sdkConfig.timestamp,
                        nonceStr: payInfo.sdkConfig.nonceStr,
                        signature:payInfo.sdkConfig.signature,
                        jsApiList: ['chooseWXPay', 'updateTimelineShareData']
                    });
                    jweixin.ready(function() {
                        jweixin.chooseWXPay({
                            timestamp: payInfo.timeStamp,
                            nonceStr: payInfo.nonceStr,
                            package: payInfo.package,
                            signType: payInfo.signType,
                            paySign: payInfo.paySign,
                            success(res) {
                                resolve(res)
                                cb(res);
                            },
                            fail(err) {
                                reject(err)
                                errorCb(err)
                            }
                        });
                    });
                    jweixin.error(function(res) {
                        reject(res)
                    });
                } else {
                    window.location.href = payInfo.mweb_url;
                }
            }
        })

    },
    wxLogin: function (to,next){
        // #ifdef H5
        if (!this.is_weixin()) {return false;}
        var params = {code:to.query.code}
        if(to.query.share_openid) params.share_openid = to.query.share_openid
        if(to.query.code){
            $http.get('account.wxLogin',params).then(function (res) {
                if(res.error==0){
                    if(res.member){
                        $store.commit('login',res)
                        uni.showToast({title:'微信登录成功',icon:'none'})
                        next()
                    }else{
                        uni.setStorageSync('wx_info',res);
                        const params = {}
                        //const params = { unionid:res.unionid,nickname:res.nickname,headimgurl:res.headimgurl }
                        if(to.query.share_openid) params.share_openid = to.query.share_openid
                        if(to.query.mobile) params.agent_mobile = to.query.mobile
                        next({
                            name: 'login_bidding',
                            params: params,
                            NAVTYPE: 'push'
                        });
                    }

                }else{
                    uni.showToast({title:'微信登录失败！',icon:'none'})
                    next()
                }
            }).catch((err)=>{
                uni.showToast({title:'微信登录失败！',icon:'none'})
                next()
            })
        }else{
            //var redirect_uri = encodeURIComponent(window.location.href)
            var state = 123
            var redirect_uri = window.location.href
            // var redirect_uri = "https://www.99dingdong.com/h5/pages/goods/detail?id=45&share_openid=wap_user_1_17674116668"
            var params_num = 0;
            for(var item in to.query){ params_num++ }
            redirect_uri = redirect_uri + (params_num>0?'&':'?') + "platform=h5"
            //if(to.query.share_openid) redirect_uri = redirect_uri + "&share_openid=" + to.query.share_openid
            state = encodeURIComponent(JSON.stringify(state))
            redirect_uri = encodeURIComponent(redirect_uri)
            var callback_url = encodeURIComponent("https://appstore.bai918.com/app/tiao.php?callback_url="+redirect_uri)
            var wxLoginUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx08d9cd235b4ff504&redirect_uri="+callback_url+"&response_type=code&scope=snsapi_userinfo&state="+state+"#wechat_redirect"
            location.href = wxLoginUrl
            next()
        }
        // #endif
    }
}
export {common,utils}
