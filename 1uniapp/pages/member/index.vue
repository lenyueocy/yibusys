<template>
	<view>
        <!-- #ifdef MP -->
        <tui-navigation-bar splitLine @init="initNavigation" @change="opacityChange" :scrollTop="scrollTop" title="我的" backgroundColor="#fff" color="#333">
            <view class="tui-header-box" :style="{marginTop:top+'px'}">
            </view>
        </tui-navigation-bar>
        <!-- #endif -->

		<view class="tui-mybg-box" >
			<image src="https://www.thorui.cn/wx/static/images/mall/my/img_bg_3x.png" class="tui-my-bg" mode="widthFix"></image>
            <!-- #ifndef MP -->
			<view class="tui-header-center" >
            <!-- #endif -->
            <!-- #ifdef MP -->
			<view class="tui-header-center " :style="{ top: height + 'px' }"><!--upx2px(20)-->
            <!-- #endif -->
				<image :src="userInfo.avatar?userInfo.avatar:'/static/images/avatar/default.png'" class="tui-avatar margin-left-sm" @tap="href(3)"></image>
				<view class="tui-info">
					<view class="tui-nickname">{{hasLogin?userInfo.nickname:'游客'}}</view>
					<view class="tui-explain" style="position: relative;">
						<text v-if="hasLogin">普通会员</text>
						<text class="" v-else>尊敬的游客,请前往登陆...</text>
					</view>
				</view>
				<view class="tui-btn-edit" v-if="hasLogin">
					<tui-button type="white" :plain="true" shape="circle" width="92rpx" height="40rpx" :size="22" @click="$Router.push({name:'member_info'})">编辑</tui-button>
				</view>
				<view class="tui-btn-edit" v-else>
					<tui-button type="white" :plain="true" shape="circle" width="150rpx" height="50rpx" :size="22" @click="$Router.push({name:'login_login'})">登录/注册</tui-button>
				</view>
			</view>


            <!-- #ifndef MP -->
			<view class="tui-header-btm">
				<view class="tui-btm-item" @click="$Router.push({name:'address_index'})">
					<view class="tui-btm-num">{{dataList.address||0}}</view>
					<view class="tui-btm-text">地址</view>
				</view>
				<view class="tui-btm-item" @click="">
					<view class="tui-btm-num">{{dataList.credit1>0?dataList.credit1:0}}</view>
					<view class="tui-btm-text">积分</view>
				</view>
                <view class="tui-btm-item" @click="$Router.push({name:'member_collection'})">
                    <view class="tui-btm-num">{{statics.favorite||0}}</view>
                    <view class="tui-btm-text">收藏</view>
                </view>
				<view class="tui-btm-item" @click="$Router.push({name:'cart_index'})">
					<view class="tui-btm-num">{{statics.cart||0}}</view>
					<view class="tui-btm-text">购物车</view>
				</view>
			</view>
            <!-- #endif -->
		</view>
		<view class="tui-content-box">
			<view class="tui-box tui-order-box">
				<tui-list-cell :arrow="true" padding="0" :lineLeft="false" @click="$Router.push({name:'order_list'})">
					<view class="tui-cell-header">
						<view class="tui-cell-title">我的订单</view>
						<view class="tui-cell-sub">全部订单</view>
					</view>
				</tui-list-cell>
				<view class="tui-order-list">
					<view class="tui-order-item" @tap="$Router.push({name:'order_list',params:{status:1}})">
						<view class="tui-icon-box">
							<image src="https://deng.alijuly.cn/static/images/mall/my/icon_daifukuan_3x.png" class="tui-order-icon"></image>
							<view class="tui-badge tui-badge-red" v-if="statics.order_0>0">{{statics.order_0||0}}</view>
						</view>
						<view class="tui-order-text padding-top-xs">待付款</view>
					</view>
					<view class="tui-order-item" @tap="$Router.push({name:'order_list',params:{status:2}})">
						<view class="tui-icon-box">
							<image src="https://deng.alijuly.cn/static/images/mall/my/icon_daifahuo_3x.png" class="tui-order-icon"></image>
							<view class="tui-badge tui-badge-red" v-if="statics.order_1>0">{{statics.order_1||0}}</view>
						</view>
						<view class="tui-order-text padding-top-xs">待发货</view>
					</view>
					<view class="tui-order-item" @tap="$Router.push({name:'order_list',params:{status:3}})">
						<view class="tui-icon-box">
							<image src="https://deng.alijuly.cn/static/images/mall/my/icon_daishouhuo_3x.png" class="tui-order-icon"></image>
                            <view class="tui-badge tui-badge-red" v-if="statics.order_2>0">{{statics.order_2||0}}</view>
						</view>
						<view class="tui-order-text padding-top-xs">待收货</view>
					</view>
					<view class="tui-order-item" @tap="$Router.push({name:'order_list',params:{status:4}})">
						<view class="tui-icon-box">
							<image src="https://deng.alijuly.cn/static/images/mall/my/icon_pingjia_3x.png" class="tui-order-icon"></image>
                            <view class="tui-badge tui-badge-red" v-if="statics.order_4>0">{{statics.order_4||0}}</view>
						</view>
						<view class="tui-order-text padding-top-xs">评价</view>
					</view>
					<view class="tui-order-item" @tap="$Router.push({name:'order_refund_list'})">
						<view class="tui-icon-box">
							<image src="https://deng.alijuly.cn/static/images/mall/my/icon_tuikuan_3x.png" class="tui-order-icon"></image>
                            <view class="tui-badge tui-badge-red" v-if="statics.order_4>0">{{statics.order_4||0}}</view>
						</view>
						<view class="tui-order-text padding-top-xs">退款/售后</view>
					</view>
				</view>
			</view>

			<view class="tui-box tui-tool-box">
				<tui-list-cell :arrow="true" padding="0" :lineLeft="false">
					<view class="tui-cell-header">
						<view class="tui-cell-title">我的工具</view>
						<view class="tui-cell-sub"></view>
					</view>
				</tui-list-cell>
				<view class="tui-order-list tui-flex-wrap">
					<!--<view class="tui-tool-item padding-top-xs">
						<view class="tui-icon-box">
							<image src="https://m.deng51.com/images/Integral_icon_my_lntegral.png" class="tui-tool-icon"></image>
						</view>
						<view class="tui-tool-text padding-top-xs">我的积分</view>
					</view>-->
					<view class="tui-tool-item padding-top-xs" @click="$Router.push({name:'member_collection'})">
						<view class="tui-icon-box">
							<image src="https://m.deng51.com/images/my_icon_collection.png" class="tui-tool-icon"></image>
						</view>
						<view class="tui-tool-text padding-top-xs">我的收藏</view>
					</view>
                    <view class="tui-tool-item padding-top-xs"  @click="$Router.push({name:'setting_index'})">
                        <view class="tui-icon-box">
                            <image src="https://m.deng51.com/images/my_icon_to_be_receipt.png" class="tui-tool-icon"></image>
                        </view>
                        <view class="tui-tool-text padding-top-xs">设置</view>
                    </view>
					<view class="tui-tool-item" @click="$Router.push({name:'address_index'})">
						<view class="tui-icon-box">
							<image src="https://m.deng51.com/images/my_icon_delivery_address@2x.png" class="tui-tool-icon"></image>
						</view>
						<view class="tui-tool-text padding-top-xs">我的地址</view>
					</view>
                    <view class="tui-tool-item padding-top-xs" @click="goKefu">
                        <view class="tui-icon-box">
                            <image src="https://m.deng51.com/images/my_icon_customer_service.png" class="tui-tool-icon"></image>
                        </view>
                        <view class="tui-tool-text padding-top-xs">联系客服</view>
                    </view>

				</view>
			</view>

			<!--为你推荐-->
			<tui-divider :size="28" :bold="true" color="#333" width="50%">为你推荐</tui-divider>
			<view class="tui-product-list" v-if="recommand.list.length>0">
				<view class="tui-product-container">
					<block v-for="(item,index) in recommand.list" :key="index" v-if="(index+1)%2!=0">
						<!--商品列表-->
						<view @click="$Router.push({name:'goods_detail',params:{id:item.id}})" class="tui-pro-item" hover-class="hover" :hover-start-time="150" >
							<image :src="item.thumb" class="tui-pro-img" mode="widthFix" />
							<view class="tui-pro-content">
								<view class="tui-pro-tit">{{item.title}}</view>
								<view>
									<view class="tui-pro-price">
										<text class="tui-sale-price">￥{{item.marketprice}}</text>
										<text class="tui-factory-price">￥{{item.productprice}}</text>
									</view>
									<view class="tui-pro-pay">{{item.sales||0}}人付款</view>
								</view>
							</view>
						</view>
					</block>
				</view>
				<view class="tui-product-container">
					<block v-for="(item,index) in recommand.list" :key="index" v-if="(index+1)%2==0">
						<!--商品列表-->
						<view @click="$Router.push({name:'goods_detail',params:{id:item.id}})" class="tui-pro-item" hover-class="hover" :hover-start-time="150" >
							<image :src="item.thumb" class="tui-pro-img" mode="widthFix" />
							<view class="tui-pro-content">
								<view class="tui-pro-tit">{{item.title}}</view>
								<view>
									<view class="tui-pro-price">
										<text class="tui-sale-price">￥{{item.marketprice}}</text>
										<text class="tui-factory-price">￥{{item.productprice}}</text>
									</view>
									<view class="tui-pro-pay">{{item.sales||0}}人付款</view>
								</view>
							</view>
						</view>
					</block>
				</view>
			</view>
            <view v-else>
                <tui-no-data :fixed="false" imgUrl="/static/images/toast/img_nodata.png"  btnText="去逛逛" @click="$Router.push({name:'goods_list'})">
                    <text class="tui-color__black">系统没有发现推荐商品~</text>
                </tui-no-data>
            </view>

			<tui-loadmore v-if="loadding" :index="3" type="red"></tui-loadmore>
            <tui-nomore text="我是有底线的" v-if="page>1"></tui-nomore>
		</view>
		<!--<u-tabbar :list="tabbarIndex" :mid-button="true"></u-tabbar>-->
	</view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    export default {

        data() {
            return {
                top: 0,
                height: 64,
                opacity: 0,
                scrollTop: 0.5,
                dataList:'',
                statics:'',
                page: 1,
                pagesize: 12,
                loadding: false,
                pullUpOn: true,
                recommand:{list:[],total:0}
            }
        },
        onLoad: function(options) {
            let obj = {};
            // #ifdef MP-WEIXIN
            obj = wx.getMenuButtonBoundingClientRect();
            // #endif
            // #ifdef MP-BAIDU
            obj = swan.getMenuButtonBoundingClientRect();
            // #endif
            // #ifdef MP-ALIPAY
            my.hideAddToDesktopMenu();
            // #endif
            uni.getSystemInfo({
                success: (res) => {
                    this.width = obj.left || res.windowWidth;
                    this.height = obj.top ? (obj.top + obj.height + 8) : (res.statusBarHeight + 44);
                    this.top = obj.top ? (obj.top + (obj.height - 32) / 2) : (res.statusBarHeight + 6);
                    this.scrollH = res.windowWidth * 0.6
                }
            })
            if(this.$store.getters.hasLogin) this.getList()
            if(this.$store.getters.hasLogin) this.getRecommand()
        },
        onShow(){
            if(this.$store.getters.hasLogin) this.getList()
        },
        computed: {
            ...mapState(['modalAction']),
            ...mapGetters(['hasLogin','userInfo','tabbarIndex']),
        },
        methods: {
            goKefu(){
                if(this.$utils.getPlatform()!='mp-weixin'){
                    this.$utils.toast('该平台不支持此功能')
                }else{

                }
            },
            upx2px(upx){
                console.log(upx)
                return uni.upx2px(upx);
            },
            getList(){
                this.$http.get('member.index').then((res)=>{
                    this.dataList = res
                    this.statics = res.statics
                    //this.recommand = res.recommand
                })
            },
            getRecommand(){
                this.$http.get('goods.get_list',{page:this.page,pagesize:this.pagesize,random:true}).then((res)=>{
                    if(this.page > 0) this.recommand.list = this.recommand.list.concat(res.list)
                    else this.recommand.list = res.list
                })
            },
            initNavigation(e) {
                this.opacity = e.opacity;
                this.top = e.top;
            },
            opacityChange(e) {
                this.opacity = e.opacity;
            },
        },
        onPageScroll(e) {
            this.scrollTop = e.scrollTop;
        },
        onPullDownRefresh() {
            setTimeout(() => {
                uni.stopPullDownRefresh()
            }, 200)
        },
        // #ifndef MP
        onNavigationBarButtonTap(e) {
            const index = e.index;
            if (index === 0) {
                this.$Router.push({name:'message_index'})
            }else if(index === 1){
                this.$Router.push({name:'setting_index'})
            }
        },
        // #endif
        onReachBottom: function() {
            if (!this.pullUpOn || this.page>1) return;
            this.loadding = true;
            setTimeout(()=>{
                if (this.page == 4) {
                    this.loadding = false;
                    this.pullUpOn = false
                } else {
                    //this.getRecommand()
                    this.page = this.page + 1;
                    this.loadding = false
                }
            },500)

        },
        onShareAppMessage(res) {
            return {
                path: "/pages/index/index",
                title: "我给你分享了奋钧智慧照明商城，快来看看吧",
                imageUrl: "https://deng.alijuly.cn/attachment/images/1/2021/06/TuckG01GgH1K1C6816cP61c10yYO61.jpeg",
                success:(res)=>{
                    this.$utils.toast('分享成功')
                },
                fail:()=>{
                    this.$utils.toast('分享失败')
                }
            }
        },
        onShareTimeline(res) {
            return {
                title: '我给你分享了奋钧智慧照明商城，快来看看吧',
                imageUrl: "https://deng.alijuly.cn/attachment/images/1/2021/06/TuckG01GgH1K1C6816cP61c10yYO61.jpeg",
                success:(res)=>{
                    this.$utils.toast('分享成功')
                },
                fail:()=>{
                    this.$utils.toast('分享失败')
                }
            }
        }
    }
