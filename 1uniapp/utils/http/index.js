/**
 * @version 3.0.4
 */
import Request from 'luch-request'
import $store from '@/utils/store/index'
import {utils} from '@/utils/common'

let baseURL = ''
if(process.env.NODE_ENV === 'development'){
    baseURL = 'https://deng.alijuly.cn/app/ewei_shopv2_api.php'
}else{
    baseURL = 'https://deng.alijuly.cn/app/ewei_shopv2_api.php'
}

const http = new Request()
http.setConfig((config) => {
    config.baseURL = baseURL
    config.dataType = 'json',
    config.sslVerify = false,
    config.header = {
        ...config.header,
    }
    return config
})

http.interceptors.request.use((config) => { /* 请求之前拦截器。可以使用async await 做异步操作 */
    config.header = {
        ...config.header,
    }
    var platform = false
    //#ifdef APP-PLUS
    platform = 'app'
    //#endif
    //#ifdef H5
    platform = 'h5'
    //#endif
    //#ifdef MP-WEIXIN
    platform = 'mp-weixin'
    //#endif
    config.params = {
        ...config.params,
        r: config.url,
        platform: platform,
        system: uni.getSystemInfoSync().platform=='android'?'android':'ios',
        i: 1,
        token: $store.getters.token,
    }
    config.url = ''
    //if (!token) { // 如果token不存在，return Promise.reject(config) 会取消本次请求
    //    return Promise.reject(config)
    //}
    return config
}, (config) => {
    return Promise.reject(config)
})
http.interceptors.response.use(async (response) => { /* 请求之后拦截器。可以使用async await 做异步操作  */
    switch (response.data.error) {
        case -2:
            utils.toast(response.data.message)
            return Promise.reject(response)
            break;
        case 10001:case 10003:
            utils.toast(response.data.message)
            $store.commit('logout',true)
            uni.navigateTo({url: '/pages/login/login'});
            return Promise.reject(response)
            break;
        case 0:
            return response.data
            break;
        default:
            utils.toast(response.data.message)
            return Promise.reject(response)
            break;
    }
    // return Promise.reject(response)
}, (response) => { // 请求错误做点什么。可以使用async await 做异步操作
    //console.log(response)
    return Promise.reject(response)
})

export default http
