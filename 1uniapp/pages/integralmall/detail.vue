<template>
	<view class="container">
		<!--header-->
		<view class="tui-header-box" :style="{ height: height + 'px', background: 'rgba(255,255,255,' + opcity + ')' }">
			<view class="tui-header" :style="{ marginTop: top + 'px', opacity: opcity }">商品详情</view>
			<view class="tui-header-icon" :style="{ marginTop: top + 'px' }">
				<view class="tui-icon-box" :style="{ backgroundColor: 'rgba(0, 0, 0,' + iconOpcity + ')' }" @tap="$Router.back()">
					<tui-icon name="arrowleft" :size="30" :color="opcity >= 1 ? '#000' : '#fff'"></tui-icon>
				</view>

				<!--<view class="tui-icon-box tui-icon-ml" :style="{backgroundColor: 'rgba(0, 0, 0,' + iconOpcity + ')'}" @tap.stop="openMenu">
					<tui-icon name="more-fill" :size="20" :color="opcity >= 1 ? '#000' : '#fff'"></tui-icon>
				</view>-->

			</view>
		</view>
		<!--header-->

		<!--banner-->
		<!--<view class="tui-banner-swiper">
			<swiper :autoplay="true" :interval="5000" :duration="150" :circular="true" :style="{ height: scrollH + 'px' }"
			 @change="bannerChange">
				<block>
					<swiper-item @tap.stop="previewImage">
						<image :src="goods.thumb" class="tui-slide-image" :style="{ height: scrollH + 'px' }" />
					</swiper-item>
				</block>
			</swiper>

		</view>-->
		<view class="tui-banner-swiper">
			<swiper :autoplay="true" :interval="5000" :duration="150" :circular="false" :style="{ height: scrollH + 'px' }"
					@change="bannerChange">
				<block v-for="(item, index) in banner" :key="index">
					<swiper-item :data-index="index" @tap.stop="previewImage">
						<image :src="item" class="tui-slide-image" :style="{ height: scrollH + 'px' }" />
					</swiper-item>
				</block>
			</swiper>
			<view class="tui-banner-tag">
				<tui-tag padding="12rpx 18rpx" type="translucent" shape="circleLeft" :scaleMultiple="0.82" originRight>{{ bannerIndex + 1 }}/{{ banner.length }}</tui-tag>
			</view>
		</view>

		<!--banner-->

		<view class="tui-pro-detail" style="background-color: #fff">
			<view class="tui-product-title tui-border-radius" >

				<view class="tui-pro-titbox">
					<view class="tui-pro-title text-xl">{{goods.title}}</view>
				</view>

				<view class="tui-pro-pricebox tui-padding margin-top-sm">
					<view class="tui-pro-price">
						<view class="flex align-center">
							<view class="cu-avatar sm radius" style="background-color: #FF107F;">积</view>
							<text class="margin-left-sm" style="color: #FF107F;">{{goods.credit}}</text>
							<view class="tui-original-price text-gray">
								原积分 <text class="tui-line-through margin-left-sm">{{goods.old_credit}}</text>
							</view>
						</view>
					</view>
				</view>

			</view>


			<view class="tui-nomore-box" >
				<tui-nomore text="宝贝详情" backgroundColor="#fff"></tui-nomore>
			</view>
			<view class="tui-product-img tui-radius-all image-block">
				<jyf-parser :html="goods.goodsdetail" ref="article"></jyf-parser>
			</view>
			<tui-nomore text="已经到最底了" backgroundColor="#fff"></tui-nomore>
			<view class="tui-safearea-bottom"></view>
		</view>

		<!--底部操作栏-->
		<!--<view class="tui-operation">
			<view class="tui-operation-left tui-col-3">
				<view @click="$Router.pushTab({name:'home_index'})" class="tui-operation-item" hover-class="tui-opcity" :hover-stay-time="150">
					<tui-icon name="home" :size="22" color="#333"></tui-icon>
					<view class="tui-operation-text tui-scale-small">首页</view>
				</view>
				<view @click="$Router.pushTab({name:'cart_index'})" class="tui-operation-item" hover-class="tui-opcity" :hover-stay-time="150">
					<tui-icon name="cart" :size="22" color="#333"></tui-icon>
					<view class="tui-operation-text tui-scale-small">购物车</view>
					&lt;!&ndash;<tui-badge type="red" absolute :scaleRatio="0.8" right="10rpx" top="-4rpx">9</tui-badge>&ndash;&gt;
				</view>
			</view>
			<view class="tui-operation-right tui-right-flex tui-col-9 tui-btnbox-4">
				<view class="tui-flex-1">
					<tui-button height="68rpx" :size="26" type="danger" shape="circle" @click="goBuy">立即兑换</tui-button>
				</view>
			</view>
		</view>-->
		<view style="position: fixed;bottom: 1%;left: 0;right: 0;width: 90%;margin: 0 auto;z-index: 2;">
			<tui-button shadow shape="circle" type="danger" height="88rpx" @click="goBuy" style="background: #FF107F !important;">立即兑换</tui-button>
		</view>

		<!--底部操作栏--->



		<!--底部选择层-->
		<tui-bottom-popup :show="popupShow" @close="hidePopup">
			<view class="tui-popup-box">
				<view class="tui-product-box tui-padding">
					<image :src="specGoods.thumb" class="tui-popup-img"></image>
					<view class="tui-popup-price">
						<view class="tui-amount tui-bold flex align-center">
							<view class="cu-avatar sm radius" style="background-color: #FF107F;">积</view>
							<view class="margin-left-sm" style="color: #FF107F;">{{specGoods.credit}}</view>
						</view>
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
							<tui-numberbox :max="1" :min="1" :value="buyNum" disabled @change="change"></tui-numberbox>
						</view>

					</view>
				</scroll-view>
				<view class="tui-operation tui-operation-right tui-right-flex tui-popup-btn">
					<view class="tui-flex-1">
						<!--<tui-button height="72rpx" :size="28" type="danger" shape="circle" @click="goBuy">立即兑换</tui-button>-->
						<tui-button shadow shape="circle" type="danger" height="78rpx" @click="goBuy" style="background: #FF107F !important;">立即兑换</tui-button>
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
	export default {
		data() {
			return {
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
					{icon: 'cart',text: '购物车',size: 23,badge: 2},
					{icon: 'share',text: '分享',size: 26,badge: 0}
				],
				menuShow: false,
				popupShow: false,
				value: 1,
				collected: false,
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
		},
		methods: {
		    getList:function () {
		        if(!this.$Route.query.id){
		            this.$utils.toast('参数错误')
					setTimeout(()=>{this.$Router.back()},2000)
				}
				this.$http.get('creditshop.detail',{id:this.$Route.query.id}).then((res)=>{
					this.goods = res.goods
					this.banner = res.goods.thumbs
                    if(parseInt(res.goods.hasoption)==1) this.getPicker()
				})
            },
            getPicker:function () {
                if(!this.$Route.query.id){
                    this.$utils.toast('参数错误')
                    setTimeout(()=>{this.$Router.back()},2000)
                }
                this.$http.get('creditshop.detail.option',{id:this.$Route.query.id}).then((res)=>{
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
				if(parseInt(this.goods.hasoption)==0 || (this.popupShow == true && parseInt(this.goods.hasoption)==1) || (parseInt(this.goods.hasoption)==0 && this.popupShow == true)) { //|| parseInt(this.goods.hasoption)==0
                    this.popupShow = false
					const params = {goodsid:this.goods.id}
					if(this.buyOptionId>0) params.optionid = this.buyOptionId
                    this.$Router.push({path:'/pages/integralmall/submit',query:params})
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
						this.specGoods.credit = item.credit
						this.specGoods.goodssn = item.goodssn
					}
				})
            },
			bannerChange: function(e) {
				this.bannerIndex = e.detail.current;
			},
			previewImage_bak: function(e) {
				let index = e.currentTarget.dataset.index;
				uni.previewImage({
					current: this.goods.thumb,
					urls: [this.goods.thumb]
				});
			},
            previewImage: function(e) {
                let index = e.currentTarget.dataset.index;
                uni.previewImage({
                    current: this.banner[index],
                    urls: this.banner
                });
            },
			back: function() {
				uni.navigateBack();
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
				this.collected = !this.collected;
			},
			common: function() {
				this.tui.toast('功能开发中~');
			},
			btnTopMenu(index) {
				this.closeMenu()
				if (index == 4) {
					uni.makePhoneCall({
						phoneNumber: "10086"
					})
				} else if (index == 6) {
                    // #ifdef MP
                    this.common()
                    // #endif
					
					// #ifndef MP
					this.onShare()
					// #endif
				} else {
					let url = {
						0: '../message/message',
						1: "../mall/mall",
						2: '../my/my',
						3: '../shopcart/shopcart',
						5: '/pages/my/feedback/feedback?page=mall'
					} [index];
					url && this.tui.href(url)
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
						content: 'ThorUI商城模板',
						href: 'https://www.thorui.cn/'
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
				location.href = "https://www.thorui.cn/"
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
		}
	};
</script>

<style>
	page {
		background-color: #fff;
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
		justify-content: center;
		position: fixed;
		top: 0;
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
		border-bottom-left-radius: 24rpx;
		border-bottom-right-radius: 24rpx;
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

	.tui-price {
		font-size: 58rpx;
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
		width: 66rpx;
		margin-right: 30rpx;
		flex-shrink: 0;
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
		color: #ff201f;
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
		margin-top: -30rpx;
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
		padding-bottom: env(safe-area-inset-bottom);
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
		padding-bottom: env(safe-area-inset-bottom);
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
</style>
