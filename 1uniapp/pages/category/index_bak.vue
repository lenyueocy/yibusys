<template>
	<view class="container">
		<view class="tui-searchbox">
			<view class="tui-search-input" @tap="$Router.push({name:'index_search'})">
				<icon type="search" :size="13" color="#999"></icon>
				<text class="tui-search-text">搜索商品</text>
			</view>
		</view>
		
		<scroll-view scroll-y scroll-with-animation class="tab-view" :style="{ height: height + 'px', top: top + 'px' }">
			<view :id="`id_${index}`" v-for="(item, index) in dataList" :key="index" class="tab-bar-item"
			      :class="[currentTab == index ? 'active' : '']" :data-current="index" @tap.stop="swichNav">
				<text>{{ item.name }}</text>
			</view>
			<view class="tab-bar-item" :class="[currentTab == 'price' ? 'active' : '']" :data-current="'price'"
			      @tap.stop="swichNav">
				<text>价格</text>
			</view>
			<view class="tab-bar-item" :class="[currentTab == 'brand' ? 'active' : '']" :data-current="'brand'"
			      @tap.stop="swichNav">
				<text>品牌</text>
			</view>
		</scroll-view>
		<block v-for="(item, index) in dataList" :key="index" v-if="currentTab == index">
			<scroll-view scroll-y class="right-box" :style="{ height: height + 'px', top: top + 'px' }">
				<!--内容部分 start 自定义可删除-->
				<view class="page-view" v-if="item.child[0] && item.child[0]['child']">
					<view class="class-box">
						<view v-for="(es,is) in item.child">
							<view class="class-name padding-bottom-sm padding-top-sml padding-left-xs">{{ es.name }}
							</view>
							<view class="class-item">
								<view class="g-container">
									<view class="g-box" @tap.stop="$Router.push({name:'goods_list',params:{cate_id:e.id,cate_name:e.name}})" v-for="(e,i) in es.child">
										<image :src="e.thumb" class="g-image "/>
										<view class="g-title">{{ e.name }}</view>
									</view>
								</view>
							</view>
						</view>
					
					</view>
				</view>
				<view class="page-view" v-else>
					<view class="text-center bg-white padding-top-lg text-sml">全部{{ item.name }}</view>
					<view class="class-box">
						<view class="class-item">
							<view class="g-container">
								<view class="g-box" @tap.stop="$Router.push({name:'goods_list',params:{cate_id:e.id,cate_name:e.name}})" v-for="(e,i) in item.child">
									<image :src="e.thumb" class="g-image "/>
									<view class="g-title">{{ e.name }}</view>
								</view>
							</view>
						</view>
					
					</view>
				</view>
				<!--内容部分 end 自定义可删除-->
			</scroll-view>
		</block>
		<block v-if="currentTab == 'price'">
			<scroll-view scroll-y class="right-box" :style="{ height: height + 'px', top: top + 'px' }">
				<!--内容部分 start 自定义可删除-->
				<view class="page-view bg-white" style="padding-bottom: 200rpx">
					<view class="text-center bg-white padding-top-lg text-sml">全部价格</view>
					<tui-list-view title="" unlined="all">
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'_100'}})" :arrow="true">100元以下</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'100_200'}})" :arrow="true">100-200元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'200_1000'}})" :arrow="true">200-1000元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'1000_2000'}})" :arrow="true">1000-2000元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'2000_3000'}})" :arrow="true">2000-3000元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'3000_4000'}})" :arrow="true">3000-4000元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'4000_5000'}})" :arrow="true">4000-5000元</tui-list-cell>
						<tui-list-cell @click="$Router.push({name:'goods_list',params:{price:'5000_'}})" :arrow="true">5000元以上</tui-list-cell>
					</tui-list-view>
				</view>
				<!--内容部分 end 自定义可删除-->
			</scroll-view>
		</block>
		<block v-if="currentTab == 'brand'">
            <view class="right-box" :style="{ height: height + 'px', top: top + 'px' }">
                <view style="position: absolute;top: 0;">
                    <tui-tabs :tabs="tabsList" :currentTab="tabsIndex" @change="tabsChange" :width="tabsWidth" itemWidth="33.333%" selectedColor="#CA1C1D" sliderBgColor="#CA1C1D"></tui-tabs>
                </view>
                <scroll-view scroll-y class="bg-white" :scroll-into-view="scrollViewId" style="margin-top: 80rpx;" :style="{ height: height + 'px' }">
                    <view class="page-view"  style="position: relative;padding-bottom: 80rpx">
                        <view v-for="(item,index) in brandList">
                            <view class="padding-xs padding-left-sm text-sm text-bold" style="background-color: #f6f6f6;" :id="item.letter">{{item.letter=="well"?"#":item.letter}}</view>
                            <tui-list-cell :lineLeft="false" @click="$Router.push({name:'goods_list',params:{brand_id:item1.id,brand_name:item1.name}})" v-for="(item1,index1) in item.data">
                                <view class="tui-item-box">
                                    <view class="tui-msg-box">
                                        <image :src="item1.logo" class="tui-msg-pic" ></image>
                                        <view class="tui-msg-item padding-left-sm text-sm">{{item1.name}}</view>
                                    </view>
                                </view>
                            </tui-list-cell>
                        </view>
                    </view>
                </scroll-view>
            </view>
            <!--height:indexBarHeight+'px',-->
			<view class="tui-indexed-list-bar" style="height: auto" :style="{top:indexBarTop+'px'}" @touchstart.stop="touchStart"
			      @touchmove.stop="touchMove" @touchend.stop="touchEnd" @touchcancel.stop="touchCancel">
				<view v-for="(items,index3) in brandList" :key="index3" class="tui-indexed-list-text" :style="{height:indexBarItemHeight+'px'}">
					{{items.letter=="well"?"#":items.letter}}
				</view>
			</view>
			<view class="tui-indexed-list-alert" v-if="touchmove && brandList[touchmoveIndex].letter">
				<text>{{brandList[touchmoveIndex].letter=="well"?"#":brandList[touchmoveIndex].letter}}</text>
			</view>
		</block>

	</view>
