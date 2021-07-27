<template>
	<view class="container">

		<!--header-->
		<!--<view class="tui-header" :style="{'padding-top':paddingTop+'rpx'}">
			<view class="tui-rolling-search">
				<tui-icon name="search-2" :size="32" unit="rpx"></tui-icon>
				<swiper vertical autoplay circular interval="8000" class="tui-swiper">
					<swiper-item v-for="(item, index) in hotSearch" :key="index" class="tui-swiper-item" @tap="search">
						<view class="tui-hot-item">{{ item }}</view>
					</swiper-item>
				</swiper>
			</view>
			<view class="tui-header-icon padding-left-sm" @click="$Router.push({name:'message_index'})">
				<tui-icon name="message" color="#ffffff" :size="60" unit="rpx"></tui-icon>
			</view>
		</view>-->
		<!--header-->

		<!--<view class="tui-header-banner">

			<view class="tui-banner-bg">
				<view class="tui-primary-bg tui-route-left"></view>
				<view class="tui-primary-bg tui-route-right"></view>
				&lt;!&ndash;banner&ndash;&gt;

				<view class="tui-banner-box">
					<swiper
							:indicator-dots="true"
							:autoplay="true"
							:interval="5000"
							:duration="150"
							class="tui-banner-swiper"
							:circular="true"
							indicator-color="rgba(255, 255, 255, 0.8)"
							indicator-active-color="#fff"
					>
						<swiper-item v-for="(item, index) in banner" :key="index" @tap.stop="detail">
							<image :src="'http://deng.alijuly.cn/static/images/mall/banner/' + item" class="tui-slide-image" mode="scaleToFill" />
						</swiper-item>
					</swiper>
				</view>

			</view>
		</view>-->

		<view class="tui-banner-box">
			<swiper
					:indicator-dots="true"
					:autoplay="true"
					:interval="5000"
					:duration="150"
					class="tui-banner-swiper"
					:circular="true"
					previous-margin="60rpx"
					next-margin="60rpx"
					@change="change"
			>
				<swiper-item v-for="(item, index) in banner" :key="index" class="tui-banner-item">
					<image
							:src="'https://thorui.cn/images/mall/banner/' + item"
							class="tui-slide-image"
							:class="[current != index ? 'tui-banner-scale' : '']"
							mode="scaleToFill"
							lazy-load
							@tap="detail"
					/>
				</swiper-item>
			</swiper>
		</view>


		<view class="tui-product-category" >
			<view class="tui-category-item" @click="$Router.push({name:'goods_list'})">
				<image src="http://appstore.bai918.com/static/app/images/index_grid_integralmall.png" class="tui-category-img" mode="widthFix"></image>
				<view class="tui-category-name margin-top-sm">全部商品</view>
			</view>
			<view class="tui-category-item" @click="$Router.push({name:'goods_list'})">
				<image src="http://appstore.bai918.com/static/app/images/index_grid_hot.png" class="tui-category-img" mode="widthFix"></image>
				<view class="tui-category-name margin-top-sm">热卖商品</view>
			</view>
			<view class="tui-category-item" @click="$Router.push({name:'appoint_index'})">
				<image src="http://appstore.bai918.com/static/app/images/index_grid_cart.png" class="tui-category-img" mode="widthFix"></image>
				<view class="tui-category-name margin-top-sm">在线预约</view>
			</view>
			<view class="tui-category-item" @click="$Router.push({name:'kefu_index'})">
				<image src="http://appstore.bai918.com/static/app/images/index_grid_kefu.png" class="tui-category-img" mode="widthFix"></image>
				<view class="tui-category-name margin-top-sm">联系客服{{$store.getters.StatusBar}}</view>
			</view>
			<view class="tui-category-item" @click="$Router.push({name:'kefu_index'})">
				<image src="http://appstore.bai918.com/static/app/images/index_grid_kefu.png" class="tui-category-img" mode="widthFix"></image>
				<view class="tui-category-name margin-top-sm">联系客服</view>
			</view>
		</view>


		<view class="tui-product-box tui-pb-20 tui-bg-white">
			<view class="tui-group-name" @tap="more">
				<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>
				<text class="padding-lr-xs">新品推荐</text>
				<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>
			</view>
			<view class="tui-new-box">
				<view class="tui-new-item" :class="[index != 0 && index != 1 ? 'tui-new-mtop' : '']" v-for="(item, index) in newProduct" :key="index" @tap="detail">
					<image :src="'https://deng.alijuly.cn/static/images/mall/new/' + (item.type == 1 ? 'new' : 'discount') + '.png'" class="tui-new-label" v-if="item.isLabel"></image>
					<view class="tui-title-box">
						<view class="tui-new-title">{{ item.name }}</view>
						<view class="tui-new-price">
							<text class="tui-new-present">￥{{ item.present }}</text>
							<text class="tui-new-original">￥{{ item.original }}</text>
						</view>
					</view>
					<image :src="'https://deng.alijuly.cn/static/images/mall/new/' + item.pic" class="tui-new-img"></image>
				</view>
			</view>
		</view>

		<view class="tui-product-box">
			<view class=" text-center padding-tb-lg">
				<image src="https://thorui.cn/images/mall/img_home_update_3x.png" style="width: 50%;height: 32rpx;" mode="widthFix"></image>
			</view>
			<view class="tui-product-list">
				<view class="tui-product-container">
					<block v-for="(item, index) in productList" :key="index" v-if="(index + 1) % 2 != 0">
						<!--商品列表-->
						<view class="tui-pro-item" hover-class="hover" :hover-start-time="150" @tap="detail">
							<image :src="'https://deng.alijuly.cn/static/images/mall/product/' + item.img + '.jpg'" class="tui-pro-img" mode="widthFix" />
							<view class="tui-pro-content">
								<view class="tui-pro-tit">{{ item.name }}</view>
								<view>
									<view class="tui-pro-price">
										<text class="tui-sale-price">￥{{ item.sale }}</text>
										<text class="tui-factory-price">￥{{ item.factory }}</text>
									</view>
									<view class="tui-pro-pay">{{ item.payNum }}人付款</view>
								</view>
							</view>
						</view>
						<!--商品列表-->
						<!-- <template is="productItem" data="{{item,index:index}}" /> -->
					</block>
				</view>
				<view class="tui-product-container">
					<block v-for="(item, index) in productList" :key="index" v-if="(index + 1) % 2 == 0">
						<!--商品列表-->
						<view class="tui-pro-item" hover-class="hover" :hover-start-time="150" @tap="detail">
							<image :src="'https://deng.alijuly.cn/static/images/mall/product/' + item.img + '.jpg'" class="tui-pro-img" mode="widthFix" />
							<view class="tui-pro-content">
								<view class="tui-pro-tit">{{ item.name }}</view>
								<view>
									<view class="tui-pro-price">
										<text class="tui-sale-price">￥{{ item.sale }}</text>
										<text class="tui-factory-price">￥{{ item.factory }}</text>
									</view>
									<view class="tui-pro-pay">{{ item.payNum }}人付款</view>
								</view>
							</view>
						</view>
						<!--商品列表-->
						<!-- <template is="productItem" data="{{item,index:index}}" /> -->
					</block>
				</view>
			</view>
		</view>

		<!--加载loadding-->
		<tui-loadmore v-if="loadding" :index="3" type="red"></tui-loadmore>
		<!-- <tui-nomore v-if="!pullUpOn"></tui-nomore> -->
		<!--加载loadding-->
		<view class="tui-safearea-bottom"></view>
	</view>
