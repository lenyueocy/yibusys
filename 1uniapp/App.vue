<script>
    import Vue from 'vue'
	export default {
		onLaunch: function() {
            //uni.hideTabBar();
            this.getStatusBar()
            //this.checkClient()
            //this.onPush()
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		},
        methods:{
            checkClient(){
                // #ifdef APP-PLUS
                if(this.$store.getters.hasLogin){
                    plus.push.getClientInfoAsync((info)=>{
                        this.$http.get('member.info.setClientId',{clientid:info.clientid}).then((res)=>{

                        })
                    }, (err)=>{

                    });
                }
                // #endif
            },
            onPush(){
                // #ifdef APP-PLUS
                plus.push.addEventListener("receive", msg => {
                    plus.push.createMessage("您有新的消息");
                })
                // #endif
            },
            getStatusBar(){
                uni.getSystemInfo({
                    success: (e)=> {
                        Vue.prototype.StatusBar = 0
                        // #ifndef APP-PLUS
                        Vue.prototype.StatusBar = e.statusBarHeight;
                        this.$store.getters.StatusBar = e.statusBarHeight
                        if (e.platform == 'android') {
                            Vue.prototype.CustomBar = e.statusBarHeight + 50;
                            this.$store.getters.CustomBar = e.statusBarHeight + 50
                        } else {
                            Vue.prototype.CustomBar = e.statusBarHeight + 45;
                            this.$store.getters.CustomBar = e.statusBarHeight + 45
                        };
                        // #endif
                        // #ifdef MP-WEIXIN
                        Vue.prototype.StatusBar = e.statusBarHeight;
                        console.log(e.statusBarHeight)
                        let custom = wx.getMenuButtonBoundingClientRect();
                        Vue.prototype.Custom = custom;
                        Vue.prototype.CustomBar = custom.bottom + custom.top - e.statusBarHeight;
                        // #endif
                        // #ifdef MP-ALIPAY
                        Vue.prototype.StatusBar = e.statusBarHeight;
                        Vue.prototype.CustomBar = e.statusBarHeight + e.titleBarHeight;
                        // #endif
                    }
                })
            }
        }
	}
</script>