</template>

<script>
export default {
	data() {
		return {
			dataList: [],
			height: 0,
			top: 0,
            tabsWidth:0,
            tabsIndex: 0,
			currentTab: 0,
			touchmove: false, // 是否在索引表上滑动
			touchmoveIndex: -1,
			titleHeight: 0, // A字距离窗口顶部的高度
			indexBarHeight: 0, // 索引表高度
			indexBarItemHeight: 0, // 索引表子项的高度
            indexBarTop:0,
			scrollViewId: '', // scroll-view滚动到的子元素的id
			winHeight: 0,
			brandList: [],
			tabsList:[]
		};
	},
	onLoad: function (options) {
	    if(this.$Route.query.type) this.currentTab = this.$Route.query.type
		this.setTop()
		this.getList()
		setTimeout(() => {
			uni.getSystemInfo({
				success: (res) => {
					let winWidth = res.windowWidth;
					let winHeight = res.windowHeight;
					let barHeight = winHeight - uni.upx2px(232);
					this.winHeight = winHeight;
					this.indexBarHeight = barHeight;
					this.indexBarItemHeight = barHeight / 25;
					//this.titleHeight = uni.upx2px(132);
					this.tabsWidth = winWidth - uni.upx2px(200)
				}
			})
		}, 10)
	},
	methods: {
		getList() {
		    let params = {}
            if(this.tabsIndex>0) params.cate_id = this.tabsList[this.tabsIndex].id
			this.$http.get('shop.get_category', params).then((res) => {
				this.dataList = res.category
				this.brandList = res.brandList
				this.tabsList = res.brandCategoryList
                this.setIndexBarTop()
			})
		},
        setIndexBarTop() {
            uni.getSystemInfo({
                success: (res) => {
                    let winHeight = res.windowHeight;
                    let titleHeight = winHeight - (this.indexBarItemHeight * this.brandList.length)
                    this.indexBarTop = this.titleHeight = uni.upx2px(titleHeight);
                }
            })
        },
        tabsChange(e){
		    this.tabsIndex = e.index
            this.getList()
        },
		setTop() {
			uni.getSystemInfo({
				success: res => {
					let header = 92;
					let top = 0;
					//#ifdef H5
					top = 44;
					//#endif
					this.height = res.windowHeight - uni.upx2px(header);
					this.top = top + uni.upx2px(header);
				}
			});
		},
		swichNav: function (e) {
			let cur = e.currentTarget.dataset.current;
			if (this.currentTab == cur) {
				return false;
			} else {
				this.currentTab = cur;
				this.checkCor();
			}
		},
		checkCor: function () {
			/*if (this.currentTab > 6) {
				this.scrollViewId = `id_${this.currentTab - 2}`;
			} else {
				this.scrollViewId = `id_0`;
			}*/
		},
		detail(e) {
			uni.navigateTo({
				url: '../productDetail/productDetail'
			});
		},
		productList(e) {
			let key = e.currentTarget.dataset.key;
			uni.navigateTo({
				url: '../productList/productList?searchKey=' + key
			});
		},
		touchStart(e) {
			this.touchmove = true
			let pageY = e.touches[0].pageY
			let index = Math.floor((pageY - this.titleHeight) / this.indexBarItemHeight)
			let item = this.brandList[index]
			if (item) {
				this.scrollViewId = item.letter;
				this.touchmoveIndex = index
			}
		},
		touchMove(e) {
			let pageY = e.touches[0].pageY;
			let index = Math.floor((pageY - this.titleHeight) / this.indexBarItemHeight)
			let item = this.brandList[index]
			if (item) {
				this.scrollViewId = item.letter;
				this.touchmoveIndex = index
			}
		},
		touchEnd() {
			this.touchmove = false;
			this.touchmoveIndex = -1
		},
		touchCancel() {
			this.touchmove = false;
			this.touchmoveIndex = -1
		},
	}
};
</script>

