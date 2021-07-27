<template>
	<view class=" ">


        <view class="container u-skeleton">

            <tui-navigation-bar backgroundColor="#fff" :isFixed="true" :isOpacity="false" :isImmersive="false">
                <view class="tui-content-box u-skeleton-rect" @click="$Router.push({name:'index_search'})">
                    <view class="tui-search-box">
                        <tui-icon name="search-2" :size="18" color="#bfbfbf"></tui-icon>
                        <view class="tui-search-text">请输入商品名称</view>
                    </view>
                </view>
            </tui-navigation-bar>
            <u-gap height="88" bg-color="#fff"></u-gap>

            <u-swiper :list="advs" name="thumb" :height="750" indicator-pos="bottomRight" mode="rect" class="u-skeleton-rect"></u-swiper>
            <view class="tui-product-category" >
                <block v-for="(item,index) in category">
                    <view class="tui-category-item" @click="$Router.push({name:'goods_list',params:{cate_id:item.id}})">
                        <image :src="item.thumb" class="tui-category-img u-skeleton-circle" mode="widthFix"></image>
                        <view class="tui-category-name margin-top-sm u-skeleton-fillet">{{item.name}}</view>
                    </view>
                </block>
            </view>

            <!--<view class="tui-rolling-news list-item ">
                <tui-icon name="news" :size="22" color="#555"></tui-icon>
                &lt;!&ndash;<image src="/static/images/index/news.png" mode="widthFix" class="margin-right-sm" style="width: 18%;">&ndash;&gt;
                    <swiper :vertical="true" :autoplay="true" :circular="true" :interval="4000" class="tui-swiper">
                        <swiper-item v-for="(item, index) in headlines" :key="index" class="tui-swiper-item">
                            <view class="tui-news-item">{{ item }}</view>
                        </swiper-item>
                    </swiper>
            </view>-->

            <view class="margin-top-sm tui-pb-20 tui-bg-white " v-if="recommands.length>0">
                <view class="tui-group-name" @tap="">
                    <!--<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>-->
                    <text class="padding-lr-xs">新品推荐</text>
                    <!--<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>-->
                </view>
                <scroll-view class="floor-list margin-tb-sm " scroll-x>
                    <view class="flex" >
                        <block v-for="(item,index) in recommands" >
                            <view @click="$Router.push({name:'goods_detail',params:{id:item.id}})" class="floor-item margin-left-sm" style="width: 230rpx;">
                                <image :src="item.thumb" mode="aspectFill" style="width: 230rpx;height: 230rpx;z-index: 2;border-radius: 10rpx;"></image>
                                <view class="text-sml tui-pro-tit" >{{item.title}}</view>
                                <view >
                                    <text class="text-price text-red margin-right-xs">{{item.marketprice}}</text>
                                    <text class="text-price text-sm tui-original-pri">{{item.minprice}}</text>
                                </view>
                                <!--<view class="tui-pro-pay">{{ item.total }}人付款</view>-->
                            </view>
                        </block>
                    </view>
                </scroll-view>
            </view>

            <view class="margin-top-sm tui-pb-20 tui-bg-white " v-for="(item,index) in category_goods" v-if="item.goods && item.goods.length>0">
                <view class="tui-group-name" @tap="more">
                    <!--<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>-->
                    <text class="padding-lr-xs">{{item.name}}</text>
                    <!--<tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>-->
                </view>

                <view class="product-list ">
                    <block v-for="(e,i) in item.goods">
                        <view class="pro-item" @tap="$Router.push({name:'goods_detail',params:{id:e.id}})" v-if="i<4">
                            <image :src="e.thumb" class="pro-img" mode="widthFix" />
                            <view class="pro-content">
                                <view class="pro-tit">{{e.title}}</view>
                                <view>
                                    <view class="pro-price">
                                        <text class="sale-price">￥{{e.marketprice}}</text>
                                        <text class="factory-price">￥{{e.productprice}}</text>
                                    </view>
                                    <view class="pro-pay">{{e.sales}}人付款</view>
                                </view>
                            </view>
                        </view>
                    </block>
                </view>

                <scroll-view class="floor-list  margin-top-xl" scroll-x v-if="item.goods && item.goods.length>4">
                    <view class="flex align-center" >
                        <block v-for="(e,i) in item.goods">
                            <view v-if="i>3" @click="$Router.push({name:'goods_detail',params:{id:e.id}})" class="floor-item margin-left-sm" style="width: 225rpx;">
                                <image :src="e.thumb" mode="aspectFill" style="width: 225rpx;height: 225rpx;z-index: 2;border-radius: 10rpx;"></image>
                                <view class="text-sml" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{e.title}}</view>
                                <view >
                                    <text class="text-price text-red margin-right-xs">{{e.marketprice}}</text>
                                    <text class="text-price text-sm tui-original-pri">{{e.productprice}}</text>
                                </view>
                            </view>
                        </block>
                    </view>
                </scroll-view>

                <view @click="$Router.push({name:'goods_list',params:{cate_id:item.id}})" class="margin-top-xl flex align-center justify-center padding-bottom-sm" style="color: #4a4a4a;">
                    <view class="text-lg">发现更多{{item.name}}</view>
                    <tui-icon name="arrowright" :size="26"></tui-icon>
                </view>

            </view>

            <view class="tui-safearea-bottom"></view>

        </view>
        <u-skeleton :loading="loading" :animation="true" bgColor="#FFF"></u-skeleton>
	</view>