<style lang='scss'>
    @import "uni-colorui/theme/main.css";
    @import "uni-colorui/theme/icon.css";
    /*@import "uview-ui/index.scss";*/
    @import "/static/css/iconfont.css";
    @import "/static/css/thorui.css";
    @import "/static/css/thorui-extend.css";
    /*@import "thorui-uni/static/style/thorui.css";*/

    .border-10{
        border-radius: 10rpx;
    }
    .border-15{
        border-radius: 15rpx;
    }
    .border-20{
        border-radius: 20rpx;
    }
    .text-sml{
        font-size: 28rpx;
    }
    .padding-sml{
        padding: 30rpx;
    }
    .padding-lr-sml{
        padding-left: 30rpx;
        padding-right: 30rpx;
    }
    .padding-tb-sml{
        padding-top: 30rpx;
        padding-bottom: 30rpx;
    }
    .padding-left-sml{
        padding-left: 30rpx;
    }
    .padding-right-sml{
        padding-right: 30rpx;
    }
    .padding-top-sml{
        padding-top: 30rpx;
    }
    .padding-bottom-sml{
        padding-bottom: 30rpx;
    }
    .margin-sml{
        margin: 30rpx;
    }
    .margin-lr-sml{
        margin-left: 30rpx;
        margin-right: 30rpx;
    }
    .margin-tb-sml{
        margin-top: 30rpx;
        margin-bottom: 30rpx;
    }
    .margin-left-sml{
        margin-left: 30rpx;
    }
    .margin-right-sml{
        margin-right: 30rpx;
    }
    .margin-top-sml{
        margin-top: 30rpx;
    }
    .margin-bottom-sml{
        margin-bottom: 30rpx;
    }
    .cu-btn.sml{
        padding: 0 40rpx;
        font-size: 30rpx;
        height: 70rpx;
    }
    .tui-btn-mix{
        background: #fa436a !important;
        color: #fff;
    }
    .tui-mix-hover{
        background: #dc3e62 !important;
        color: #f2f2f2 !important;
    }
    .tui-shadow-mix{
        box-shadow: 2rpx 4rpx 10rpx rgba(219, 63, 96, 0.4);
    }
    .tui-text-custom{
        color: #CA1C1D;
    }
    .tui-bg-custom{
        background: #CA1C1D;
        background-color: #F8B600;
    }
    .tui-btn-custom{
        background: #CA1C1D;
        color: #fff;
    }
    /*@font-face {
        font-family: yticon;
        font-weight: normal;
        font-style: normal;
        src: url('https://at.alicdn.com/t/font_1078604_w4kpxh0rafi.ttf') format('truetype');
    }
    !*img {
        max-width: 100% !important;
    }*!
    .image-block img{
        max-width: 100% !important;
        display: block !important;
    }

    .iconfont {
        font-size: 50rpx;
    }

    .u-tabbar__content__circle__button{
        background-color: rgba(255,255,255,0) !important;
        display: none;
    }
    .u-tabbar__content__circle__border{
        background-color: rgba(255,255,255,0) !important;
        display: none;
    }
    .tui-countdown-item,.tui-countdown-time{
         box-sizing:initial !important;
     }
    .yticon {
        font-family: "yticon" !important;
        font-size: 16px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .icon-yiguoqi1:before {
        content: "\e700";
    }

    .icon-iconfontshanchu1:before {
        content: "\e619";
    }

    .icon-iconfontweixin:before {
        content: "\e611";
    }

    .icon-alipay:before {
        content: "\e636";
    }

    .icon-shang:before {
        content: "\e624";
    }

    .icon-shouye:before {
        content: "\e626";
    }

    .icon-shanchu4:before {
        content: "\e622";
    }

    .icon-xiaoxi:before {
        content: "\e618";
    }

    .icon-jiantour-copy:before {
        content: "\e600";
    }

    .icon-fenxiang2:before {
        content: "\e61e";
    }

    .icon-pingjia:before {
        content: "\e67b";
    }

    .icon-pinglun-copy:before {
        content: "\e612";
    }

    .icon-dianhua-copy:before {
        content: "\e621";
    }

    .icon-shoucang:before {
        content: "\e645";
    }

    .icon-xuanzhong2:before {
        content: "\e62f";
    }

    .icon-gouwuche_:before {
        content: "\e630";
    }

    .icon-icon-test:before {
        content: "\e60c";
    }

    .icon-icon-test1:before {
        content: "\e632";
    }

    .icon-bianji:before {
        content: "\e646";
    }

    .icon-jiazailoading-A:before {
        content: "\e8fc";
    }

    .icon-zuoshang:before {
        content: "\e613";
    }

    .icon-jia2:before {
        content: "\e60a";
    }

    .icon-huifu:before {
        content: "\e68b";
    }

    .icon-sousuo:before {
        content: "\e7ce";
    }

    .icon-arrow-fine-up:before {
        content: "\e601";
    }

    .icon-hot:before {
        content: "\e60e";
    }

    .icon-lishijilu:before {
        content: "\e6b9";
    }

    .icon-zhengxinchaxun-zhifubaoceping-:before {
        content: "\e616";
    }

    .icon-naozhong:before {
        content: "\e64a";
    }

    .icon-xiatubiao--copy:before {
        content: "\e608";
    }

    .icon-shoucang_xuanzhongzhuangtai:before {
        content: "\e6a9";
    }

    .icon-jia1:before {
        content: "\e61c";
    }

    .icon-bangzhu1:before {
        content: "\e63d";
    }

    .icon-arrow-left-bottom:before {
        content: "\e602";
    }

    .icon-arrow-right-bottom:before {
        content: "\e603";
    }

    .icon-arrow-left-top:before {
        content: "\e604";
    }

    .icon-icon--:before {
        content: "\e744";
    }

    .icon-zuojiantou-up:before {
        content: "\e605";
    }

    .icon-xia:before {
        content: "\e62d";
    }

    .icon--jianhao:before {
        content: "\e60b";
    }

    .icon-weixinzhifu:before {
        content: "\e61a";
    }

    .icon-comment:before {
        content: "\e64f";
    }

    .icon-weixin:before {
        content: "\e61f";
    }

    .icon-fenlei1:before {
        content: "\e620";
    }

    .icon-erjiye-yucunkuan:before {
        content: "\e623";
    }

    .icon-Group-:before {
        content: "\e688";
    }

    .icon-you:before {
        content: "\e606";
    }

    .icon-forward:before {
        content: "\e607";
    }

    .icon-tuijian:before {
        content: "\e610";
    }

    .icon-bangzhu:before {
        content: "\e679";
    }

    .icon-share:before {
        content: "\e656";
    }

    .icon-yiguoqi:before {
        content: "\e997";
    }

    .icon-shezhi1:before {
        content: "\e61d";
    }

    .icon-fork:before {
        content: "\e61b";
    }

    .icon-kafei:before {
        content: "\e66a";
    }

    .icon-iLinkapp-:before {
        content: "\e654";
    }

    .icon-saomiao:before {
        content: "\e60d";
    }

    .icon-shezhi:before {
        content: "\e60f";
    }

    .icon-shouhoutuikuan:before {
        content: "\e631";
    }

    .icon-gouwuche:before {
        content: "\e609";
    }

    .icon-dizhi:before {
        content: "\e614";
    }

    .icon-fenlei:before {
        content: "\e706";
    }

    .icon-xingxing:before {
        content: "\e70b";
    }

    .icon-tuandui:before {
        content: "\e633";
    }

    .icon-zuanshi:before {
        content: "\e615";
    }

    .icon-zuo:before {
        content: "\e63c";
    }

    .icon-shoucang2:before {
        content: "\e62e";
    }

    .icon-shouhuodizhi:before {
        content: "\e712";
    }

    .icon-yishouhuo:before {
        content: "\e71a";
    }

    .icon-dianzan-ash:before {
        content: "\e617";
    }
    view,
    scroll-view,
    swiper,
    swiper-item,
    cover-view,
    cover-image,
    icon,
    text,
    rich-text,
    progress,
    button,
    checkbox,
    form,
    input,
    label,
    radio,
    slider,
    switch,
    textarea,
    navigator,
    audio,
    camera,
    image,
    video {
        !*box-sizing: border-box;*!
    }

    !* 骨架屏替代方案 *!
    .Skeleton {
        background: #f3f3f3;
        padding: 20upx 0;
        border-radius: 8upx;
    }

    !* 图片载入替代方案 *!
    .image-wrapper {
        font-size: 0;
        background: #f3f3f3;
        border-radius: 4px;

        image {
            width: 100%;
            height: 100%;
            transition: .6s;
            opacity: 0;

            &.loaded {
                opacity: 1;
            }
        }
    }

    .clamp {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
    }

    .common-hover {
        background: #f5f5f5;
    }

    !*边框*!
    .b-b:after,
    .b-t:after {
        position: absolute;
        z-index: 3;
        left: 0;
        right: 0;
        height: 0;
        content: '';
        transform: scaleY(.5);
        !*border-bottom: 1px solid $border-color-base;*!
    }

    .b-b:after {
        bottom: 0;
    }

    .b-t:after {
        top: 0;
    }

    !* button样式改写 *!
    uni-button,
    button {
        height: 80upx;
        line-height: 80upx;
        font-size: $font-lg + 2upx;
        font-weight: normal;

        &.no-border:before,
        &.no-border:after {
            border: 0;
        }
    }

    uni-button[type=default],
    button[type=default] {
        color: $font-color-dark;
    }

    !* input 样式 *!
    .input-placeholder {
        color: #999999;
    }

    .placeholder {
        color: #999999;
    }*/
</style>
