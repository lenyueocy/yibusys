<template>
	<view class="container">
		<!--header-->
		<view class="tui-header-box" :style="{ height: height + 'px', background: 'rgba(255,255,255,' + opcity + ')' }">
			<view class="tui-header" :style="{ marginTop: top + 'px', opacity: opcity }">商品详情</view>
			<view class="tui-header-icon" :style="{ marginTop: top + 'px' }">
				<view class="tui-icon-box" :style="{ backgroundColor: 'rgba(0, 0, 0,' + iconOpcity + ')' }" @tap="$Router.back()">
					<tui-icon name="arrowleft" :size="30" :color="opcity >= 1 ? '#000' : '#fff'"></tui-icon>
				</view>
				<!-- #ifndef MP -->
				<view class="tui-icon-box tui-icon-ml" :style="{backgroundColor: 'rgba(0, 0, 0,' + iconOpcity + ')'}" @tap.stop="openMenu">
					<tui-icon name="more-fill" :size="20" :color="opcity >= 1 ? '#000' : '#fff'"></tui-icon>
				</view>
				<!-- #endif -->
			</view>
		</view>
		<!--header-->

		<!--banner-->
		<view class="tui-banner-swiper">
			<swiper :duration="150" style="height: 1000rpx;" @change="bannerChange"><!--{ height: scrollH + 'px' }-->
				<block v-for="(item, index) in banner" :key="index">
					<swiper-item @tap.stop="videoPlay" v-if="goods.video && index==0">
                        <view style="position: relative;width: 100%;height: 1000rpx;">
                            <video id="myVideo" :src="goods.video" :poster="item" style="width: 100%;height: 100%;" :show-center-play-btn="false" :controls="play_video" @ended="endPay" :enable-progress-gesture="false" ></video>
                            <view class="app-video" v-if="!play_video"></view>
                        </view>
					</swiper-item>
					<!--<swiper-item :data-index="index" @tap.stop="" v-if="index==0 && goods.video">
                        &lt;!&ndash;<view style="position: relative;">
						    <image :src="item" class="tui-slide-image" style="height: 1000rpx;" />
                            <view class="app-video"></view>
                        </view>&ndash;&gt;
                        <view style="position: relative;width: 100%;height: 1000rpx;">
                            <video  id="myVideo" :src="goods.video" @error="videoErrorCallback" style="width: 100%;height: 100%;" controls></video>
                            <view style="position:absolute;width: 100%;height: 1000rpx;left: 0;top: 0;z-index: 999999;"></view>
                        </view>
					</swiper-item>-->
					<swiper-item :data-index="index" @tap.stop="previewImage">
						<image :src="item" class="tui-slide-image" mode="aspectFill" style="height: 1000rpx;" /><!--:style="{ height: scrollH + 'px' }"-->
					</swiper-item>
				</block>
			</swiper>
			<view class="tui-banner-tag" v-if="!play_video || bannerIndex>0">
				<tui-tag padding="12rpx 18rpx" type="translucent" shape="circleLeft" :scaleMultiple="0.82" originRight>{{ bannerIndex + 1 }}/{{ goods.video?banner.length+1:banner.length }}</tui-tag>
			</view>
		</view>

		<!--banner-->
		<view class="tui-pro-detail">
			<view class="tui-product-title tui-border-radius">
				<view class="tui-pro-pricebox tui-padding">
					<view class="tui-pro-price">
						<view style="font-size: 50rpx;line-height: 60rpx;font-weight: 400;">
							<!--<text>￥</text>-->
							<!--<text class="tui-price">{{(goods.marketprice||'').toString().split('.')[0]||'00'}}</text>-->
							<!--<text>.{{(goods.marketprice||'').toString().split('.')[1]||'00'}}</text>-->
                            <text class="tui-price text-price" v-if="goods.hasoption==1">{{goods.minprice||'0.00'}}-{{goods.maxprice||'0.00'}}</text>
                            <text class="tui-price text-price" v-else>{{goods.marketprice||'0.00'}}</text>
						</view>
						<!--<tui-tag padding="10rpx 20rpx" size="24rpx" plain type="warning" shape="circle" :scaleMultiple="0.8">热销</tui-tag>-->
					</view>
					<view class="tui-collection tui-size" @tap="collecting">
						<tui-icon :name="goods.isfavorite ? 'like-fill' : 'like'" :color="goods.isfavorite ? '#ff201f' : '#333'" :size="20"></tui-icon>
						<view class="tui-scale-collection" :class="{'tui-icon-red':goods.isfavorite}">收藏</view>
					</view>
				</view>
				<view class="tui-original-price text-gray">
					价格
					<text class="tui-line-through">￥{{goods.productprice?parseInt(goods.productprice).toFixed(2):'0.00'}}</text>
				</view>
				<view class="tui-pro-titbox">
					<view class="tui-pro-title">{{goods.title}}</view>
					<button open-type="share" class="tui-share-btn tui-share-position" @tap="onShare">
						<tui-tag type="gray" shape="circleLeft" padding="12rpx 16rpx" style="background-color: #f2f2f2 !important;">
							<view class="tui-share-box">
								<tui-icon name="share" color="#999" :size="15"></tui-icon>
								<text class="tui-share-text text-gray tui-size">分享</text>
							</view>
						</tui-tag>
					</button>
				</view>
				<view class="tui-padding">
					<view class="tui-sale-info tui-size text-gray">
						<!--<view>快递：0.00</view>-->
						<!--<view>销量2000</view>-->
						<!--<view>深圳市</view>-->
					</view>
				</view>
			</view>

			<!--<view class="tui-basic-info tui-mtop">
				<view class="tui-list-cell" @tap="showPopup" v-if="goods.hasoption==1">
					<view class="tui-cell-title">{{buyOptionId?'已选':'选择'}}</view>
					<view class="tui-selected-box">{{goods.spec_titles}}</view>
					<view class="tui-ml-auto">
						<tui-icon name="more-fill" :size="20" color="#666"></tui-icon>
					</view>
				</view>
				<view class="tui-list-cell tui-last">
					<view class=" tui-cell-title">参数</view>
					<view class="tui-selected-box">在线支付免运费</view>
				</view>
				<view class="tui-guarantee">
					<view class="tui-guarantee-item" v-for="(item,index) in goods.services" :key="index">
						<tui-icon name="circle-selected" :size="14" color="#999"></tui-icon>
						<text class="tui-pl">{{item}}</text>
					</view>

				</view>
			</view>-->

            <tui-list-view unlined="all" class="margin-top-sm">
                <tui-list-cell @click="" unlined :size="26" padding="40rpx 30rpx" :arrow="false" >
                    <view class=" tui-cell-title">发货</view>
                    <view class="tui-selected-box flex align-center justify-between" style="width: 100%">
                        <view class="flex" >
                            <tui-icon name="gps" :size="16" v-if="goods.province"></tui-icon>
                            <text class="margin-left-xs" v-if="goods.province">{{goods.province||''}}{{goods.city||''}}</text>
                            <text class="margin-lr-sm" style="color: #EEEEEE" v-if="goods.province">|</text>
                            <view class="">快递：{{goods.dispatchprice>0?goods.dispatchprice+'元':'免运费'}}</view>
                        </view>
                        <view class="padding-left-sm" style="color: #999999">销量：{{goods.sales||0}}</view>
                    </view>
                </tui-list-cell>
                <tui-list-cell @click="" unlined :size="26" padding="40rpx 30rpx" :arrow="true">
                    <view class=" tui-cell-title">保障</view>
                    <view class="tui-selected-box" >
                        <text class="" v-for="(labelname,labelindex) in goods.labelname" v-if="labelindex<3"><text class="padding-lr-xs" v-if="labelindex>0">·</text>{{labelname}}</text>
                    </view>
                </tui-list-cell>
            </tui-list-view>

            <tui-list-view unlined="all" class="margin-top-sm">
                <tui-list-cell @click="showPopup" unlined :size="26" padding="40rpx 30rpx" :arrow="true" v-if="goods.hasoption==1">
                    <view class=" tui-cell-title">{{buyOptionId?'已选':'选择'}}</view>
                    <view class="tui-selected-box">{{goods.spec_titles}}</view>
                </tui-list-cell>
                <tui-list-cell @click="detail" unlined :size="26" padding="40rpx 30rpx" :arrow="true">
                    <view class=" tui-cell-title">参数</view>
                    <view class="tui-selected-box">品牌  型号...</view>
                </tui-list-cell>
            </tui-list-view>

            <view class="tui-cmt-box tui-mtop">
                <view class="tui-list-cell tui-last tui-between">
                    <view class="tui-cell-title" style="font-size: 30rpx;color: #111111;">宝贝评价({{goods.comment_counnt||0}})</view>
                    <view class="tui-flex-center" @tap="$Router.push({name:'goods_comment',params:{id:goods.id}})" >
                        <text class="tui-cmt-all">查看全部</text>
                        <tui-icon name="arrowright" :size="20" color="#FF5000"></tui-icon>
                    </view>
                </view>

                <view @tap="$Router.push({name:'goods_comment'})" class="tui-cmt-content tui-padding" v-if="goods.comment_counnt && goods.comment_counnt>0">
                    <view class="tui-cmt-user">
                        <image src="/static/images/news/avatar_2.jpg" class="tui-acatar"></image>
                        <view>z***9</view>
                    </view>
                    <view class="tui-cmt">物流很快，非常好❤</view>
                    <view class="tui-attr">颜色：黑色</view>
                </view>
                <view v-else class="text-gray text-center padding-bottom-xl padding-top-sm text-sml">该宝贝暂无评价...</view>

                <view class="tui-cmt-btn" v-if="goods.comment_counnt && goods.comment_counnt>0">
                    <tui-button width="240rpx" height="64rpx" :size="24" type="black" plain shape="circle" @click="evaluate">查看全部评价</tui-button>
                </view>
            </view>


			<!--<view class="tui-cmt-box tui-mtop tui-radius-all">
				<view class="tui-list-cell tui-last tui-between">
					<view class="tui-bold tui-cell-title">评价</view>
					<view class="tui-flex-center" @tap="common">
						<text class="tui-cmt-all">查看全部</text>
						<tui-icon name="more-fill" :size="20" color="#ff201f"></tui-icon>
					</view>
				</view>

				<view class="tui-cmt-content tui-padding">
					<view class="tui-cmt-user">
						<image src="http://appstore.bai918.com/static/app/images/default_avatar.png" class="tui-acatar"></image>
						<view>z***9</view>
					</view>
					<view class="tui-cmt">物流很快，很适合我的风格❤</view>
					<view class="tui-attr">颜色：叠层钛钢流苏耳环（A74）</view>
				</view>

				<view class="tui-cmt-btn">
					<tui-button width="240rpx" height="64rpx" :size="24" type="black" plain shape="circle" @click="common">查看全部评价</tui-button>
				</view>
			</view>-->

			<view class="tui-nomore-box">
				<tui-nomore text="宝贝详情" backgroundColor="#f7f7f7"></tui-nomore>
				<!--<view v-if="goods.params" class="grid col-2 text-sm text-center margin-bottom-sm" style="color: #747474;">
					<view v-for="(pitem,pindex) in goods.params" :key="pindex">{{pitem.title}}：{{pitem.value}}</view>
				</view>-->
			</view>
			<view class="tui-product-img tui-radius-all image-block">
				<jyf-parser :html="goods.content" ref="article"></jyf-parser>
			</view>
			<tui-nomore text="已经到最底了" backgroundColor="#f7f7f7"></tui-nomore>
			<view class="tui-safearea-bottom"></view>
		</view>

		<!--底部操作栏-->
		<view class="tui-operation">
			<view class="tui-operation-left tui-col-3">
				<view @click="$Router.pushTab({name:'index_index'})" class="tui-operation-item" hover-class="tui-opcity" :hover-stay-time="150">
					<tui-icon name="home" :size="22" color="#333"></tui-icon>
					<view class="tui-operation-text tui-scale-small">首页</view>
				</view>
				<view @click="$Router.push({name:'cart_index'})" class="tui-operation-item" hover-class="tui-opcity" :hover-stay-time="150">
					<tui-icon name="cart" :size="22" color="#333"></tui-icon>
					<view class="tui-operation-text tui-scale-small">购物车</view>
					<!--<tui-badge type="red" absolute :scaleRatio="0.8" right="10rpx" top="-4rpx">9</tui-badge>-->
				</view>
			</view>
			<view class="tui-operation-right tui-right-flex tui-col-9 tui-btnbox-4" ><!--style="height: auto;"-->
				<view class="tui-flex-1">
					<tui-button height="68rpx" :size="26" type="warning" shape="circle" @click="addCart">加入购物车</tui-button>
				</view>
				<view class="tui-flex-1">
					<tui-button height="68rpx" :size="26" type="danger" shape="circle" @click="goBuy">立即购买</tui-button>
				</view>
			</view>
		</view>

		<!--底部操作栏--->

		<!--顶部下拉菜单-->
		<tui-top-dropdown backgroundColor="rgba(76, 76, 76, 0.95)" :show="menuShow" :height="0" @close="closeMenu">
			<view class="tui-menu-box tui-padding tui-ptop">
				<view class="tui-menu-header" :style="{ paddingTop: top + 'px' }">功能直达</view>
				<view class="tui-menu-itembox">
					<block v-for="(item, index) in topMenu" :key="index">
						<view class="tui-menu-item" hover-class="tui-opcity" :hover-stay-time="150" @tap="btnTopMenu(index)">
							<view class="tui-badge-box">
								<tui-icon :name="item.icon" color="#fff" :size="item.size"></tui-icon>
								<tui-badge type="red" :scaleRatio="0.8" absolute right="-8rpx" v-if="item.badge">{{ item.badge }}</tui-badge>
							</view>
							<view class="tui-menu-text">{{ item.text }}</view>
						</view>
					</block>
				</view>
				<view class="tui-icon-up_box">
					<tui-icon name="up" color="#fff" :size="26" @click="closeMenu"></tui-icon>
				</view>
			</view>
		</tui-top-dropdown>
		<!---顶部下拉菜单-->

		<!--底部选择层-->
		<tui-bottom-popup :show="popupShow" @close="hidePopup">
			<view class="tui-popup-box">
				<view class="tui-product-box tui-padding">
					<image :src="goods.thumb" class="tui-popup-img"></image>
					<view class="tui-popup-price">
						<view class="tui-amount tui-bold">￥{{specGoods.marketprice}}</view>
						<view class="tui-number" v-if="specGoods.goodssn">编号：{{specGoods.goodssn}}</view>
					</view>
				</view>
				<scroll-view scroll-y class="tui-popup-scroll" :style="{height:goods.hasoption==1?'600rpx':'200rpx'}">
					<view class="tui-scrollview-box">

						<view v-for="(item,index) in specs" :key="index">
							<view class="tui-bold tui-attr-title">{{item.title}}</view><!--chooseSpecs.indexOf(subItem.id)>0-->
							<view class="tui-attr-box" >
								<view class="tui-attr-item" :class="{'tui-attr-active':chooseSpecs.indexOf(subItem.id)>0}" @click="chooseSpec(item,subItem)" v-for="(subItem,subIndex) in item.items" :key="subIndex">{{subItem.title}}</view>
							</view>
						</view>
						<view class="tui-number-box tui-bold tui-attr-title">
							<view class="tui-attr-title">数量</view>
							<tui-numberbox :max="5" :min="1" :value="buyNum" @change="change"></tui-numberbox>
						</view>

					</view>
				</scroll-view>
				<view class="tui-operation tui-operation-right tui-right-flex tui-popup-btn">
					<view class="tui-flex-1">
						<tui-button height="72rpx" :size="28" type="warning" shape="circle" @click="addCart">加入购物车</tui-button>
					</view>
					<view class="tui-flex-1">
						<tui-button height="72rpx" :size="28" type="danger" shape="circle" @click="goBuy">立即购买</tui-button>
					</view>
				</view>
				<view class="tui-right">
					<tui-icon name="close-fill" color="#999" :size="20" @click="hidePopup"></tui-icon>
				</view>
			</view>
		</tui-bottom-popup>
		<!--底部选择层-->

	</view>
