<template>
	<view>
		<view class="content" @touchstart="hideDrawer">
			<scroll-view class="msg-list" scroll-y="true" :scroll-with-animation="scrollAnimation" :scroll-top="scrollTop" :scroll-into-view="scrollToView" @scrolltoupper="loadHistory" upper-threshold="50">
				<!-- 加载历史数据waitingUI -->
				<view class="loading" v-if="isHistoryLoading">
					<view class="spinner">
						<view class="rect1"></view>
						<view class="rect2"></view>
						<view class="rect3"></view>
						<view class="rect4"></view>
						<view class="rect5"></view>
					</view>
				</view>
				<view class="row" v-for="(row,index) in msgList" :key="index" :id="'msg'+row.msg.id">
					<!-- 系统消息 -->
					<block v-if="row.type=='system'" >
						<view class="system">
							<!-- 文字消息 -->
							<view v-if="row.msg.type=='text'" class="text">
								{{row.msg.content.text}}
							</view>
							<!-- 领取红包消息 -->
							<view v-if="row.msg.type=='redEnvelope'" class="red-envelope">
								<image src="/static/chat/emoticon/red-envelope-chat.png"></image>
								{{row.msg.content.text}}
							</view>
						</view>
					</block>
					<!-- 用户消息 -->
					<block v-if="row.type=='user'">
						<!-- 自己发出的消息 -->
						<view class="my" v-if="row.msg.userinfo.uid == myuid">
							<!-- 左-消息 -->
							<view class="left">
								<!-- 文字消息 -->
								<view v-if="row.msg.type=='text'" class="bubble">
									<rich-text :nodes="row.msg.content.text"></rich-text>
								</view>
								<!-- 语言消息 -->
								<view v-if="row.msg.type=='voice'" class="bubble voice" @tap="playVoice(row.msg)" :class="playMsgid == row.msg.id?'play':''">
									<view class="length">{{row.msg.content.length}}</view>
									<view class="icon my-voice"></view>
								</view>
								<!-- 图片消息 -->
								<view v-if="row.msg.type=='img'" class="bubble img" @tap="showPic(row.msg)">
									<image :src="row.msg.content.url" :style="{'width': row.msg.content.w+'px','height': row.msg.content.h+'px'}"></image>
								</view>
								<!-- 红包 -->
								<view v-if="row.msg.type=='redEnvelope'" class="bubble red-envelope" @tap="openRedEnvelope(row.msg,index)">
									<image src="/static/chat/emoticon/red-envelope.png"></image>
									<view class="tis">
										<!-- 点击开红包 -->
									</view>
									<view class="blessing">
										{{row.msg.content.blessing}}
									</view>
								</view>

							</view>
							<!-- 右-头像 -->
							<view class="right">
								<image :src="row.msg.userinfo.face"></image>
							</view>
						</view>
						<!-- 别人发出的消息 -->
						<view class="other" v-if="row.msg.userinfo.uid!=myuid" style="display: inline-block;">
							<view class="username text-sm flex" style="padding:0rpx 0rpx 10rpx 105rpx;">
								<view class="name">{{row.msg.userinfo.username}}</view>
								<view class="time margin-left-lg">{{row.msg.time}}</view>
							</view>
							<view class="flex">
							<!-- 左-头像 -->
							<view class="left">
								<image :src="row.msg.userinfo.face"></image>
							</view>
							<!-- 右-用户名称-时间-消息 -->
							<view class="right">
								<!--<view class="username">
									<view class="name">{{row.msg.userinfo.username}}</view>
									<view class="time">{{row.msg.time}}</view>
								</view>-->
								<!-- 文字消息 -->
								<view v-if="row.msg.type=='text'" class="bubble">
									<rich-text :nodes="row.msg.content.text"></rich-text>
								</view>
								<!-- 语音消息 -->
								<view v-if="row.msg.type=='voice'" class="bubble voice" @tap="playVoice(row.msg)" :class="playMsgid == row.msg.id?'play':''">
									<view class="icon other-voice"></view>
									<view class="length">{{row.msg.content.length}}</view>
								</view>
								<!-- 图片消息 -->
								<view v-if="row.msg.type=='img'" class="bubble img" @tap="showPic(row.msg)">
									<image :src="row.msg.content.url" :style="{'width': row.msg.content.w+'px','height': row.msg.content.h+'px'}"></image>
								</view>
								<!-- 红包 -->
								<view v-if="row.msg.type=='redEnvelope'" class="bubble red-envelope" @tap="openRedEnvelope(row.msg,index)">
									<image src="/static/chat/emoticon/red-envelope.png"></image>
									<view class="tis">
										<!-- 点击开红包 -->
									</view>
									<view class="blessing">
										{{row.msg.content.blessing}}
									</view>
								</view>
							</view>
							</view>
						</view>
					</block>
				</view>
			</scroll-view>
		</view>
		<!-- 抽屉栏 -->
		<view class="popup-layer" :class="popupLayerClass" @touchmove.stop.prevent="discard">
			<!-- 表情 -->
			<!-- <swiper class="emoji-swiper"
			@animationfinish="moveend($event)"
			:class="{hidden:hideEmoji}"
			indicator-dots="true"
			duration="150"
			:current="dotsCurrent"
			>
				<swiper-item v-for="(page,pid) in emojiList" :key="pid">
					<view v-for="(em,eid) in page" :key="eid" @tap="addEmoji(em)">
						<image mode="widthFix" :src="'/static/img/emoji/'+em.url"></image>
					</view>
				</swiper-item>
			</swiper> -->
			<!--<emotion @addEmoji="addEmoji" :class="{hidden:hideEmoji}" ></emotion>-->
			<!-- 更多功能 相册-拍照-红包 -->
			<view class="more-layer" :class="{hidden:hideMore}">
				<view class="list">
					<view class="box" @tap="chooseImage('album')"><view class="icon tupian2"></view></view>
					<view class="box" @tap="chooseImage('camera')"><view class="icon paizhao"></view></view>
				</view>
			</view>
		</view>
		<!-- 底部输入栏 -->
		<view class="input-box" :class="popupLayerClass" @touchmove.stop.prevent="discard">
			<!-- H5下不能录音，输入栏布局改动一下 -->
			<!-- #ifndef H5 -->
			<view class="voice">
				<view class="icon" :class="isVoice?'jianpan':'yuyin'" @tap="switchVoice"></view>
			</view>
			<!-- #endif -->
			<!-- #ifdef H5 -->
			<view class="more" @tap="showMore">
				<view class="icon add"></view>
			</view>
			<!-- #endif -->
			<view class="textbox">
				<view class="voice-mode" :class="[isVoice?'':'hidden',recording?'recording':'']" @touchstart="voiceBegin" @touchmove.stop.prevent="voiceIng" @touchend="voiceEnd" @touchcancel="voiceCancel">{{voiceTis}}</view>
				<view class="text-mode"  :class="isVoice?'hidden':''">
					<view class="box">
						<textarea auto-height="true" v-model="textMsg" @focus="textareaFocus"/>
					</view>
					<!--<view class="em" >&lt;!&ndash;@tap="chooseEmoji"&ndash;&gt;
						<view class="icon biaoqing"></view>
					</view>-->
				</view>
			</view>
			<!-- #ifndef H5 -->
			<view class="more" @tap="showMore">
				<view class="icon add"></view>
			</view>
			<!-- #endif -->
			<view class="send" :class="isVoice?'hidden':''" @tap="sendText">
				<view class="btn">发送</view>
			</view>
		</view>
		<!-- 录音UI效果 -->
		<view class="record" :class="recording?'':'hidden'">
			<view class="ing" :class="willStop?'hidden':''"><view class="icon luyin2" ></view></view>
			<view class="cancel" :class="willStop?'':'hidden'"><view class="icon chehui" ></view></view>
			<view class="tis" :class="willStop?'change':''">{{recordTis}}</view>
		</view>
		<!-- 红包弹窗 -->
		<view class="windows" :class="windowsState">
			<!-- 遮罩层 -->
			<view class="mask" @touchmove.stop.prevent="discard" @tap="closeRedEnvelope"></view>
			<view class="layer" @touchmove.stop.prevent="discard">
				<view class="open-redenvelope">
					<view class="top">
						<view class="close-btn">
							<view class="icon close" @tap="closeRedEnvelope"></view>
						</view>
						<image src="/static/img/im/face/face_1.jpg"></image>
					</view>
					<view class="from">来自{{redenvelopeData.from}}</view>
					<view class="blessing">{{redenvelopeData.blessing}}</view>
					<view class="money">{{redenvelopeData.money}}</view>
					<view class="showDetails" @tap="toDetails(redenvelopeData.rid)">
						查看领取详情 <view class="icon to"></view>
					</view>
				</view>
			</view>

		</view>
	</view>
