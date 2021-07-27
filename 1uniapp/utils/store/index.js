import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import {index} from 'utils/store/tabbar';
import $router from 'utils/router/index'
import $http from 'utils/http/index'
//import manifest from '../../manifest'

let uploadUrl = "http://deng.alijuly.cn/app/ewei_shopv2_api.php?r=util.uploader.upload"
const store = new Vuex.Store({
    state: {
        uploadUrl: uploadUrl,
        hasLogin: false,
        statusBar: 0,
        CustomBar: 0,
        is_agreement:false,
        userInfo: {},
        forcedLogin: false,
        userName: "",
        userId: '',
        token: '',
        pointId: '',
        tabbarData:{},
        app:{},
        modalAction:{status:false,content:'',cancel:false,confirmCallback:{}},
        version:'',//versionName
        tabbarIndex: index,
        SocketState:{
            message_service:{msgList:[],loadFinish:false}
        },
    },
    getters: {
        posterImage:function (state) {
            if(uni.getStorageSync('posterImage')) state.posterImage = uni.getStorageSync('posterImage')
            return state.posterImage;
        },
        token:function(state){
            if(uni.getStorageSync('token')) state.token = uni.getStorageSync('token')
            return state.token;
        },
        hasLogin:function(state){
            if(uni.getStorageSync('hasLogin')) state.hasLogin = uni.getStorageSync('hasLogin')
            return state.hasLogin;
        },
        userInfo:(state)=>{
            if(uni.getStorageSync('userInfo')) state.userInfo = uni.getStorageSync('userInfo')
            return state.userInfo
        },
        is_agreement:(state,type)=>{
            if(uni.getStorageSync('is_agreement')) state.is_agreement = uni.getStorageSync('is_agreement')
            return state.is_agreement
        },
        tabbarIndex:(state)=>{
            return index
        },
        version:(state)=>{
            if(uni.getStorageSync('version')) state.version = uni.getStorageSync('version')
            var version = state.version
            // #ifdef H5 || MP-WEIXIN
            const manifest = require('@/manifest')
            version = manifest.versionName
            // #endif
            // #ifdef APP-PLUS
            version = plus.runtime.version
            // #endif
            if(version && version!=state.version){
                uni.setStorageSync('version',version)
                state.version = version
            }
            return state.version
        },
    },
    mutations: {
        set: (state,objs)=>{
            var key = Object.keys(objs)[0]
            state[key] = objs[key]
            uni.setStorageSync(key,objs[key])
        },
        get: (state,key)=>{
            if(uni.getStorageSync(key)) state[key] = uni.getStorageSync(key)
            return state[key];
        },
        setSocketPage: (state,objs)=>{
            //state['SocketState']['message_service'] = {a:1,b:2}
            //console.log('setSocketPage',objs)
            console.log('objs',objs)
            var key = Object.keys(objs)[0]
            Object.keys(objs[key]).forEach((index)=>{
                console.log('index111',index)
                console.log('index222',objs[key][index])
                if(!state[key]) state[key] = {}
                state['SocketState'][key][index] = objs[key][index]
                /*if(index=='msgList'){
                }else{
                    state['SocketState']['message_service']['loadFinish'] = true
                }*/
            })
            //state.SocketState.message_service.loadFinish = true
            console.log('setSocketPage111',state)
            //var key2 = Object.keys(objs[key])[0]
            //if(!state[key]) state[key] = {}
            //state[key][key2] = objs[key][key2]
        },
        updateUserInfo: (state,objs)=>{
            var key = Object.keys(objs)[0]
            state['userInfo'][key] = objs[key]
            uni.setStorageSync('userInfo',state.userInfo)
        },
        login: (state, data)=>{
            state.hasLogin = true
            state.token = data.token
            state.userInfo = data.member || {}
            uni.setStorageSync('hasLogin',true)
            uni.setStorageSync('token',data.token)
            uni.setStorageSync('userInfo',data.member)
            // #ifdef APP-PLUS
            plus.push.getClientInfoAsync((info)=>{
                $http.get('member.info.setClientId',{clientid:info.clientid}).then((res)=>{})
            }, (err)=>{});
            // #endif
        },
        clearCache: (state,status)=>{
            if(status){
                uni.clearStorageSync()
            }else{
                const hasLogin = state.hasLogin
                const token = state.token
                const userInfo = state.userInfo
                uni.clearStorageSync()
                uni.setStorageSync('hasLogin',hasLogin)
                uni.setStorageSync('token',token)
                uni.setStorageSync('userInfo',userInfo)
            }
        },
        logout: (state,type)=>{
            if(type !== true){
                state.modalAction.status = true
                state.modalAction.cancel = true
                state.modalAction.content = '确认退出登录？'
                state.modalAction.confirmCallback = function () {
                    state.hasLogin = false
                    state.token = ''
                    state.userInfo = {}
                    uni.removeStorageSync('hasLogin')
                    uni.removeStorageSync('token')
                    uni.removeStorageSync('userInfo')
                    $router.push({name:'login_login'})
                }
            }else{
                state.hasLogin = false
                state.token = ''
                state.userInfo = {}
                uni.removeStorageSync('hasLogin')
                uni.removeStorageSync('token')
                uni.removeStorageSync('userInfo')
            }
        }




    }
})
export default store