</template>

<script>
	import TuiIcon from "../../components/thorui/tui-icon/tui-icon";
    export default {
        components: {TuiIcon},
        data() {
			return {
                videoContext:false,
			    play_video:false,
				height: 64, //header高度
				top: 26, //标题图标距离顶部距离
				scrollH: 0, //滚动总高度
				opcity: 0,
				iconOpcity: 0.5,
				banner: [],
				bannerIndex: 0,
				topMenu: [
					{icon: 'home',text: '首页',size: 23,badge: 0},
					{icon: 'people',text: '我的',size: 26,badge: 0},
					{icon: 'cart',text: '购物车',size: 23,badge: 0},
					{icon: 'share',text: '分享',size: 26,badge: 0}
				],
				menuShow: false,
				popupShow: false,
				value: 1,
				goods:{},
				specGoods:{},
				specs:{},
                options:{},
                isChooseSpec:false,
                buyOptionId:false,
				buyNum: 1,
                chooseSpecs:[],
                testid:0,
			};
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
			setTimeout(() => {
				uni.getSystemInfo({
					success: res => {
						this.width = obj.left || res.windowWidth;
						this.height = obj.top ? obj.top + obj.height + 8 : res.statusBarHeight + 44;
						this.top = obj.top ? obj.top + (obj.height - 32) / 2 : res.statusBarHeight + 6;
						this.scrollH = res.windowWidth;
					}
				});
			}, 0);
			this.getList()
			this.getPicker()
		},
        onReady: function(res) {
            this.videoContext = uni.createVideoContext('myVideo')
        },
		methods: {
            videoPlay(){
                this.videoContext.play()
                this.play_video = true
            },
            endPay(){
                this.videoContext.stop()
                this.play_video = false
            },
		    getList:function () {
		        if(!this.$Route.query.id){
		            this.$utils.toast('参数错误')
					setTimeout(()=>{this.$Router.back()},2000)
				}
				this.$http.get('goods.get_detail',{id:this.$Route.query.id}).then((res)=>{
					this.goods = res.goods
					this.banner = res.goods.thumbs
				})
            },
            getPicker:function () {
                if(!this.$Route.query.id){
                    this.$utils.toast('参数错误')
                    setTimeout(()=>{this.$Router.back()},2000)
                }
                this.$http.get('goods.get_picker',{id:this.$Route.query.id}).then((res)=>{
					this.options = res.options
					this.specs = res.specs
					this.specGoods = res.goods
                })
            },
			goBuy:function () {
                if(!this.buyOptionId && parseInt(this.goods.hasoption)==1 && this.popupShow){
                    this.$utils.toast('请选择你要购买的规格')
                    return;
                }
				if((this.buyOptionId && parseInt(this.goods.hasoption)==1) || (parseInt(this.goods.hasoption)==0 && this.popupShow == true)) { //|| parseInt(this.goods.hasoption)==0
                    this.popupShow = false
					const params = {goodsid:this.goods.id,total:this.buyNum}
					if(this.buyOptionId>0) params.optionid = this.buyOptionId
                    this.$Router.push({path:'/pages/order/submit',query:params})
					return;
				}
                this.popupShow = true
            },
			addCart:function () {
		        if(!this.buyOptionId && parseInt(this.goods.hasoption)==1 && this.popupShow){
					this.$utils.toast('请选择你要加入购物车的规格')
					return;
            	}
                if((this.buyOptionId && parseInt(this.goods.hasoption)==1 && this.popupShow == true) || (parseInt(this.goods.hasoption)==0 && this.popupShow == true)) { //|| parseInt(this.goods.hasoption)==0
                    this.popupShow = false
					this.$http.get('member.cart.add',{id:this.goods.id,total:this.buyNum,optionid:this.buyOptionId}).then((res)=>{
                        this.$utils.toast('加入购物车成功')
						this.buyNum = 1
					})
                    return;
                }
                this.popupShow = true
            },
            chooseSpec:function (spec,specItem) {
                this.$set(this.chooseSpecs,spec.id,specItem.id)
                const chooseSpecs = this.chooseSpecs.filter(function(n){return n});
				const spec_titles = chooseSpecs.join('_')
                this.options.map((item,index)=>{
                    if(item.specs == spec_titles){
                        this.goods.spec_titles = item.title
						this.buyOptionId = item.id
						this.specGoods.marketprice = item.marketprice
						this.specGoods.goodssn = item.goodssn
					}
				})
            },
			bannerChange: function(e) {
				this.bannerIndex = e.detail.current;
				console.log(e.detail.current)
				if(this.goods.video && this.play_video){
                    if(e.detail.current>0) this.videoContext.pause()
                    else this.videoContext.play()
                }
			},
			previewImage: function(e) {
				let index = e.currentTarget.dataset.index;
				uni.previewImage({
					current: this.banner[index],
					urls: this.banner
				});
			},
			openMenu: function() {
				this.menuShow = true;
			},
			closeMenu: function() {
				this.menuShow = false;
			},
			showPopup: function() {
				this.popupShow = true;
			},
			hidePopup: function() {
				this.popupShow = false;
			},
			change: function(e) {
				this.buyNum = e.value;
			},
			collecting: function() {
                this.$http.get('member.favorite.toggle',{id:this.goods.id,isfavorite:this.goods.isfavorite?0:1}).then((res)=>{
                    this.goods.isfavorite = !this.goods.isfavorite
				})
			},
			common: function() {
				this.$utils.toast('分享中...')
			},
			btnTopMenu(index) {
				this.closeMenu()
				switch (index){
					case 0:
                        this.$Router.push({name:'home_index'})
					    break;
					case 1:
                        this.$Router.push({name:'member_index'})
					    break;
					case 2:
					    this.$Router.push({name:'cart_index'})
					    break;
					case 3:
                        // #ifdef MP
                        this.common()
                        // #endif
                        // #ifndef MP
                        this.onShare()
                        // #endif
					    break;
				}
			},
			submit() {
				this.popupShow = false;
				uni.navigateTo({
					url: '../submitOrder/submitOrder'
				});
			},
			coupon() {
				uni.navigateTo({
					url: '../coupon/coupon'
				});
			},
			onShare() {
				//#ifdef APP-PLUS
				plus.share.sendWithSystem({
						href: "/pages/goods/detail?id="+this.goods.id,
                        content: "我给你分享了一个商品，快来看看吧",
					},
					function() {
						console.log('分享成功');
					},
					function(e) {
						console.log('分享失败：' + JSON.stringify(e));
					}
				);
				//#endif
				// #ifdef H5
				this.$utils.toast('分享中...')
				// #endif
			}
		},
		onPageScroll(e) {
			let scroll = e.scrollTop <= 0 ? 0 : e.scrollTop;
			let opcity = scroll / this.scrollH;
			if (this.opcity >= 1 && opcity >= 1) {
				return;
			}
			this.opcity = opcity;
			this.iconOpcity = 0.5 * (1 - opcity < 0 ? 0 : 1 - opcity);
		},
        onShareAppMessage(res) {
            if(!this.goods){
                this.$utils.toast('参数加载中...')
                return false;
            }
            return {
                path: "/pages/goods/detail?id="+this.goods.id,
                title: "我给你分享了一个商品，快来看看吧",
                imageUrl: this.goods.thumb,
                success:(res)=>{
                    this.$utils.toast('分享成功')
                },
                fail:()=>{
                    this.$utils.toast('分享失败')
                }
            }
        },
        onShareTimeline(res) {
            if(!this.goods){
                this.$utils.toast('参数加载中...')
                return false;
            }
            return {
                title: '我给你分享了一个商品，快来看看吧',
                imageUrl: this.goods.thumb,
                success:(res)=>{
                    this.$utils.toast('分享成功')
                },
                fail:()=>{
                    this.$utils.toast('分享失败')
                }
            }
        }
	};