</template>
<script>
    //import emotion from '@/components/emotion/index.vue'
    import emojiData from "@/utils/js_sdk/emojiData.js"
    import {mapMutations,mapState,mapGetters} from 'vuex'
    export default {
        components: {
            //emotion
        },
        data() {
            return {
                kefuData:false,
				isMsgDown:false,
				loadFinish:false,
                //文字消息
                // dotsCurrent:1,
                textMsg:'',
                //消息列表
                isHistoryLoading:false,
                scrollAnimation:false,
                scrollTop:0,
                scrollToView:'',
                msgList:[],
                //msgImgList:[],
                myuid:0,

                //录音相关参数
                // #ifndef H5
                //H5不能录音
                RECORDER:uni.getRecorderManager(),
                // #endif
                isVoice:false,
                voiceTis:'按住 说话',
                recordTis:"手指上滑 取消发送",
                recording:false,
                willStop:false,
                initPoint:{identifier:0,Y:0},
                recordTimer:null,
                recordLength:0,

                //播放语音相关参数
                AUDIO:uni.createInnerAudioContext(),
                playMsgid:null,
                VoiceTimer:null,
                // 抽屉参数
                popupLayerClass:'',
                // more参数
                hideMore:true,
                //表情定义
                hideEmoji:true,
                emojiList:[{}],
                emojiPath:'',
                //表情图片图床名称 ，由于我上传的第三方图床名称会有改变，所以有此数据来做对应，您实际应用中应该不需要
                onlineEmoji:{},
                //红包相关参数
                windowsState:'',
                redenvelopeData:{
                    rid:null,	//红包ID
                    from:null,
                    face:null,
                    blessing:null,
                    money:null
                }
            };
        },
        onLoad(option) {
			this.initKefu()
            //语音自然播放结束
            this.AUDIO.onEnded((res)=>{ this.playMsgid = null; });
            // #ifndef H5
            //录音开始事件
            this.RECORDER.onStart((e)=>{ this.recordBegin(e); })
            //录音结束事件
            this.RECORDER.onStop((e)=>{ this.recordEnd(e); })
            // #endif
            //this.emojiList = emojiData.imgArr[1].emojiList
        },

        onShow(){
            this.scrollTop = 9999999;

            //模板借由本地缓存实现发红包效果，实际应用中请不要使用此方法。
            uni.getStorage({
                key: 'redEnvelopeData',
                success: (res)=>{
                    // console.log(res.data);
                    let nowDate = new Date();
                    let lastid = this.msgList[this.msgList.length-1].msg.id;
                    lastid++;
                    let row = {type:"user",msg:{id:lastid,type:"redEnvelope",time:nowDate.getHours()+":"+nowDate.getMinutes(),userinfo:{uid:0,username:"大黑哥",face:"/static/img/face.jpg"},content:{blessing:res.data.blessing,rid:Math.floor(Math.random()*1000+1),isReceived:false}}};
                    this.screenMsg(row);
                    uni.removeStorage({key: 'redEnvelopeData'});
                }
            });
        },
        methods:{
            initKefu(){
                this.myuid = this.userInfo.id
                this.connectService()
                this.getMsgList();
			},
			connectService(){
                let msg = {scene:'kefu',pages:'message_service.msgList',type:'login',uniacid:1,token:this.$store.getters.token}
                if(this.$Route.query.role == 'kefu') {
                    msg.role = 'kefu'
                    msg.roomid = this.$Route.query.roomid
                }
                this.$socket.nsend(JSON.stringify(msg))
			},
            screenMsg(msg){
				let sendMsg = {scene:'kefu',toUser:'system',uniacid:1,content:1}
                this.$socket.nsend(JSON.stringify(sendMsg))
			    return false;
                //从长连接处转发给这个方法，进行筛选处理
                if(msg.type=='system'){
                    switch (msg.msg.type){
                        case 'text':
                            this.addSystemTextMsg(msg);
                            break;
                        case 'redEnvelope':
                            this.addSystemRedEnvelopeMsg(msg);
                            break;
                    }
                }else if(msg.type=='user'){
                    switch (msg.msg.type){
                        case 'text':
                            this.msgList.push(msg);
                            break;
                        case 'voice':
                            this.msgList.push(msg);
                            break;
                        case 'img':
                            this.addImgMsg(msg);
                            break;
                        case 'redEnvelope':
                            this.addRedEnvelopeMsg(msg);
                            break;
                    }
                    //非自己的消息震动
                    if(msg.msg.userinfo.uid!=this.myuid){
                        // console.log('振动');
                        uni.vibrateLong();
                    }
                }
                this.$nextTick(function() {
                    // 滚动到底
                    this.scrollToView = 'msg'+msg.msg.id
                });
            },
            //触发滑动到顶部(加载历史信息记录)
            loadHistory(e){
                this.isMsgDown = false
                if(this.isHistoryLoading) return false;
                this.isHistoryLoading = true;
                this.scrollAnimation = false;

                let msg = {scene:'kefu',pages:this.$Route.name+'.msgList',type:'record',uniacid:1,token:this.$store.getters.token}
                if(this.$Route.query.role == 'kefu') {
                    msg.role = 'kefu'
                    msg.roomid = this.$Route.query.roomid
                }
                if(this.msgList[0]){
                    msg.content = this.msgList[0]
				}

                this.isMsgDown = this.msgList[0]['msg']['id']
                setTimeout(()=>{
                    if(this.loadFinish){
                        this.isMsgDown = false
                        this.isHistoryLoading = false;
                        this.scrollAnimation = false;
                        this.$utils.toast('无更多聊天记录')
                        return false;
                    }
                    this.$socket.nsend(JSON.stringify(msg))
				},1000)
                return false;
                if(this.isHistoryLoading) return false;
                this.isHistoryLoading = true;//参数作为进入请求标识，防止重复请求
                this.scrollAnimation = false;//关闭滑动动画
                let Viewid = this.msgList[0].msg.id;//记住第一个信息ID
                //本地模拟请求历史记录效果
                setTimeout(()=>{
                    let msg = {scene:'kefu',pages:this.$Route.name+'.msgList',type:'record',uniacid:1,token:this.$store.getters.token}
                    if(this.$Route.query.role == 'kefu') {
                        msg.role = 'kefu'
                        msg.roomid = this.$Route.query.roomid
                    }
                    this.$socket.nsend(JSON.stringify(msg))
                    // 消息列表
                    let list = [
                        //{type:"user",msg:{id:1,type:"text",time:"12:56",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/face.jpg"},content:{text:"为什么温度会相差那么大？"}}},
                        //{type:"user",msg:{id:2,type:"text",time:"12:57",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/face/face_2.jpg"},content:{text:"这个是有偏差的，两个温度相差十几二十度是很正常的，如果相差五十度，那即是质量问题了。"}}},
                        //{type:"user",msg:{id:3,type:"voice",time:"12:59",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/face/face_2.jpg"},content:{url:"/static/voice/1.mp3",length:"00:06"}}},
                        //{type:"user",msg:{id:4,type:"voice",time:"13:05",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/face.jpg"},content:{url:"/static/voice/2.mp3",length:"00:06"}}},
                    ]
                    // 获取消息中的图片,并处理显示尺寸
                    for(let i=0;i<list.length;i++){
                        if(list[i].type=='user'&&list[i].msg.type=="img"){
                            list[i].msg.content = this.setPicSize(list[i].msg.content);
                            this.msgImgList.unshift(list[i].msg.content.url);
                        }
                        list[i].msg.id = Math.floor(Math.random()*1000+1);
                        this.msgList.unshift(list[i]);
                    }

                    //这段代码很重要，不然每次加载历史数据都会跳到顶部
                    this.$nextTick(function() {
                        this.scrollToView = 'msg'+Viewid;//跳转上次的第一行信息位置
                        this.$nextTick(function() {
                            this.scrollAnimation = true;//恢复滚动动画
                        });

                    });
                    this.isHistoryLoading = false;

                },1000)
            },
            //初始化页面时获取前10条信息
            getMsgList(){
                let msg = {scene:'kefu',pages:this.$Route.name+'.msgList',type:'record',uniacid:1,token:this.$store.getters.token}
                if(this.$Route.query.role == 'kefu') {
                    msg.role = 'kefu'
                    msg.roomid = this.$Route.query.roomid
                }
                this.$socket.nsend(JSON.stringify(msg))
                /*this.$nextTick(() => {
                    //进入页面滚动到底部
                    this.scrollTop = 9999;
                    this.$nextTick(() => {
                        this.scrollAnimation = true;
                    });

                });
                setTimeout(()=>{
                    this.scrollTop = 9999;
                    this.$nextTick(() => {
                        this.scrollAnimation = true;
                    });
				},3000)*/
				return false;
                let list = [
                    {type:"system",msg:{id:0,type:"text",content:{text:"欢迎进入聊天室"}}},
                    {type:"user",msg:{id:1,type:"text",time:"12:56",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/face.jpg"},content:{text:"为什么温度会相差那么大？"}}},
                    {type:"user",msg:{id:2,type:"text",time:"12:57",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/im/face/face_2.jpg"},content:{text:"这个是有偏差的，两个温度相差十几二十度是很正常的，如果相差五十度，那即是质量问题了。"}}},
                    {type:"user",msg:{id:3,type:"voice",time:"12:59",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/im/face/face_2.jpg"},content:{url:"/static/voice/1.mp3",length:"00:06"}}},
                    {type:"user",msg:{id:4,type:"voice",time:"13:05",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/face.jpg"},content:{url:"/static/voice/2.mp3",length:"00:06"}}},
                    {type:"user",msg:{id:5,type:"img",time:"13:05",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/im/face/face.jpg"},content:{url:"/static/img/p10.jpg",w:200,h:200}}},
                    {type:"user",msg:{id:6,type:"img",time:"12:59",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/im/face/face_2.jpg"},content:{url:"/static/img/q.jpg",w:1920,h:1080}}},
                    {type:"system",msg:{id:7,type:"text",content:{text:"欢迎进入聊天室"}}},

                    {type:"system",msg:{id:9,type:"redEnvelope",content:{text:"售后客服008领取了你的红包"}}},
                    {type:"user",msg:{id:10,type:"redEnvelope",time:"12:56",userinfo:{uid:0,username:"大黑哥",face:"/static/chat/emoticon/im/face/face.jpg"},content:{blessing:"恭喜发财，大吉大利，万事如意",rid:0,isReceived:false}}},
                    {type:"user",msg:{id:11,type:"redEnvelope",time:"12:56",userinfo:{uid:1,username:"售后客服008",face:"/static/chat/emoticon/im/face/face_2.jpg"},content:{blessing:"恭喜发财",rid:1,isReceived:false}}},
                ]
                // 获取消息中的图片,并处理显示尺寸
                for(let i=0;i<list.length;i++){
                    if(list[i].type=='user'&&list[i].msg.type=="img"){
                        list[i].msg.content = this.setPicSize(list[i].msg.content);
                        this.msgImgList.push(list[i].msg.content.url);
                    }
                }
                this.msgList = list;
                // 滚动到底部
                this.$nextTick(function() {
                    //进入页面滚动到底部
                    this.scrollTop = 9999;
                    this.$nextTick(function() {
                        this.scrollAnimation = true;
                    });

                });
            },
            //处理图片尺寸，如果不处理宽高，新进入页面加载图片时候会闪
            setPicSize(content){
                // 让图片最长边等于设置的最大长度，短边等比例缩小，图片控件真实改变，区别于aspectFit方式。
                let maxW = uni.upx2px(350);//350是定义消息图片最大宽度
                let maxH = uni.upx2px(350);//350是定义消息图片最大高度
                if(content.w>maxW||content.h>maxH){
                    let scale = content.w/content.h;
                    content.w = scale>1?maxW:maxH*scale;
                    content.h = scale>1?maxW/scale:maxH;
                }
                return content;
            },

            //更多功能(点击+弹出)
            showMore(){
                this.isVoice = false;
                this.hideEmoji = true;
                if(this.hideMore){
                    this.hideMore = false;
                    this.openDrawer();
                }else{
                    this.hideDrawer();
                }
            },
            // 打开抽屉
            openDrawer(){
                this.popupLayerClass = 'showLayer';
            },
            // 隐藏抽屉
            hideDrawer(){
                this.popupLayerClass = '';
                setTimeout(()=>{
                    this.hideMore = true;
                    this.hideEmoji = true;
                },150);
            },
            //发红包
            handRedEnvelopes(){
                uni.navigateTo({
                    url:'HM-hand/HM-hand'
                });
                this.hideDrawer();
            },
            //选照片 or 拍照
            chooseImage(type){
                this.hideDrawer();
                uni.chooseImage({
                    sourceType:[type],
                    sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
                    success: (result)=>{
                        uni.getImageInfo({
                            src: result.tempFilePaths[0],
                            success: (image)=>{
                                let tempFilePaths = result.tempFilePaths[0];
                                this.$http.upload('util.uploader.upload',{filePath:tempFilePaths,name:'file'}).then((res)=>{
                                    let url = res.files[0].url
                                    let msg = {url:url,w:image.width,h:image.height};
                                    this.sendMsg(msg,'img');
                                }).catch((err)=>{
                                    this.$utils.toast('图片上传失败')
                                })

                            }
                        });
                    }
                });
            },


            //获取焦点，如果不是选表情ing,则关闭抽屉
            textareaFocus(){
                if(this.popupLayerClass=='showLayer' && this.hideMore == false){
                    this.hideDrawer();
                }
            },
            // 发送文字消息
            sendText(){
                this.hideDrawer();
                if(!this.textMsg) return false;
                //let content = this.replaceEmoji(this.textMsg);
                //let content = this.textMsg
                let msg = {text:this.textMsg}
                this.sendMsg(msg,'text');
                this.textMsg = '';
            },
            //替换表情符号为图片
            replaceEmoji(str){
                // 正则表达式匹配内容
                let replacedStr = str.replace(/\[([^(\]|\[)]*)\]/g,(item, index)=>{
                    // console.log("item: " + item);
                    for(let i=0;i<this.emojiList.length;i++){
                        let row = this.emojiList[i];
                        for(let j=0;j<row.length;j++){
                            let EM = row[j];
                            if(EM.alt==item){
                                //在线表情路径，图文混排必须使用网络路径，请上传一份表情到你的服务器后再替换此路径
                                //比如你上传服务器后，你的100.gif路径为https://www.xxx.com/emoji/100.gif 则替换onlinePath填写为https://www.xxx.com/emoji/
                                // let onlinePath = 'https://s2.ax1x.com/2019/04/12/'
                                // let imgstr = '<image src="'+onlinePath+this.onlineEmoji[EM.url]+'">';

                                let onlinePath=this.emojiPath
                                let imgstr = '<img style="width:24px;height:24px;" src="'+onlinePath+EM.url+'">';
                                // console.log("imgstr: " + imgstr);
                                return imgstr;
                            }
                        }
                    }
                });
                return '<div style="align-items: center;word-wrap:break-word;">'+replacedStr+'</div>';
            },

            // 发送消息
            sendMsg(content,type){
                let msg = {scene:'kefu',pages:this.$Route.name+'.msgList',type:type,uniacid:1,token:this.$store.getters.token,content:content}
                if(this.$Route.query.role == 'kefu') {
                    msg.role = 'kefu'
                    msg.roomid = this.$Route.query.roomid
                }
                this.$socket.nsend(JSON.stringify(msg))
				return false;
            },

            // 添加文字消息到列表
            addTextMsg(msg){
                this.msgList.push(msg);
            },
            // 添加语音消息到列表
            addVoiceMsg(msg){
                this.msgList.push(msg);
            },
            // 添加图片消息到列表
            addImgMsg(msg){
                msg.msg.content = this.setPicSize(msg.msg.content);
                this.msgImgList.push(msg.msg.content.url);
                this.msgList.push(msg);
            },
            addRedEnvelopeMsg(msg){
                this.msgList.push(msg);
            },
            // 添加系统文字消息到列表
            addSystemTextMsg(msg){
                this.msgList.push(msg);
            },
            // 添加系统红包消息到列表
            addSystemRedEnvelopeMsg(msg){
                this.msgList.push(msg);
            },
            // 打开红包
            openRedEnvelope(msg,index){
                let rid = msg.content.rid;
                uni.showLoading({
                    title:'加载中...'
                });
                // console.log("index: " + index);
                //模拟请求服务器效果
                setTimeout(()=>{
                    //加载数据
                    if(rid==0){
                        this.redenvelopeData={
                            rid:0,	//红包ID
                            from:"大黑哥",
                            face:"/static/img/im/face/face.jpg",
                            blessing:"恭喜发财，大吉大利",
                            money:"已领完"
                        }
                    }else{
                        this.redenvelopeData={
                            rid:1,	//红包ID
                            from:"售后客服008",
                            face:"/static/img/im/face/face_2.jpg",
                            blessing:"恭喜发财",
                            money:"0.01"
                        }
                        if(!msg.content.isReceived){
                            // {type:"system",msg:{id:8,type:"redEnvelope",content:{text:"你领取了售后客服008的红包"}}},
                            this.sendSystemMsg({text:"你领取了"+(msg.userinfo.uid==this.myuid?"自己":msg.userinfo.username)+"的红包"},'redEnvelope');
                            // console.log("this.msgList[index]: " + JSON.stringify(this.msgList[index]));
                            this.msgList[index].msg.content.isReceived = true;
                        }
                    }
                    uni.hideLoading();
                    this.windowsState = 'show';

                },200)

            },
            // 关闭红包弹窗
            closeRedEnvelope(){
                this.windowsState = 'hide';
                setTimeout(()=>{
                    this.windowsState = '';
                },200)
            },
            sendSystemMsg(content,type){
                let lastid = this.msgList[this.msgList.length-1].msg.id;
                lastid++;
                let row = {type:"system",msg:{id:lastid,type:type,content:content}};
                this.screenMsg(row)
            },
            //领取详情
            toDetails(rid){
                uni.navigateTo({
                    url:'HM-details/HM-details?rid='+rid
                })
            },
            // 预览图片
            showPic(msg){
                uni.previewImage({
                    indicator:"none",
                    current:msg.content.url,
                    urls: this.msgImgList
                });
            },
            // 播放语音
            playVoice(msg){
                this.playMsgid=msg.id;
                this.AUDIO.src = msg.content.url;
                this.$nextTick(function() {
                    this.AUDIO.play();
                });
            },
            // 录音开始
            voiceBegin(e){
                let permision = this.$utils.permision.requestAndroidPermission('android.permission.RECORD_AUDIO')
                if(permision==-1){
                    uni.showModal({
                        title: '提示',
                        content: '已被拒绝麦克风权限,是否前往打开?',
                        success:  (res) => {
                            if (res.confirm) {
                                this.$utils.permision.gotoAppPermissionSetting()
                                return false;
                            } else if (res.cancel) {
                                this.$utils.toast('麦克风权限被拒绝')
                                return false;
                            }
                        }
                    })
                }else if(permision==0){
                    uni.showModal({
                        title: '提示',
                        content: '已被拒绝麦克风权限,是否前往打开?',
                        success:  (res) => {
                            if (res.confirm) {
                                this.$utils.permision.gotoAppPermissionSetting()
                                return false;
                            } else if (res.cancel) {
                                this.$utils.toast('麦克风权限被拒绝')
                                return false;
                            }
                        }
                    })
                }else{
                    if(e.touches.length>1) return false;
                    this.initPoint.Y = e.touches[0].clientY;
                    this.initPoint.identifier = e.touches[0].identifier;
                    this.RECORDER.start({format:"mp3"});
				}

            },
            //录音开始UI效果
            recordBegin(e){
                this.recording = true;
                this.voiceTis='松开 结束';
                this.recordLength = 0;
                this.recordTimer = setInterval(()=>{
                    this.recordLength++;
                },1000)
            },
            // 录音被打断
            voiceCancel(){
                this.recording = false;
                this.voiceTis='按住 说话';
                this.recordTis = '手指上滑 取消发送'
                this.willStop = true;//不发送录音
                this.RECORDER.stop();//录音结束
            },
            // 录音中(判断是否触发上滑取消发送)
            voiceIng(e){
                if(!this.recording) return false;
                let touche = e.touches[0];
                //上滑一个导航栏的高度触发上滑取消发送
                if(this.initPoint.Y - touche.clientY>=uni.upx2px(100)){
                    this.willStop = true;
                    this.recordTis = '松开手指 取消发送'
                }else{
                    this.willStop = false;
                    this.recordTis = '手指上滑 取消发送'
                }
            },
            // 结束录音
            voiceEnd(e){
                if(!this.recording) return false;
                this.recording = false;
                this.voiceTis='按住 说话';
                this.recordTis = '手指上滑 取消发送'
                this.RECORDER.stop();
            },
            //录音结束(回调文件) 先上传录音文件再生成两条天记录
            recordEnd(e){
                clearInterval(this.recordTimer);
                if(!this.willStop){
                    this.$http.upload('util.uploader.upload',{filePath:e.tempFilePath,name:'file',params:{type:'voice'}}).then((res)=>{
                        let url = res.files[0].url
                        let innerAudioContext = uni.createInnerAudioContext();
                        innerAudioContext.src = e.tempFilePath
                        innerAudioContext.onCanplay((playRes)=>{
                            let msg = {length:'00:01',url:url}
                            let recordLength = Math.ceil(innerAudioContext.duration)
                            let min = parseInt(recordLength/60);
                            let sec = recordLength % 60;
                            min = min<10?'0'+min:min;
                            sec = sec<10?'0'+sec:sec;
                            msg.length = min+':'+sec;
                            console.log('msg',msg)
                            this.sendMsg(msg,'voice');
                        })
                    }).catch((err)=>{
                        console.log('err',err)
                        this.$utils.toast('发送失败')
                    })
                }else{
                    //console.log('取消发送录音');
                }
                this.willStop = false;
            },
            // 切换语音/文字输入
            switchVoice(){
                this.hideDrawer();
                this.isVoice = this.isVoice?false:true;
            },
            discard(){
                return;
            }
        },
        computed: {
            msgImgList(){
                let msgImgList = []
				this.msgList.forEach((item,index)=>{
					if(item.msg.type=='img') msgImgList.push(item.msg.content.url)
				})
				return msgImgList
			},
            ...mapState(['SocketState']),
            ...mapGetters(['userInfo'])
        },
        watch: {
            'SocketState.message_service': {
                handler(newVal,oldVal) {
                    Object.keys(newVal).forEach((key)=>{
                        console.log(key,newVal[key])
                        this.$set(this,key,newVal[key])
                    });
                },
                immediate: true,
                deep: true
			},

            msgList(newVal,oldVal){
                console.log('newVal',newVal)
                this.isHistoryLoading = false
                this.scrollAnimation = false
                if(this.isMsgDown) {
                    this.$nextTick(()=>{
                        this.scrollToView = "msg"+this.isMsgDown
                        console.log('isMsgDown',this.scrollToView)
                        this.isMsgDown = false
                    });
                    return false;
                }
                setTimeout(()=>{
                    this.$nextTick(()=>{
                        //this.scrollToView = 'msg279aca7fea3b16561c70af029eb01fa3'
                        this.scrollToView = "msg"+(newVal[newVal.length - 1]?newVal[newVal.length - 1]['msg']['id']:0)
                        console.log('scrollToView',this.scrollToView)
					})
				},0)

			},
            loadFinish(newVal,oldVal){
                if(newVal){
                    this.isHistoryLoading = false
                    this.scrollAnimation = false
				}
			},
        },
    }
</script>
<style lang="scss">
	@import "@/static/css/hm-chat.scss";

</style>