</template>
<script>
    export default {
        data() {
            return {
                paddingTop: 0,
                current: 0,
                hotSearch: ['休闲零食', '自热火锅', '小冰箱迷你'],
                banner: ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'],
                category: [
                    {img: '1.jpg',name: '全部商品'},
                    {img: '1.jpg',name: '全部分类'},
                    {img: '1.jpg',name: '购物车'},
                    {img: '1.jpg',name: '联系客服'},
                ],
                newProduct: [
                    {
                        name: '时尚舒适公主裙高街修身长裙',
                        present: 198,
                        original: 298,
                        pic: '1.jpg',
                        type: 1,
                        isLabel: true
                    },
                    {
                        name: '高街修身雪纺衫',
                        present: 398,
                        original: 598,
                        pic: '2.jpg',
                        type: 2,
                        isLabel: true
                    },
                    {
                        name: '轻奢商务上衣',
                        present: 99,
                        original: 199,
                        pic: '3.jpg',
                        type: 1,
                        isLabel: true
                    },
                    {
                        name: '品质牛皮婚鞋牛皮婚鞋品质就是好',
                        present: 99,
                        original: 199,
                        pic: '5.jpg',
                        type: 1,
                        isLabel: true
                    },
                    {
                        name: '轻奢时尚大包限时新品推荐',
                        present: 99,
                        original: 199,
                        pic: '6.jpg',
                        type: 1,
                        isLabel: false
                    },
                    {
                        name: '高街修身长裙',
                        present: 999,
                        original: 1299,
                        pic: '4.jpg',
                        type: 2,
                        isLabel: true
                    }
                ],
                productList: [
                    {
                        img: 1,
                        name: '欧莱雅（LOREAL）奇焕光彩粉嫩透亮修颜霜 30ml（欧莱雅彩妆 BB霜 粉BB 遮瑕疵 隔离）',
                        sale: 599,
                        factory: 899,
                        payNum: 2342
                    },
                    {
                        img: 2,
                        name: '德国DMK进口牛奶  欧德堡（Oldenburger）超高温处理全脂纯牛奶1L*12盒',
                        sale: 29,
                        factory: 69,
                        payNum: 999
                    },
                    {
                        img: 3,
                        name: '【第2支1元】柔色尽情丝柔口红唇膏女士不易掉色保湿滋润防水 珊瑚红',
                        sale: 299,
                        factory: 699,
                        payNum: 666
                    },
                    {
                        img: 4,
                        name: '百雀羚套装女补水保湿护肤品',
                        sale: 1599,
                        factory: 2899,
                        payNum: 236
                    },
                    {
                        img: 5,
                        name: '百草味 肉干肉脯 休闲零食 靖江精制猪肉脯200g/袋',
                        sale: 599,
                        factory: 899,
                        payNum: 2399
                    },
                    {
                        img: 6,
                        name: '短袖睡衣女夏季薄款休闲家居服短裤套装女可爱韩版清新学生两件套 短袖粉色长颈鹿 M码75-95斤',
                        sale: 599,
                        factory: 899,
                        payNum: 2399
                    },
                    {
                        img: 1,
                        name: '欧莱雅（LOREAL）奇焕光彩粉嫩透亮修颜霜',
                        sale: 599,
                        factory: 899,
                        payNum: 2342
                    },
                    {
                        img: 2,
                        name: '德国DMK进口牛奶',
                        sale: 29,
                        factory: 69,
                        payNum: 999
                    },
                    {
                        img: 3,
                        name: '【第2支1元】柔色尽情丝柔口红唇膏女士不易掉色保湿滋润防水 珊瑚红',
                        sale: 299,
                        factory: 699,
                        payNum: 666
                    },
                    {
                        img: 4,
                        name: '百雀羚套装女补水保湿护肤品',
                        sale: 1599,
                        factory: 2899,
                        payNum: 236
                    }
                ],
                pageIndex: 1,
                loadding: false,
                pullUpOn: true
            };
        },
		onLoad(){
            this.paddingTop = this.CustomBar
		},
        methods: {
            tabbarSwitch: function(e) {
                let index = e.currentTarget.dataset.index;
                // this.current = index;
                if (index != 0) {
                    if (index == 1) {
                        this.classify();
                    } else if (index == 2) {
                        uni.navigateTo({
                            url: '../shopcart/shopcart'
                        });
                    } else {
                        uni.navigateTo({
                            url: '../my/my'
                        });
                    }
                }
            },
            detail: function() {
                uni.navigateTo({
                    url: '../productDetail/productDetail'
                });
            },
            coupon() {
                uni.navigateTo({
                    url: '../coupon/coupon'
                });
            },
            classify: function() {
                uni.navigateTo({
                    url: '../classify/classify'
                });
            },
            more: function(e) {
                let key = e.currentTarget.dataset.key || '';
                uni.navigateTo({
                    url: '../productList/productList?searchKey=' + key
                });
            },
            search: function() {
                uni.navigateTo({
                    url: '../../news/search/search'
                });
            }
        },

    };