</script>

<style>
	page {
		background-color: #f7f7f7;
	}

	.container {
		padding-bottom: 110rpx;
	}

	.tui-header-box {
		width: 100%;
		position: fixed;
		left: 0;
		top: 0;
		z-index: 995;
	}

	.tui-header {
		width: 100%;
		font-size: 18px;
		line-height: 18px;
		font-weight: 500;
		height: 32px;
		display: flex;
		/*align-items: center;*/
		justify-content: center;
		padding-top: 15rpx;
	}

	.tui-header-icon {
		width: 100%;
		padding-left:3%;
		padding-right:3%;
		position: fixed;
		top: 0;
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		height: 32px;
		transform: translateZ(0);
		z-index: 9999;
	}

	.tui-header-icon .tui-badge {
		background: #e41f19 !important;
		position: absolute;
		right: -4px;
	}

	.tui-icon-ml {
		margin-left: 20rpx;
	}

	.tui-icon-box {
		position: relative;
		height: 20px !important;
		width: 20px !important;
		padding: 15px !important;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-banner-swiper {
		position: relative;
	}

	.tui-banner-tag {
		position: absolute;
		color: #fff;
		bottom: 30rpx;
		right: 0;
	}

	.tui-slide-image {
		width: 100%;
		display: block;
	}

	/*顶部菜单*/

	.tui-menu-box {
		box-sizing: border-box;
	}

	.tui-menu-header {
		font-size: 34rpx;
		color: #fff;
		height: 32px;
		display: flex;
		align-items: center;
	}

	.tui-menu-itembox {
		color: #fff;
		padding: 40rpx 10rpx 0 10rpx;
		box-sizing: border-box;
		display: flex;
		flex-wrap: wrap;
		font-size: 26rpx;
	}

	.tui-menu-item {
		width: 22%;
		height: 160rpx;
		border-radius: 24rpx;
		display: flex;
		align-items: center;
		flex-direction: column;
		justify-content: center;
		background: rgba(0, 0, 0, 0.4);
		margin-right: 4%;
		margin-bottom: 4%;
	}

	.tui-menu-item:nth-of-type(4n) {
		margin-right: 0;
	}

	.tui-badge-box {
		position: relative;
	}

	.tui-badge-box .tui-badge-class {
		position: absolute;
		top: -8px;
		right: -8px;
	}

	.tui-msg-badge {
		top: -10px;
	}

	.tui-icon-up_box {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-menu-text {
		padding-top: 12rpx;
	}

	.tui-opcity .tui-menu-text,
	.tui-opcity .tui-badge-box {
		opacity: 0.5;
		transition: opacity 0.2s ease-in-out;
	}

	/*顶部菜单*/

	/*内容 部分*/

	.tui-padding {
		padding: 0 30rpx;
		box-sizing: border-box;
	}

	.tui-ml-auto {
		margin-left: auto;
	}

	/* #ifdef H5 */
	.tui-ptop {
		padding-top: 44px;
	}

	/* #endif */

	.tui-size {
		font-size: 24rpx;
		line-height: 24rpx;
	}


	.tui-icon-red {
		color: #ff201f;
	}

	.tui-border-radius {
		/*border-bottom-left-radius: 24rpx;*/
		/*border-bottom-right-radius: 24rpx;*/
		overflow: hidden;
	}

	.tui-radius-all {
		border-radius: 24rpx;
		overflow: hidden;
	}

	.tui-mtop {
		margin-top: 26rpx;
	}

	.tui-pro-detail {
		box-sizing: border-box;
		color: #333;
	}

	.tui-product-title {
		background: #fff;
		padding: 30rpx 0;
	}

	.tui-pro-pricebox {
		display: flex;
		align-items: center;
		justify-content: space-between;
		color: #ff201f;
		font-size: 36rpx;
		font-weight: bold;
		line-height: 44rpx;
	}

	.tui-pro-price {
		display: flex;
		align-items: center;
	}


	.tui-original-price {
		font-size: 26rpx;
		line-height: 26rpx;
		padding: 10rpx 30rpx;
		box-sizing: border-box;
	}

	.tui-line-through {
		text-decoration: line-through;
	}

	.tui-collection {
		color: #333;
		display: flex;
		align-items: center;
		flex-direction: column;
		justify-content: center;
		height: 44rpx;
	}

	.tui-scale-collection {
		transform: scale(0.7);
		transform-origin: center 90%;
		line-height: 24rpx;
		font-weight: normal;
		margin-top: 4rpx;
	}

	.tui-pro-titbox {
		font-size: 32rpx;
		font-weight: 500;
		position: relative;
		padding: 0 150rpx 0 30rpx;
		box-sizing: border-box;
	}

	.tui-pro-title {
		padding-top: 20rpx;
	}

	.tui-share-btn {
		display: block;
		background: transparent;
		margin: 0;
		padding: 0;
		border-radius: 0;
		border: 0;
	}

	.tui-share-btn::after {
		border: 0;
	}

	.tui-share-box {
		display: flex;
		align-items: center;
	}

	.tui-share-position {
		position: absolute;
		right: 0;
		top: 30rpx;
	}

	.tui-share-text {
		padding-left: 8rpx;
	}

	.tui-sub-title {
		padding: 20rpx 0;
		line-height: 32rpx;
	}

	.tui-sale-info {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding-top: 30rpx;
	}

	.tui-discount-box {
		background: #fff;
	}

	.tui-list-cell {
		width: 100%;
		position: relative;
		display: flex;
		align-items: center;
		font-size: 26rpx;
		line-height: 26rpx;
		padding: 36rpx 30rpx;
		box-sizing: border-box;
	}

	.tui-right {
		position: absolute;
		right: 30rpx;
		top: 30rpx;
	}

	.tui-top40 {
		top: 40rpx !important;
	}

	.tui-bold {
		font-weight: bold;
	}

	.tui-list-cell::after {
		content: '';
		position: absolute;
		border-bottom: 1rpx solid #eaeef1;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
		bottom: 0;
		right: 0;
		left: 126rpx;
	}

	.tui-last::after {
		border-bottom: 0 !important;
	}

	.tui-flex-center {
		display: flex;
		align-items: center;
	}


	.tui-cell-title {
		width: auto;
		margin-right: 30rpx;
		flex-shrink: 0;
        color: #999999;
	}

	.tui-promotion-box {
		display: flex;
		align-items: center;
		padding: 10rpx 0;
		width: 80%;
	}

	.tui-promotion-box text {
		width: 70%;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.tui-basic-info {
		background: #fff;
	}

	.tui-addr-box {
		width: 76%;
	}

	.tui-addr-item {
		padding: 10rpx;
		line-height: 34rpx;
	}

	.tui-guarantee {
		background: #fdfdfd;
		display: flex;
		flex-wrap: wrap;
		padding: 20rpx 30rpx 30rpx 30rpx;
		font-size: 24rpx;
	}

	.tui-guarantee-item {
		color: #999;
		padding-right: 30rpx;
		padding-top: 10rpx;
	}

	.tui-pl {
		padding-left: 4rpx;
	}

	.tui-cmt-box {
		background: #fff;
	}

	.tui-between {
		justify-content: space-between !important;
	}

	.tui-cmt-all {
		color: #FF5000;
		padding-right: 8rpx;
	}

	.tui-cmt-content {
		font-size: 26rpx;
	}

	.tui-cmt-user {
		display: flex;
		align-items: center;
	}

	.tui-acatar {
		width: 60rpx;
		height: 60rpx;
		border-radius: 30rpx;
		display: block;
		margin-right: 16rpx;
	}

	.tui-cmt {
		padding: 14rpx 0;
	}

	.tui-attr {
		font-size: 24rpx;
		color: #999;
		padding: 6rpx 0;
	}

	.tui-cmt-btn {
		padding: 50rpx 0 30rpx 0;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-nomore-box {
		padding-top: 10rpx;
	}

	.tui-product-img {
		display: flex;
		flex-direction: column;
		transform: translateZ(0);
	}

	.tui-product-img image {
		width: 100%;
		display: block;
	}

	/*底部操作栏*/

	.tui-col-7 {
		width: 58.33333333%;
	}

	.tui-col-5 {
		width: 41.66666667%;
	}

	.tui-operation {
		width: 100%;
		height: 100rpx;
		background: rgba(255, 255, 255, 0.98);
		position: fixed;
		display: flex;
		align-items: center;
		justify-content: space-between;
		z-index: 10;
		bottom: 0;
		left: 0;
		/*padding-bottom: env(safe-area-inset-bottom);*/
	}

	.tui-safearea-bottom {
		width: 100%;
		height: env(safe-area-inset-bottom);
	}

	.tui-operation::before {
		content: '';
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		border-top: 1rpx solid #eaeef1;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.tui-operation-left {
		display: flex;
		align-items: center;
	}

	.tui-operation-item {
		flex: 1;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		position: relative;
	}

	.tui-operation-text {
		font-size: 22rpx;
		color: #333;
	}

	.tui-opacity {
		opacity: 0.5;
	}

	.tui-scale-small {
		transform: scale(0.9);
		transform-origin: center center;
	}

	.tui-operation-right {
		height: 100rpx;
		padding-top: 0;
	}

	.tui-right-flex {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-flex-1 {
		flex: 1;
		padding: 16rpx;
	}

	/*底部操作栏*/

	/*底部选择弹层*/

	.tui-popup-class {
		border-top-left-radius: 24rpx;
		border-top-right-radius: 24rpx;
		/*padding-bottom: env(safe-area-inset-bottom);*/
	}

	.tui-popup-box {
		position: relative;
		padding: 30rpx 0 100rpx 0;
	}

	.tui-popup-btn {
		width: 100%;
		position: absolute;
		left: 0;
		bottom: 0;
	}

	/* .tui-popup-btn .tui-btn-class {
		width: 90% !important;
		display: block !important;
		font-size: 28rpx !important;
	} */

	/* .tui-icon-close {
		position: absolute;
		top: 30rpx;
		right: 30rpx;
	} */

	.tui-product-box {
		display: flex;
		align-items: flex-end;
		font-size: 24rpx;
		padding-bottom: 30rpx;
	}

	.tui-popup-img {
		height: 200rpx;
		width: 200rpx;
		border-radius: 24rpx;
		display: block;
	}

	.tui-popup-price {
		padding-left: 20rpx;
		padding-bottom: 8rpx;
	}

	.tui-amount {
		color: #ff201f;
		font-size: 36rpx;
	}

	.tui-number {
		font-size: 24rpx;
		line-height: 24rpx;
		padding-top: 12rpx;
		color: #999;
	}

	.tui-popup-scroll {
		height: 600rpx;
		font-size: 26rpx;
	}

	.tui-scrollview-box {
		padding: 0 30rpx 60rpx 30rpx;
		box-sizing: border-box;
	}

	.tui-attr-title {
		padding: 10rpx 0;
		color: #333;
	}

	.tui-attr-box {
		font-size: 0;
		padding: 20rpx 0;
	}

	.tui-attr-item {
		max-width: 100%;
		min-width: 200rpx;
		height: 64rpx;
		display: -webkit-inline-flex;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		background: #f7f7f7;
		padding: 0 26rpx;
		box-sizing: border-box;
		border-radius: 32rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		font-size: 26rpx;
	}

	.tui-attr-active {
		background: #fcedea !important;
		color: #e41f19;
		font-weight: bold;
		position: relative;
	}

	.tui-attr-active::after {
		content: '';
		position: absolute;
		border: 1rpx solid #e41f19;
		width: 100%;
		height: 100%;
		border-radius: 40rpx;
		left: 0;
		top: 0;
	}

	.tui-number-box {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 20rpx 0 30rpx 0;
		box-sizing: border-box;
	}

	/*底部选择弹层*/
   /* >>> .tui-btn-danger{
        background: #F8B600 !important;
    }*/

    .app-video{
        content: "";
        z-index: 1;
        position: absolute;
        /*left: 50%;
        top: 50%;*/
        width: 150rpx;
        height: 150rpx;
        margin: auto;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        /*margin-left: -150rpx;*/
        /*margin-top: -150rpx;*/
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIgAAACICAYAAAA8uqNSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyNpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChNYWNpbnRvc2gpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkJDNzkzQ0VEOTYxMjExRTY5MDFGQzk4MDNCQUU3RTc2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkJDNzkzQ0VFOTYxMjExRTY5MDFGQzk4MDNCQUU3RTc2Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QkM3OTNDRUI5NjEyMTFFNjkwMUZDOTgwM0JBRTdFNzYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QkM3OTNDRUM5NjEyMTFFNjkwMUZDOTgwM0JBRTdFNzYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5VQHeuAAAZfElEQVR42uxdCVQT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) center center no-repeat;
        background-size: cover;
    }
</style>