</template>
<script>
    export default {
        data() {
            return {
                loading:true,
                paddingTop: 0,
                current: 0,
                advs:[],
                hotSearch: ['休闲零食', '自热火锅', '小冰箱迷你'],
                banner: ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'],
                category:[{name:'--------'},{name:'--------'},{name:'--------'},{name:'--------'},{name:'--------'},{name:'--------'},{name:'--------'},{name:'--------'},],
                category_goods:[],
                recommands:[],
                pageIndex: 1,
                pullUpOn: true,
            };
        },
        onLoad(){
            this.paddingTop = this.CustomBar
            this.getList()
            this.getCategory()
        },
        methods: {
            getList:function (){
                this.$http.get('shop.get_shopindex').then((res)=>{
                    this.advs = res.advs
                    if(res.recommands) this.recommands = res.recommands
                    if(res.category) this.category_goods = res.category
                    this.loading = false
                })
            },
            getCategory:function (){
                this.$http.get('shop.get_category').then((res)=>{
                    this.category = res.category
                })
            },
            change: function(e) {
                this.current = e.detail.current;
            },
        },
        onNavigationBarSearchInputClicked: async function(e) {
            this.$Router.push({name:'index_search'})
        },
        onNavigationBarButtonTap(e) {
            const index = e.index;
            if (index === 0) {
                //this.$utils.toast('首页')
            } else if (index === 1) {
                // #ifdef APP-PLUS
                const pages = getCurrentPages();
                const page = pages[pages.length - 1];
                const currentWebview = page.$getAppWebview();
                currentWebview.hideTitleNViewButtonRedDot({
                    index
                });
                // #endif
                uni.navigateTo({
                    url: '/pages/message/index'
                })
            }
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
    };
</script>

<style>
	page {
		background-color: #f7f7f7;
	}

	.container {
		padding-bottom: 30rpx;
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


    /*banner*/

	.tui-banner-box {
		width: 100%;
		/*box-sizing: border-box;*/
		background: #fff;
	}

	.tui-banner-swiper {
		width: 100%;
		height: 300rpx;
	}

	.tui-banner-item {
		padding: 0 0rpx;
		/*box-sizing: border-box;*/
	}

	.tui-slide-image {
		width: 100%;
		height: 300rpx;
		display: block;
		border-radius: 12rpx;
		transition: all 0.2s linear;
		/*border-radius: 8px;
		-webkit-transform: scale(.94,.88);
		transform: scale(.94,.88);
		-webkit-transition: -webkit-transform .36s;
		transition: -webkit-transform .36s;
		transition: transform .36s;*/
		/*transition: transform .36s,-webkit-transform .36s;*/
	}

	.tui-banner-scale {
		/*transform: scaleY(0.85);*/
		transform: scale(0.95,0.9);
		transform-origin: center center;
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
		background: rgba(255, 255, 255, 0.8);
		border-radius: 16rpx;
		overflow: hidden;
	}

	.tui-banner-swiper .wx-swiper-dot-active::before {
		background: #fff;
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
			background: none;
			justify-content: space-between;
		}

	>>> .tui-banner-swiper .uni-swiper-dot::before {
			content: '';
			flex-grow: 1;
			background: rgba(255, 255, 255, 0.8);
			border-radius: 16rpx;
			overflow: hidden;
		}

	>>> .tui-banner-swiper .uni-swiper-dot-active::before {
			background: #fff;
		}

	>>> .tui-banner-swiper .uni-swiper-dot.uni-swiper-dot-active {
			width: 16rpx;
		}

	/* #endif */
	/*banner*/


	.tui-product-category {
		background-color: #fff;
		padding: 0rpx 10rpx 40rpx 10rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		font-size: 24rpx;
		color: #555;
	}

	.tui-category-item {
		width: 25%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-direction: column;
		padding-top: 30rpx;
	}

	.tui-category-img {
		width: 55%;
        height: 100rpx;
		display: block;
	}

	.tui-category-name {
		line-height: 24rpx;
	}

	.tui-product-box {
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
		/*font-weight: bold;*/
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
		background: #f9f9fa;
		/*background: #fdfaf6;*/
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
		padding: 20rpx 10rpx;
	}

	.tui-pro-tit {
		color: #2e2e2e;
		font-size: 24rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
	}

	.tui-pro-price {
		/*padding-top: 18rpx;*/
	}

	.tui-sale-price {
		font-size: 34rpx;
		font-weight: 500;
		color: #e41f19;
	}

	.tui-factory-price {
		font-size: 24rpx;
		color: #999999;
		text-decoration: line-through;
	}

	.tui-pro-pay {
		padding-top: 10rpx;
		font-size: 24rpx;
		color: #999999;
	}
	.tui-route-left {
		transform: skewY(8deg);
	}

	.tui-route-right {
		transform: skewY(-8deg);
	}

	.tui-banner-bg {
		display: flex;
		height: 180rpx;
		/*background-color: #e41f19;*/
		position: relative;
	}
	.tui-primary-bg {
		width: 50%;
		display: inline-block;
		height: 224rpx;
		border: 1px solid transparent;
		position: relative;
		/*z-index: 1;*/
		background-color: #e41f19;
	}

    /* navbar */
    .tui-content-box {
        width: 100%;
        height: 88rpx;
        padding: 0 20rpx;
        box-sizing: border-box;
        display: flex;
        align-items: center;
    }
    .tui-avatar-box {
        width: 60rpx;
        height: 60rpx;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eaeef1;
        flex-shrink: 0;
    }
    .tui-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
    }

    .tui-search-box {
        width: 100%;
        height: 60rpx;
        /*margin: 0 28rpx;*/
        border-radius: 36rpx;
        font-size: 14px;
        background-color: #f1f1f1;
        padding: 0 24rpx;
        box-sizing: border-box;
        color: #bfbfbf;
        display: flex;
        align-items: center;
    }

    .tui-bg-white {
        background-color: #ffffff !important;
    }
    .tui-search-text {
        padding-left: 10rpx;
    }

    .tui-notice-box {
        position: relative;
        flex-shrink: 0;
        font-size: 44rpx;
        color: #fff;
    }

    /*headlines*/

    .tui-rolling-news {
        width: 100%;
        padding: 0 30rpx;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .tui-rolling-news::after {
        left: 0;
    }

    .tui-swiper {
        margin-left: 8rpx;
        font-size: 28rpx;
        height: 80rpx;
        flex: 1;
    }

    .tui-swiper-item {
        display: flex;
        align-items: center;
    }

    .tui-news-item {
        line-height: 28rpx;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #555;
    }

    /*headlines*/

    .tui-original-pri{
        color: #999;
        -webkit-transform-origin: center 10%;
        transform-origin: center 10%;
        /*-webkit-transform: scale(.8);*/
        /*transform: scale(.8);*/
        /*display: -webkit-box;*/
        /*display: -webkit-flex;*/
        /*display: flex;*/
        -webkit-box-align: center;
        -webkit-align-items: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        text-decoration: line-through;
    }

    .product-list {
        display: flex;
        display: -webkit-flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: wrap;
        box-sizing: border-box;
        padding: 0 20rpx;
        background: #fff;
    }

    .pro-item {
        background: #fff;
        box-sizing: border-box;
        width: 49%;
        position: relative;
        margin-bottom: 2%;
        box-shadow: 4rpx 4rpx 20rpx rgba(0,0,0,0.03)
    }

    .pro-item::after {
        content: '';
        position: absolute;
        height: 200%;
        width: 200%;
        /*border: 1rpx solid #eaeef1;*/
        transform-origin: 0 0;
        -webkit-transform-origin: 0 0;
        -webkit-transform: scale(0.5);
        transform: scale(0.5);
        left: 0;
        top: 0;
    }

    .pro-img {
        width: 100%;
        display: block;
        border-radius: 12rpx 12rpx 0 0;
    }

    .pro-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-sizing: border-box;
        padding: 20rpx 10rpx;
        height: 220rpx;
    }
    .pro-tit {
        color: #2e2e2e;
        font-size: 26rpx;
        word-break: break-all;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .pro-price {
        /*padding-top: 18rpx;*/
    }

    .sale-price {
        font-size: 34rpx;
        font-weight: 500;
        color: #ea1500;
    }

    .factory-price {
        font-size: 24rpx;
        color: #999999;
        text-decoration: line-through;
    }

    .pro-pay {
        padding-top: 10rpx;
        font-size: 24rpx;
        color: #999999;
    }

</style>