</script>

<style>
	page {
		background-color: #f7f7f7;
	}

	.container {
		padding-bottom: 100rpx;
		color: #333;
	}

	/*tabbar*/

	.tui-tabbar {
		width: 100%;
		position: fixed;
		display: flex;
		align-items: center;
		justify-content: space-between;
		z-index: 99999;
		background: #fff;
		height: 100rpx;
		left: 0;
		bottom: 0;
		padding-bottom: env(safe-area-inset-bottom);
	}

	.tui-safearea-bottom {
		width: 100%;
		height: env(safe-area-inset-bottom);
	}

	.tui-tabbar::before {
		content: '';
		width: 100%;
		border-top: 1rpx solid #d9d9d9;
		position: absolute;
		top: 0;
		left: 0;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.tui-tabbar-item {
		flex: 1;
		width: 25%;
		display: flex;
		align-items: center;
		flex-direction: column;
		justify-content: center;
		font-size: 24rpx;
		color: #666;
		height: 80rpx;
	}

	.tui-ptop-4 {
		padding-top: 4rpx;
	}

	.tui-scale {
		font-weight: bold;
		transform: scale(0.8);
		transform-origin: center 100%;
		line-height: 30rpx;
	}

	.tui-item-active {
		color: #e41f19 !important;
	}

	/*tabbar*/

	.tui-header {
		width: 100%;
		padding: 0 30rpx 10rpx 20rpx;
		/*box-sizing: border-box;*/
		background-color: #e41f19;
		display: flex;
		align-items: center;
		justify-content: space-between;
		position: fixed;
		left: 0;
		top: 0;
		z-index: 999;
	}

	.tui-rolling-search {
		width: 100%;
		height: 60rpx;
		border-radius: 35rpx;
		padding: 0 40rpx 0 30rpx;
		box-sizing: border-box;
		background-color: #fff;
		display: flex;
		align-items: center;
		flex-wrap: nowrap;
		color: #999;
	}

	.tui-category {
		font-size: 24rpx;
		color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		margin: 0;
		margin-right: 22rpx;
		flex-shrink: 0;
	}

	.tui-category-scale {
		transform: scale(0.7);
		line-height: 24rpx;
	}

	.tui-icon-category {
		line-height: 20px !important;
		margin-bottom: 0 !important;
	}

	.tui-swiper {
		font-size: 26rpx;
		height: 60rpx;
		flex: 1;
		padding-left: 12rpx;
	}

	.tui-swiper-item {
		display: flex;
		align-items: center;
	}

	.tui-hot-item {
		line-height: 26rpx;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.tui-header-banner {
		/*padding-top: 160rpx;*/
		box-sizing: border-box;
		background: #e41f19;
	}

	.tui-hot-search {
		color: #fff;
		font-size: 24rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 20rpx;
		box-sizing: border-box;
		position: relative;
		z-index: 2;
	}

	.tui-hot-tag {
		background-color: rgba(255, 255, 255, 0.15);
		padding: 10rpx 24rpx;
		border-radius: 30rpx;
		display: flex;
		align-items: center;
		justify-content: center;
		line-height: 24rpx;
	}

	.tui-banner-bg {
		display: flex;
		height: 180rpx;
		background-color: #e41f19;
		position: relative;
	}

	.tui-primary-bg {
		width: 50%;
		display: inline-block;
		height: 224rpx;
		border: 1px solid transparent;
		position: relative;
		z-index: 1;
		background-color: #e41f19;
	}

	.tui-route-left {
		transform: skewY(8deg);
	}

	.tui-route-right {
		transform: skewY(-8deg);
	}

	.tui-banner-box {
		width: 100%;
		padding: 0 20rpx;
		box-sizing: border-box;
		position: absolute;
		/* overflow: hidden; */
		z-index: 99;
		/*bottom: -80rpx;*/
		top: 0;
		left: 0;
	}

	.tui-banner-swiper {
		width: 100%;
		/*height: 240rpx;*/
		height: 280rpx;
		border-radius: 12rpx;
		overflow: hidden;
		transform: translateY(0);
	}

	.tui-slide-image {
		width: 100%;
		/*height: 240rpx;*/
		height: 280rpx;
		display: block;
	}

	/* #ifdef MP-WEIXIN */
	.tui-banner-swiper .wx-swiper-dot {
		width: 8rpx;
		height: 8rpx;
		display: inline-flex;
		background: none;
		justify-content: space-between;
	}

	.tui-banner-swiper .wx-swiper-dot::before {
		content: '';
		flex-grow: 1;
		background-color: rgba(255, 255, 255, 0.8);
		border-radius: 16rpx;
		overflow: hidden;
	}

	.tui-banner-swiper .wx-swiper-dot-active::before {
		background-color: #fff;
	}

	.tui-banner-swiper .wx-swiper-dot.wx-swiper-dot-active {
		width: 16rpx;
	}

	/* #endif */

	/* #ifndef MP-WEIXIN */
	>>> .tui-banner-swiper .uni-swiper-dot {
			width: 8rpx;
			height: 8rpx;
			display: inline-flex;
			background-color: none;
			justify-content: space-between;
		}

	>>> .tui-banner-swiper .uni-swiper-dot::before {
			content: '';
			flex-grow: 1;
			background-color: rgba(255, 255, 255, 0.8);
			border-radius: 16rpx;
			overflow: hidden;
		}

	>>> .tui-banner-swiper .uni-swiper-dot-active::before {
			background-color: #fff;
		}

	>>> .tui-banner-swiper .uni-swiper-dot.uni-swiper-dot-active {
			width: 16rpx;
		}

	/* #endif */

	.tui-product-category {
		background-color: #fff;
		padding: 90rpx 10rpx 40rpx 10rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		font-size: 24rpx;
		color: #555;
	}

	.tui-category-item {
		width: 20%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-direction: column;
		padding-top: 30rpx;
	}

	.tui-category-img {
		width: 62%;
		display: block;
	}

	.tui-category-name {
		line-height: 24rpx;
	}

	.tui-product-box {
		margin-top: 20rpx;
		padding: 0 20rpx;
		box-sizing: border-box;
	}

	.tui-pb-20 {
		padding-bottom: 20rpx;
	}

	.tui-bg-white {
		background-color: #fff;
	}

	.tui-group-name {
		width: 100%;
		font-size: 32rpx;
		font-weight: bold;
		text-align: center;
		padding: 24rpx 0;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.tui-activity-box {
		display: flex;
		border-radius: 12rpx;
		overflow: hidden;
	}

	.tui-activity-img {
		width: 50%;
		display: block;
	}

	.tui-new-box {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
	}

	.tui-new-item {
		width: 49%;
		height: 200rpx;
		padding: 0 20rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		background: #f5f2f9;
		position: relative;
		border-radius: 12rpx;
	}

	.tui-new-mtop {
		margin-top: 2%;
	}

	.tui-title-box {
		font-size: 24rpx;
	}

	.tui-new-title {
		line-height: 32rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.tui-new-price {
		padding-top: 18rpx;
	}

	.tui-new-present {
		color: #ff201f;
		font-weight: bold;
	}

	.tui-new-original {
		display: inline-block;
		color: #a0a0a0;
		text-decoration: line-through;
		padding-left: 12rpx;
		transform: scale(0.8);
		transform-origin: center center;
	}

	.tui-new-img {
		width: 160rpx;
		height: 160rpx;
		display: block;
		flex-shrink: 0;
	}

	.tui-new-label {
		width: 56rpx;
		height: 56rpx;
		border-top-left-radius: 12rpx;
		position: absolute;
		left: 0;
		top: 0;
	}

	.tui-product-list {
		display: flex;
		justify-content: space-between;
		flex-direction: row;
		flex-wrap: wrap;
		box-sizing: border-box;
		/* padding-top: 20rpx; */
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
</style>
