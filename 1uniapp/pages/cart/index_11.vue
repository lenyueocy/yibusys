<template>
	<view class="container">

		<view class="tui-edit-goods" v-if="dataList.length>0">
			<view>购物车共<text class="tui-goods-num">{{this.dataList.length}}</text>件商品</view>
			<view>
				<tui-button type="gray" :plain="true" shape="circle" width="160rpx" height="60rpx" :size="24" @click="editGoods">{{isEdit?"完成":"编辑商品"}}</tui-button>
			</view>
		</view>

		<view v-if="dataList.length>0">
			<view class="tui-cart-cell  tui-mtop" v-for="(item,index) in dataList" :key="index" >
				<tui-swipe-action :actions="[{name: item.iscollect?'取消收藏':'收藏',width: 64,color: '#fff',fontsize: 28,background: '#FFC600'},{name: '删除',color: '#fff',fontsize: 28,width: 64,background: '#F82400'}]" @click="handlerButton" :params="item">
					<template v-slot:content>
						<view class="tui-goods-item">
							<label class="tui-checkbox">
								<checkbox-group @change="buyChange" :data-id="item.id">
									<checkbox :value="item.id" :checked="parseInt(item.selected)==1" color="#fff"></checkbox><!--:checked="parseInt(item.selected)"-->
								</checkbox-group>
							</label>
							<image :src="item.thumb" class="tui-goods-img" />
							<view class="tui-goods-info">
								<view class="tui-goods-title">{{item.title}}</view>
								<view class="tui-goods-model" v-if="item.optiontitle">
									<view class="tui-model-text" >{{item.optiontitle}}</view>
									<tui-icon name="arrowdown" :size="16" color="#333"></tui-icon>
								</view>
								<view class="tui-price-box">
									<view class="tui-goods-price">￥{{item.marketprice|getPrice}}</view>
									<tui-numberbox :value="parseInt(item.total)" :height="36" :width="64" :min="1" :max="parseInt(item.totalmaxbuy)" :index="index" @change="changeNum"></tui-numberbox>
								</view>
							</view>
						</view>
					</template>
				</tui-swipe-action>
			</view>
		</view>
		<view class="margin-tb-xl" style="" v-else>
			<tui-no-data :fixed="false" imgUrl="http://appstore.bai918.com/static/app/icon/toast/img_noorder_3x.png"  btnText="去逛逛" @click="$Router.push({name:'goods_list'})">
				<text class="tui-color__black">您的购物车中没有商品~</text>
			</tui-no-data>
		</view>

		<!--猜你喜欢-->
		<tui-divider :size="28" :bold="true" color="#333" width="50%" :backgroundColor="'#f1f1f1'">
			<tui-icon name="like" :size="18" color="#e41f19"></tui-icon>
			<text class="tui-youlike">猜你喜欢</text>
		</tui-divider>
		<view class="tui-product-list padding-lr-sm">
			<view class="tui-product-container">
				<block v-for="(item,index) in guessLikeGoods" :key="index" v-if="(index+1)%2!=0">
					<!--商品列表-->
					<view class="tui-pro-item" hover-class="hover" :hover-start-time="150" @click="navTo('/pages/goods/detail',{id:item.id})">
						<image :src="item.thumb" class="tui-pro-img" mode="widthFix" />
						<view class="tui-pro-content">
							<view class="tui-pro-tit">{{item.title}}</view>
							<view>
								<view class="tui-pro-price">
									<text class="tui-sale-price">￥{{item.marketprice}}</text>
									<text class="tui-factory-price">￥{{item.productprice}}</text>
								</view>
								<view class="tui-pro-pay">销量{{item.salesreal}}</view>
							</view>
						</view>
					</view>
					<!--商品列表-->
					<!-- <template is="productItem" data="{{item,index:index}}" /> -->
				</block>
			</view>
			<view class="tui-product-container">
				<block v-for="(item,index) in guessLikeGoods" :key="index" v-if="(index+1)%2==0">
					<!--商品列表-->
					<view class="tui-pro-item" hover-class="hover" :hover-start-time="150" @click="navTo('/pages/goods/detail',{id:item.id})">
						<image :src="item.thumb" class="tui-pro-img" mode="widthFix" />
						<view class="tui-pro-content">
							<view class="tui-pro-tit">{{item.title}}</view>
							<view>
								<view class="tui-pro-price">
									<text class="tui-sale-price">￥{{item.marketprice}}</text>
									<text class="tui-factory-price">￥{{item.productprice}}</text>
								</view>
								<view class="tui-pro-pay">销量{{item.salesreal}}</view>
							</view>
						</view>
					</view>
				</block>
			</view>
		</view>

		<!--tabbar-->
		<view class="tui-tabbar" v-if="dataList">
			<view class="tui-checkAll">
				<checkbox-group @change="checkAll" >
					<label class="tui-checkbox">
						<checkbox :checked="isAll" color="#fff"></checkbox>
						<text class="tui-checkbox-pl">全选</text>
					</label>
				</checkbox-group>
				<view class="tui-total-price" v-if="!isEdit">合计:<text class="tui-goods-price">￥{{totalPrice|getPrice}}</text> </view>
			</view>
			<view>
				<tui-button width="200rpx" height="70rpx" :size="30" type="danger" shape="circle" v-if="!isEdit" @click="submit">去结算</tui-button>
				<tui-button width="200rpx" height="70rpx" :size="30" type="danger" shape="circle" :plain="true" @click="remove" v-else>删除</tui-button>
			</view>
		</view>
		<!--加载loadding-->
		<tui-loadmore v-if="loadding" :index="3" type="red"></tui-loadmore>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				dataList: [],
				isAll: false,
				totalPrice: 0,
				buyNum: 0,
				cartIds: [], //购物车id
				actions: [{name: '收藏',width: 64,color: '#fff',fontsize: 28,background: '#FFC600'},{name: '删除',color: '#fff',fontsize: 28,width: 64,background: '#F82400'}],
				isEdit: false,
				pageIndex: 1,
				loadding: false,
				pullUpOn: true,
                guessLikeGoods: '',
			}
		},
		filters: {
			getPrice(price) {
				price = parseInt(price) || 0;
				return price.toFixed(2)
			}
		},
		onLoad(){
		    this.getList()
			this.getGuessLike()
		},
		onShow(){
            this.getList()
            this.getGuessLike()
		},
		methods: {
            getList:function () {
				this.$http.get('member.cart.get_cart').then((res)=>{
					if(res.merch_list[0]['list']) this.dataList = res.merch_list[0]['list']
					this.calcHandle()
				})
            },
            getGuessLike:function () {
                this.$http.get('member.cart.getGuessLikeGoods').then((res)=>{
                    this.guessLikeGoods = res.list
                })
            },
            remove:function () {
                let ids = {},selectedNum = 0
                this.dataList.map((item) => {
                    if (parseInt(item.selected)==1) {
                        ids[item.id] = item.id
                        selectedNum++
					}
                })
				if(selectedNum<1){
                    this.$utils.toast('请选择你要删除的商品')
					return;
				}
                this.$http.get('member.cart.remove',{ids:ids}).then((res)=>{
                    this.getList()
                    this.isEdit = !this.isEdit;
                })
            },
			calcHandle() {
				let buyNum = 0;
				let totalPrice = 0;
				let selectedNum = 0;
				this.dataList.map((item) => {
					if (parseInt(item.selected)==1) {
						buyNum += item.total;
						totalPrice += parseInt(item.marketprice) * parseInt(item.total);
						selectedNum++
					}
				})
				this.isAll = selectedNum === this.dataList.length
				this.buyNum = buyNum
				this.totalPrice = totalPrice
			},
			changeNum: function(e) {
				const params = {id:this.dataList[e.index].id,total:e.value}
				if(this.dataList[e.index].optionid) params.optionid = this.dataList[e.index].optionid
                this.$http.get('member.cart.update',params).then((res)=>{
				    this.dataList[e.index].total = e.value
                    setTimeout(() => {this.calcHandle()}, 0)
				})
			},
			handlerButton: function(e) {
                if(e.index==0){
                    this.$http.get('goods.collection',{id:e.item.goodsid}).then((res)=>{
                        this.$utils.toast(res.message);
                        this.getList()
                    })
				}else if(e.index==1){
					this.$http.get('member.cart.remove',{ids:{0:e.item.id}}).then((res)=>{
						this.getList()
					})
				}

			},
			editGoods: function() {
				// #ifdef H5 || MP
				this.isEdit = !this.isEdit;
				// #endif
			},
            submit() {
				this.$http.get('member.cart.submit').then((res)=>{
					this.$Router.push({name:'order_submit'})
				})
                /*this.$http.get('order.create.caculate').then((res)=>{

                })*/
			},
			buyChange(e) {
                this.cartIds = e.detail.value;
				/*this.$http.get('member.cart.selectedStatus',{ids:e.detail.value,selected:0}).then((res)=>{
                    this.dataList.map(item => {
                        if (~this.cartIds.indexOf(item.id)) {
                            item.selected = 1;
                        } else {
                            item.selected = 0;
                        }
                    })
                    setTimeout(() => {this.calcHandle()}, 0)
				})*/
				let id = e.currentTarget.dataset.id
				let selected = this.cartIds.indexOf(id)>=0?1:0
                const params = {ids:id,selected:selected}
                this.dataList.map(item => {
                    if(item.id == id) {
                        item.selected = selected
					}
                })
				this.$http.get('member.cart.selectedStatus',params).then((res)=>{

				})
				setTimeout(() => {this.calcHandle()}, 0)
			},
			checkAll(e) {
				this.isAll = !this.isAll;
				console.log(this.isAll)
				let buyNum = 0;
				let totalPrice = 0;
				this.dataList.map((item) => {
					item.selected = this.isAll?1:0;
					if (this.isAll) {
						buyNum += item.total;
						totalPrice += parseInt(item.marketprice) * parseInt(item.total);
					}
				})
				this.totalPrice = totalPrice;
				this.buyNum = buyNum;
			},
            navTo:function (url,params) {
                params = params||{}
                let tabArr = ['/pages/index/index','/pages/tabbar/integralmall','/pages/tabbar/luckybag','/pages/tabbar/cart','/pages/member/index']
                if(tabArr.indexOf(url)>=0) this.$Router.pushTab({path:url})
                else this.$Router.push({path:url,query:params})
            },
		},

	}
