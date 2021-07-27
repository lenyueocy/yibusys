/**
 * Created by lenyue on 2021/3/20.
 */
import Vue from 'vue'
import $store from '@/utils/store/index'
import Socket from '@/utils/js_sdk/socket'
import {utils} from '@/utils/common'
const socket = new Socket({
    //url: 'ws://192.168.101.101:9501/', //连接地址 必填
    url: 'ws://192.168.101.101:9501/', //连接地址 必填
    maxInterValCount: 5,
    interValTime: 2000,
    onOpen (res) {
        console.log('全局连接通讯服务器成功')
        utils.toast('全局连接通讯服务器成功')
        /*let msg = {
            scene:'kefu',
            toUser:'all',
            type: 'text',
            nickname: '冷月',
            text: 'login start',
            uniacid: 1,
            time: 123
        };
        this.nsend(JSON.stringify(msg));*/
    },
    onClose(err){
        utils.toast('全局关闭通讯连接')
    },
    onReload(res){
        utils.toast('全局重载通讯连接')
        console.log('重载：' + res)
    },
    onRdFinsh(count) {
        utils.toast(count+'次全局重连通讯服务器')
        console.log(count + '次重连已完成')
    },
    onMsg(msg) {
        utils.toast('收到消息')
        const res = JSON.parse(msg.data);
        console.log('socket_result',res.data)
        //res.pages = "message_service.msgList"
        let action = res.pages.split('.')
        let State = Object.assign({}, $store.state.SocketState[action[0]])
        if(Array.isArray(res.data) && 0){

        }else{
            //let State_tmp = {}
            let State_next = {}
            State_next = State
            for(let i = 1; i < action.length; i++){
                if(i < action.length - 1){
                    //console.log('State_next',State_next)
                    if(!State_next[action[i]]){
                        State_next[action[i]] = {}
                    }else {
                        State_next = State_next[action[i]]
                    }
                }else{
                    if(!State_next[action[i]]) State_next[action[i]] = ['reverse','push'].includes(res.type)?[]:{}
                    if(res.type=='push') State_next[action[i]].push(res.data)
                    else if(res.type=='reverse') State_next[action[i]].unshift(...res.data)
                    else State_next[action[i]] = res.data
                }
            }
            let setData = {}
            setData[action[0]] = State
            console.log('setData',setData)
            $store.commit('setSocketPage',setData)
        }
    }
})
Vue.prototype.$socket = socket;