</script>

<style>
    page{
        background-color: #f9f9f9;
    }
	.tui-header-box {
		width: 100%;
		padding: 0 30rpx 0 20rpx;
		box-sizing: border-box;
		position: fixed;
		top: 0;
		left: 0;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		height: 32px;
		transform: translateZ(0);
		z-index: 9999;
	}

    .tui-color__black{
        color: #4f4e4e;
        font-size: 26rpx;
    }

	/* #ifndef MP */
	.tui-header-icon {
		min-width: 120rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	/* #endif */
	/* #ifdef MP */
	.tui-set-box {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	/* #endif */
	.tui-icon-box {
		position: relative;
	}

	.tui-icon-setup {
		margin-left: 8rpx;
	}

	.tui-badge {
		position: absolute;
		font-size: 24rpx;
		height: 32rpx;
		min-width: 20rpx;
		padding: 0 12rpx;
		border-radius: 40rpx;
		right: 10rpx;
		top: -5rpx;
		transform: scale(0.8) translateX(60%);
		transform-origin: center center;
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 10;
	}

	.tui-badge-red {
		background: #F74D54;
		color: #fff;
	}

	.tui-badge-white {
		background: #fff;
		color: #F74D54;
	}

	.tui-badge-dot {
		position: absolute;
		height: 12rpx;
		width: 12rpx;
		border-radius: 50%;
		right: -12rpx;
		top: 0;
		background: #F74D54;
	}

	.tui-mybg-box {
		width: 100%;
		height: 464rpx;
		position: relative;
	}

	.tui-my-bg {
		width: 100%;
		height: 464rpx;
		display: block;
	}

	.tui-header-center {
		position: absolute;
		width: 100%;
		height: 128rpx;
		left: 0;
		top: 120rpx;
		padding: 0 30rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.tui-avatar {
		flex-shrink: 0;
		width: 130rpx;
		height: 130rpx;
		border-radius: 50%;
		display: block;
	}

	.tui-info {
		width: 60%;
		padding-left: 30rpx;
		flex:1;
	}

	.tui-nickname {
		font-size: 30rpx;
		font-weight: 500;
		color: #fff;
		display: flex;
		align-items: center;
	}

	.tui-img-vip {
		width: 56rpx;
		height: 24rpx;
		margin-left: 18rpx;
	}

	.tui-explain {
		width: 80%;
		font-size: 24rpx;
		font-weight: 400;
		color: #fff;
		opacity: 0.75;
		padding-top: 8rpx;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.tui-btn-edit {
		flex-shrink: 0;
		padding-right: 22rpx;
	}

	.tui-header-btm {
		width: 100%;
		padding: 0 30rpx;
		box-sizing: border-box;
		position: absolute;
		left: 0;
		top: 280rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		color: #fff;
	}

	.tui-btm-item {
		flex: 1;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

	.tui-btm-num {
		font-size: 32rpx;
		font-weight: 600;
		position: relative;
	}

	.tui-btm-text {
		font-size: 24rpx;
		opacity: 0.85;
		padding-top: 4rpx;
	}

	.tui-content-box {
		width: 100%;
		padding: 0 20rpx;
		box-sizing: border-box;
		position: relative;
		top: -72rpx;
		z-index: 10;
	}

	.tui-box {
		width: 100%;
		background: #fff;
		box-shadow: 0 3rpx 20rpx rgba(183, 183, 183, 0.1);
		border-radius: 10rpx;
		overflow: hidden;
	}

	.tui-order-box {

	}

	.tui-cell-header {
		width: 100%;
		height: 74rpx;
		padding: 0 26rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.tui-cell-title {
		font-size: 30rpx;
		line-height: 30rpx;
		font-weight: 600;
		color: #333;
	}

	.tui-cell-sub {
		font-size: 26rpx;
		font-weight: 400;
		color: #999;
		padding-right: 28rpx;
	}

	.tui-order-list {
		width: 100%;
		padding: 30rpx 30rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: flex-start;

	}

	.tui-order-item {
		flex: 1;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.tui-order-text,
	.tui-tool-text {
		font-size: 24rpx;
		font-weight: 400;
		color: #666;
	}

	.tui-tool-text {
		font-size: 24rpx;
	}

	.tui-order-icon {
		width: 65rpx;
		height: 65rpx;
		display: block;
	}

	.tui-assets-box {
		height: 178rpx;
		margin-top: 20rpx;
	}

	.tui-assets-list {
		height: 84rpx;
	}

	.tui-assets-num {
		font-size: 32rpx;
		font-weight: 500;
		color: #333;
		position: relative;
	}

	.tui-assets-text {
		font-size: 24rpx;
		font-weight: 400;
		color: #666;
		padding-top: 6rpx;
	}

	.tui-tool-box {
		margin-top: 20rpx;
	}

	.tui-flex-wrap {
		flex-wrap: wrap;
		height: auto;
		padding-bottom: 30rpx;
	}

	.tui-tool-item {
		width: 25%;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
	}

	.tui-tool-icon {
		width: 64rpx;
		height: 64rpx;
		display: block;
	}

	.tui-badge-icon {
		width: 66rpx;
		height: 30rpx;
		position: absolute;
		right: 0;
		transform: translateX(88%);
		top: -15rpx;
	}

	/*为你推荐*/
	.tui-product-list {
		display: flex;
		justify-content: space-between;
		flex-direction: row;
		flex-wrap: wrap;
		box-sizing: border-box;
	}

	.tui-product-container {
		flex: 1;
		margin-right: 2%;
	}

	.tui-product-container:last-child {
		margin-right: 0;
	}

	.tui-pro-item {
		width: 100%;
		margin-bottom: 4%;
		background: #fff;
		box-sizing: border-box;
		border-radius: 12rpx;
		overflow: hidden;
	}

	.tui-pro-img {
		width: 100%;
		display: block;
	}

	.tui-pro-content {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		box-sizing: border-box;
		padding: 20rpx;
	}

	.tui-pro-tit {
		color: #2e2e2e;
		font-size: 26rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.tui-pro-price {
		padding-top: 18rpx;
	}

	.tui-sale-price {
		font-size: 34rpx;
		font-weight: 500;
		color: #e41f19;
	}

	.tui-factory-price {
		font-size: 24rpx;
		color: #a0a0a0;
		text-decoration: line-through;
		padding-left: 12rpx;
	}

	.tui-pro-pay {
		padding-top: 10rpx;
		font-size: 24rpx;
		color: #656565;
	}

	.tui-btn-back {
		width: 88rpx;
		height: 88rpx;
		font-size: 26rpx;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		background-color: rgba(0, 0, 0, .5);
		color: #fff;
		position: fixed;
		bottom: 60rpx;
		right: 30rpx;
		z-index: 9999;
	}
</style>