<style>
	page {
		background: #F5F5F5;
	}
	
	/*.class-name{
	  background-color: #F5F5F5;
	}*/
	
	/* 左侧导航布局 start*/
	
	/* 隐藏scroll-view滚动条*/
	
	::-webkit-scrollbar {
		width: 0;
		height: 0;
		color: transparent;
	}
	
	.tui-searchbox {
		width: 100%;
		height: 92rpx;
		padding: 0 30rpx;
		box-sizing: border-box;
		background: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		position: fixed;
		left: 0;
		top: 0;
		/* #ifdef H5 */
		top: 44px;
		/* #endif */
		z-index: 100;
	}
	
	.tui-searchbox::after {
		content: '';
		position: absolute;
		border-bottom: 1rpx solid #d2d2d2;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
		bottom: 0;
		right: 0;
		left: 0;
	}
	
	.tui-search-input {
		width: 100%;
		height: 60rpx;
		background: #f1f1f1;
		border-radius: 30rpx;
		font-size: 26rpx;
		color: #999;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	
	.tui-search-text {
		padding-left: 16rpx;
	}
	
	.tab-view {
		/* height: 100%; */
		width: 180rpx;
		position: fixed;
		left: 0;
		z-index: 10;
	}
	
	.tab-bar-item {
		width: 180rpx;
		height: 110rpx;
		background: #f6f6f6;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26rpx;
		color: #444;
		font-weight: 400;
	}
	
	.active {
		position: relative;
		color: #000;
		font-size: 30rpx;
		font-weight: 600;
		background: #fcfcfc;
	}
	
	.active::before {
		content: '';
		position: absolute;
		border-left: 8rpx solid #CA1C1D;
		height: 30rpx;
		left: 0;
	}
	
	/* 左侧导航布局 end*/
	
	.right-box {
		width: 100%;
		position: fixed;
		padding-left: 200rpx;
		box-sizing: border-box;
		left: 0;
	}
	
	.page-view {
		width: 100%;
		overflow: hidden;
		/*padding-top: 20rpx;*/
		/*padding-right: 20rpx;*/
		box-sizing: border-box;
		padding-bottom: env(safe-area-inset-bottom);
	}
	
	.swiper {
		width: 100%;
		height: 220rpx;
		border-radius: 12rpx;
		overflow: hidden;
		transform: translateZ(0);
	}
	
	/* #ifdef MP-WEIXIN */
	.swiper .wx-swiper-dot {
		width: 8rpx;
		height: 8rpx;
		display: inline-flex;
		background: none;
		justify-content: space-between;
	}
	
	.swiper .wx-swiper-dot::before {
		content: '';
		flex-grow: 1;
		background: rgba(255, 255, 255, 0.8);
		border-radius: 16rpx;
		overflow: hidden;
	}
	
	.swiper .wx-swiper-dot-active::before {
		background: #fff;
	}
	
	.swiper .wx-swiper-dot.wx-swiper-dot-active {
		width: 16rpx;
	}
	
	/* #endif */
	
	/* #ifndef MP-WEIXIN */
	>>> .swiper .uni-swiper-dot {
		width: 8rpx;
		height: 8rpx;
		display: inline-flex;
		background: none;
		justify-content: space-between;
	}
	
	>>> .swiper .uni-swiper-dot::before {
		content: '';
		flex-grow: 1;
		background: rgba(255, 255, 255, 0.8);
		border-radius: 16rpx;
		overflow: hidden;
	}
	
	>>> .swiper .uni-swiper-dot-active::before {
		background: #fff;
	}
	
	>>> .swiper .uni-swiper-dot.uni-swiper-dot-active {
		width: 16rpx;
	}
	
	/* #endif */
	
	.slide-image {
		width: 100%;
		height: 220rpx;
	}
	
	.class-box {
	
	}
	
	.class-item {
		background: #fff;
		width: 100%;
		box-sizing: border-box;
		padding: 20rpx;
		/*margin-bottom: 20rpx;*/
		/*border-radius: 12rpx;*/
	}
	
	.class-name {
		font-size: 22rpx;
	}
	
	.g-container {
		/* padding-top: 20rpx; */
		display: flex;
		display: -webkit-flex;
		justify-content: flex-start;
		flex-direction: row;
		flex-wrap: wrap;
		padding-bottom: 20rpx;
	}
	
	.g-box {
		width: 33.3333%;
		text-align: center;
		padding-top: 20rpx;
	}
	
	.g-image {
		width: 120rpx;
		height: 120rpx;
	}
	
	.g-title {
		font-size: 22rpx;
	}
	
	.tui-indexed-list-bar {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: flex-start;
		z-index: 9999;
		position: absolute;
		/*top: 132rpx;*/
		right: 0;
		padding-right: 10rpx;
		width: 44rpx;
		color: #555;
		font-weight: 500;
	}
	
	.tui-indexed-list-text {
		font-size: 22rpx;
	}
	
	.tui-indexed-list-alert {
		position: absolute;
		z-index: 20;
		width: 120rpx;
		height: 120rpx;
		right: 90rpx;
		top: 50%;
		margin-top: -60rpx;
		border-radius: 24rpx;
		font-size: 50rpx;
		color: #fff;
		background-color: rgba(0, 0, 0, 0.65);
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 0;
	}
	
	.tui-indexed-list-alert text {
		line-height: 50rpx;
	}
	.tui-mtop{
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
	}

    /* 从这里开始 */
    .tui-item-box {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .tui-msg-box {
        display: flex;
        align-items: center;
    }

    .tui-msg-pic {
        width: 150rpx;
        height: 80rpx;
        display: block;
        flex-shrink: 0;
    }

    .tui-msg-item {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
