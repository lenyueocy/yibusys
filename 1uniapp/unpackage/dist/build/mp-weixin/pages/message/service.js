(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/message/service"],{"0043":function(e,t,i){"use strict";i.r(t);var s=i("6b29"),n=i("8ea9");for(var o in n)"default"!==o&&function(e){i.d(t,e,(function(){return n[e]}))}(o);i("e349");var r,c=i("f0c5"),u=Object(c["a"])(n["default"],s["b"],s["c"],!1,null,null,null,!1,s["a"],r);t["default"]=u.exports},"6b29":function(e,t,i){"use strict";var s;i.d(t,"b",(function(){return n})),i.d(t,"c",(function(){return o})),i.d(t,"a",(function(){return s}));var n=function(){var e=this,t=e.$createElement;e._self._c},o=[]},"6fe2":function(e,t,i){"use strict";(function(e){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;n(i("3ba4"));var s=i("2f62");function n(e){return e&&e.__esModule?e:{default:e}}function o(e,t){var i=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),i.push.apply(i,s)}return i}function r(e){for(var t=1;t<arguments.length;t++){var i=null!=arguments[t]?arguments[t]:{};t%2?o(Object(i),!0).forEach((function(t){c(e,t,i[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(i)):o(Object(i)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(i,t))}))}return e}function c(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}var u={components:{},data:function(){return{kefuData:!1,isMsgDown:!1,loadFinish:!1,textMsg:"",isHistoryLoading:!1,scrollAnimation:!1,scrollTop:0,scrollToView:"",msgList:[],myuid:0,RECORDER:e.getRecorderManager(),isVoice:!1,voiceTis:"按住 说话",recordTis:"手指上滑 取消发送",recording:!1,willStop:!1,initPoint:{identifier:0,Y:0},recordTimer:null,recordLength:0,AUDIO:e.createInnerAudioContext(),playMsgid:null,VoiceTimer:null,popupLayerClass:"",hideMore:!0,hideEmoji:!0,emojiList:[{}],emojiPath:"",onlineEmoji:{},windowsState:"",redenvelopeData:{rid:null,from:null,face:null,blessing:null,money:null}}},onLoad:function(e){var t=this;this.initKefu(),this.AUDIO.onEnded((function(e){t.playMsgid=null})),this.RECORDER.onStart((function(e){t.recordBegin(e)})),this.RECORDER.onStop((function(e){t.recordEnd(e)}))},onShow:function(){var t=this;this.scrollTop=9999999,e.getStorage({key:"redEnvelopeData",success:function(i){var s=new Date,n=t.msgList[t.msgList.length-1].msg.id;n++;var o={type:"user",msg:{id:n,type:"redEnvelope",time:s.getHours()+":"+s.getMinutes(),userinfo:{uid:0,username:"大黑哥",face:"/static/img/face.jpg"},content:{blessing:i.data.blessing,rid:Math.floor(1e3*Math.random()+1),isReceived:!1}}};t.screenMsg(o),e.removeStorage({key:"redEnvelopeData"})}})},methods:{initKefu:function(){this.myuid=this.userInfo.id,this.connectService(),this.getMsgList()},connectService:function(){var e={scene:"kefu",pages:"message_service.msgList",type:"login",uniacid:1,token:this.$store.getters.token};"kefu"==this.$Route.query.role&&(e.role="kefu",e.roomid=this.$Route.query.roomid),this.$socket.nsend(JSON.stringify(e))},screenMsg:function(e){var t={scene:"kefu",toUser:"system",uniacid:1,content:1};return this.$socket.nsend(JSON.stringify(t)),!1},loadHistory:function(e){var t=this;if(this.isMsgDown=!1,this.isHistoryLoading)return!1;this.isHistoryLoading=!0,this.scrollAnimation=!1;var i={scene:"kefu",pages:this.$Route.name+".msgList",type:"record",uniacid:1,token:this.$store.getters.token};return"kefu"==this.$Route.query.role&&(i.role="kefu",i.roomid=this.$Route.query.roomid),this.msgList[0]&&(i.content=this.msgList[0]),this.isMsgDown=this.msgList[0]["msg"]["id"],setTimeout((function(){if(t.loadFinish)return t.isMsgDown=!1,t.isHistoryLoading=!1,t.scrollAnimation=!1,t.$utils.toast("无更多聊天记录"),!1;t.$socket.nsend(JSON.stringify(i))}),1e3),!1},getMsgList:function(){var e={scene:"kefu",pages:this.$Route.name+".msgList",type:"record",uniacid:1,token:this.$store.getters.token};return"kefu"==this.$Route.query.role&&(e.role="kefu",e.roomid=this.$Route.query.roomid),this.$socket.nsend(JSON.stringify(e)),!1},setPicSize:function(t){var i=e.upx2px(350),s=e.upx2px(350);if(t.w>i||t.h>s){var n=t.w/t.h;t.w=n>1?i:s*n,t.h=n>1?i/n:s}return t},showMore:function(){this.isVoice=!1,this.hideEmoji=!0,this.hideMore?(this.hideMore=!1,this.openDrawer()):this.hideDrawer()},openDrawer:function(){this.popupLayerClass="showLayer"},hideDrawer:function(){var e=this;this.popupLayerClass="",setTimeout((function(){e.hideMore=!0,e.hideEmoji=!0}),150)},handRedEnvelopes:function(){e.navigateTo({url:"HM-hand/HM-hand"}),this.hideDrawer()},chooseImage:function(t){var i=this;this.hideDrawer(),e.chooseImage({sourceType:[t],sizeType:["original","compressed"],success:function(t){e.getImageInfo({src:t.tempFilePaths[0],success:function(e){var s=t.tempFilePaths[0];i.$http.upload("util.uploader.upload",{filePath:s,name:"file"}).then((function(t){var s=t.files[0].url,n={url:s,w:e.width,h:e.height};i.sendMsg(n,"img")})).catch((function(e){i.$utils.toast("图片上传失败")}))}})}})},textareaFocus:function(){"showLayer"==this.popupLayerClass&&0==this.hideMore&&this.hideDrawer()},sendText:function(){if(this.hideDrawer(),!this.textMsg)return!1;var e={text:this.textMsg};this.sendMsg(e,"text"),this.textMsg=""},replaceEmoji:function(e){var t=this,i=e.replace(/\[([^(\]|\[)]*)\]/g,(function(e,i){for(var s=0;s<t.emojiList.length;s++)for(var n=t.emojiList[s],o=0;o<n.length;o++){var r=n[o];if(r.alt==e){var c=t.emojiPath,u='<img style="width:24px;height:24px;" src="'+c+r.url+'">';return u}}}));return'<div style="align-items: center;word-wrap:break-word;">'+i+"</div>"},sendMsg:function(e,t){var i={scene:"kefu",pages:this.$Route.name+".msgList",type:t,uniacid:1,token:this.$store.getters.token,content:e};return"kefu"==this.$Route.query.role&&(i.role="kefu",i.roomid=this.$Route.query.roomid),this.$socket.nsend(JSON.stringify(i)),!1},addTextMsg:function(e){this.msgList.push(e)},addVoiceMsg:function(e){this.msgList.push(e)},addImgMsg:function(e){e.msg.content=this.setPicSize(e.msg.content),this.msgImgList.push(e.msg.content.url),this.msgList.push(e)},addRedEnvelopeMsg:function(e){this.msgList.push(e)},addSystemTextMsg:function(e){this.msgList.push(e)},addSystemRedEnvelopeMsg:function(e){this.msgList.push(e)},openRedEnvelope:function(t,i){var s=this,n=t.content.rid;e.showLoading({title:"加载中..."}),setTimeout((function(){0==n?s.redenvelopeData={rid:0,from:"大黑哥",face:"/static/img/im/face/face.jpg",blessing:"恭喜发财，大吉大利",money:"已领完"}:(s.redenvelopeData={rid:1,from:"售后客服008",face:"/static/img/im/face/face_2.jpg",blessing:"恭喜发财",money:"0.01"},t.content.isReceived||(s.sendSystemMsg({text:"你领取了"+(t.userinfo.uid==s.myuid?"自己":t.userinfo.username)+"的红包"},"redEnvelope"),s.msgList[i].msg.content.isReceived=!0)),e.hideLoading(),s.windowsState="show"}),200)},closeRedEnvelope:function(){var e=this;this.windowsState="hide",setTimeout((function(){e.windowsState=""}),200)},sendSystemMsg:function(e,t){var i=this.msgList[this.msgList.length-1].msg.id;i++;var s={type:"system",msg:{id:i,type:t,content:e}};this.screenMsg(s)},toDetails:function(t){e.navigateTo({url:"HM-details/HM-details?rid="+t})},showPic:function(t){e.previewImage({indicator:"none",current:t.content.url,urls:this.msgImgList})},playVoice:function(e){this.playMsgid=e.id,this.AUDIO.src=e.content.url,this.$nextTick((function(){this.AUDIO.play()}))},voiceBegin:function(t){var i=this,s=this.$utils.permision.requestAndroidPermission("android.permission.RECORD_AUDIO");if(-1==s)e.showModal({title:"提示",content:"已被拒绝麦克风权限,是否前往打开?",success:function(e){return e.confirm?(i.$utils.permision.gotoAppPermissionSetting(),!1):e.cancel?(i.$utils.toast("麦克风权限被拒绝"),!1):void 0}});else if(0==s)e.showModal({title:"提示",content:"已被拒绝麦克风权限,是否前往打开?",success:function(e){return e.confirm?(i.$utils.permision.gotoAppPermissionSetting(),!1):e.cancel?(i.$utils.toast("麦克风权限被拒绝"),!1):void 0}});else{if(t.touches.length>1)return!1;this.initPoint.Y=t.touches[0].clientY,this.initPoint.identifier=t.touches[0].identifier,this.RECORDER.start({format:"mp3"})}},recordBegin:function(e){var t=this;this.recording=!0,this.voiceTis="松开 结束",this.recordLength=0,this.recordTimer=setInterval((function(){t.recordLength++}),1e3)},voiceCancel:function(){this.recording=!1,this.voiceTis="按住 说话",this.recordTis="手指上滑 取消发送",this.willStop=!0,this.RECORDER.stop()},voiceIng:function(t){if(!this.recording)return!1;var i=t.touches[0];this.initPoint.Y-i.clientY>=e.upx2px(100)?(this.willStop=!0,this.recordTis="松开手指 取消发送"):(this.willStop=!1,this.recordTis="手指上滑 取消发送")},voiceEnd:function(e){if(!this.recording)return!1;this.recording=!1,this.voiceTis="按住 说话",this.recordTis="手指上滑 取消发送",this.RECORDER.stop()},recordEnd:function(t){var i=this;clearInterval(this.recordTimer),this.willStop||this.$http.upload("util.uploader.upload",{filePath:t.tempFilePath,name:"file",params:{type:"voice"}}).then((function(s){var n=s.files[0].url,o=e.createInnerAudioContext();o.src=t.tempFilePath,o.onCanplay((function(e){var t={length:"00:01",url:n},s=Math.ceil(o.duration),r=parseInt(s/60),c=s%60;r=r<10?"0"+r:r,c=c<10?"0"+c:c,t.length=r+":"+c,console.log("msg",t),i.sendMsg(t,"voice")}))})).catch((function(e){console.log("err",e),i.$utils.toast("发送失败")})),this.willStop=!1},switchVoice:function(){this.hideDrawer(),this.isVoice=!this.isVoice},discard:function(){}},computed:r(r({msgImgList:function(){var e=[];return this.msgList.forEach((function(t,i){"img"==t.msg.type&&e.push(t.msg.content.url)})),e}},(0,s.mapState)(["SocketState"])),(0,s.mapGetters)(["userInfo"])),watch:{"SocketState.message_service":{handler:function(e,t){var i=this;Object.keys(e).forEach((function(t){console.log(t,e[t]),i.$set(i,t,e[t])}))},immediate:!0,deep:!0},msgList:function(e,t){var i=this;if(console.log("newVal",e),this.isHistoryLoading=!1,this.scrollAnimation=!1,this.isMsgDown)return this.$nextTick((function(){i.scrollToView="msg"+i.isMsgDown,console.log("isMsgDown",i.scrollToView),i.isMsgDown=!1})),!1;setTimeout((function(){i.$nextTick((function(){i.scrollToView="msg"+(e[e.length-1]?e[e.length-1]["msg"]["id"]:0),console.log("scrollToView",i.scrollToView)}))}),0)},loadFinish:function(e,t){e&&(this.isHistoryLoading=!1,this.scrollAnimation=!1)}}};t.default=u}).call(this,i("543d")["default"])},"848a":function(e,t,i){"use strict";(function(e){i("57ba");s(i("66fd"));var t=s(i("0043"));function s(e){return e&&e.__esModule?e:{default:e}}e(t.default)}).call(this,i("543d")["createPage"])},"8ea9":function(e,t,i){"use strict";i.r(t);var s=i("6fe2"),n=i.n(s);for(var o in s)"default"!==o&&function(e){i.d(t,e,(function(){return s[e]}))}(o);t["default"]=n.a},c543:function(e,t,i){},e349:function(e,t,i){"use strict";var s=i("c543"),n=i.n(s);n.a}},[["848a","common/runtime","common/vendor"]]]);