</script>

<style>
	.container {
		padding-bottom: 120rpx;
	}

	.tui-mtop {
		margin-top: 24rpx;
	}

	.tui-edit-goods {
		width: 100%;
		border-radius: 12rpx;
		overflow: hidden;
		padding: 24rpx 30rpx 0 30rpx;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: #333;
		font-size: 24rpx;
	}

	.tui-goods-num {
		font-weight: bold;
		color: #e41f19;
	}

	.tui-cart-cell {
		width: 100%;
		border-radius: 12rpx;
		background: #FFFFFF;
		padding: 40rpx 0;
		overflow: hidden;
	}

	.tui-goods-item {
		display: flex;
		padding: 0 30rpx;
		box-sizing: border-box;
	}

	.tui-checkbox {
		min-width: 70rpx;
		display: flex;
		align-items: center;
	}

	/* #ifdef MP-WEIXIN */
	.tui-checkbox .wx-checkbox-input {
		width: 40rpx;
		height: 40rpx;
		margin-right: 0 !important;
		border-radius: 50% !important;
		transform: scale(0.8);
		border-color: #d1d1d1 !important;
	}

	.tui-checkbox .wx-checkbox-input.wx-checkbox-input-checked {
		background: #eb0909;
		width: 44rpx !important;
		height: 44rpx !important;
		border: none;
	}

	/* #endif */
	/* #ifndef MP-WEIXIN */

	>>>.tui-checkbox .uni-checkbox-input {
		width: 40rpx;
		height: 40rpx;
		margin-right: 0 !important;
		border-radius: 50% !important;
		transform: scale(0.8);
		border-color: #d1d1d1 !important;
	}

	>>>.tui-checkbox .uni-checkbox-input.uni-checkbox-input-checked {
		background: #eb0909;
		width: 45rpx !important;
		height: 45rpx !important;
		border: none;
	}

	/* #endif */
	.tui-goods-img {
		width: 220rpx;
		height: 220rpx !important;
		border-radius: 12rpx;
		flex-shrink: 0;
		display: block;
	}

	.tui-goods-info {
		width: 100%;
		padding-left: 20rpx;
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: space-between;
		box-sizing: border-box;
		overflow: hidden;
	}

	.tui-goods-title {
		white-space: normal;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		font-size: 24rpx;
		color: #333;
	}

	.tui-goods-model {
		max-width: 100%;
		color: #333;
		background: #F5F5F5;
		border-radius: 40rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 16rpx;
		box-sizing: border-box;
	}

	.tui-model-text {
		max-width: 100%;
		transform: scale(0.9);
		transform-origin: 0 center;
		font-size: 24rpx;
		line-height: 32rpx;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.tui-price-box {
		width: 100%;
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
	}

	.tui-goods-price {
		font-size: 34rpx;
		font-weight: 500;
		color: #e41f19;
	}

	.tui-scale {
		transform: scale(0.8);
		transform-origin: 100% 100%;
	}

	.tui-activity {
		font-size: 24rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 30rpx 20rpx 100rpx;
		box-sizing: border-box;
	}

	.tui-buy {
		display: flex;
		align-items: center
	}

	.tui-bold {
		font-weight: bold;
	}

	.tui-sub-info {
		max-width: 532rpx;
		font-size: 24rpx;
		line-height: 24rpx;
		padding: 20rpx 30rpx 10rpx 30rpx;
		box-sizing: border-box;
		color: #333;
		transform: scale(0.8);
		transform-origin: 100% center;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		margin-left: auto
	}

	.tui-invalid-text {
		width: 66rpx;
		margin-right: 4rpx;
		text-align: center;
		font-size: 24rpx;
		color: #fff;
		background: rgba(0, 0, 0, .3);
		transform: scale(0.8);
		transform-origin: center center;
		border-radius: 4rpx;
		flex-shrink: 0;
	}

	.tui-gray {
		color: #B2B2B2 !important;
	}

	.tui-goods-invalid {
		color: #555;
		font-size: 24rpx;
	}

	.tui-flex-center {
		align-items: center !important;
	}

	.tui-invalid-ptop {
		padding-top: 40rpx;
	}

	.tui-tabbar {
		width: 100%;
		height: 100rpx;
		background: #fff;
		position: fixed;
		left: 0;
		bottom: 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 30rpx;
		box-sizing: border-box;
		font-size: 24rpx;
		z-index: 99999;
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

	.tui-checkAll {
		display: flex;
		align-items: center;
	}

	.tui-checkbox-pl {
		padding-left: 12rpx;
	}

	.tui-total-price {
		padding-left: 30rpx;
		font-size: 30rpx !important;
	}

	/*猜你喜欢*/
	.tui-youlike {
		padding-left: 12rpx
	}

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
</style>
