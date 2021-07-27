<template>
	<view class="container">

		<view class="tui-edit-goods padding-sm" v-if="listData.length>0">
			<view>共收藏<text class="tui-goods-num">{{listTotal}}</text>件商品</view>
		</view>

		<mescroll-body class="" ref="mescrollRef" @init="mescrollInit" @down="downCallback" @up="upCallback" >

			<view v-if="listData.length>0">
				<view class="tui-cart-cell tui-mtop" v-for="(item,index) in listData" :key="index" >
					<tui-swipe-action :actions="[{name: '加购物车',width: 64,color: '#fff',fontsize: 28,background: '#FFC600'},{name: '移除',color: '#fff',fontsize: 28,width: 64,background: '#F82400'}]" @click="handlerButton" :params="item">
						<template v-slot:content>
							<view class="tui-goods-item" @click="$Router.push({path:'/pages/goods/detail',query:{id:item.goodsid}})">
								<image :src="item.thumb" class="tui-goods-img" />
								<view class="tui-goods-info">
									<view class="tui-goods-title margin-top-xs">{{item.title}}</view>
									<view class="tui-goods-model text-price text-red text-xl" >{{item.marketprice}} <text class="text-gray text-price text-sm margin-left-sm" style="text-decoration:line-through;">{{item.productprice}}</text> </view>
								</view>
							</view>
						</template>
					</tui-swipe-action>
				</view>
			</view>

			<view class="margin-tb-xl" style="" v-else>
				<tui-no-data :fixed="false" imgUrl="http://appstore.bai918.com/static/app/icon/toast/img_noorder_3x.png"  btnText="去逛逛" @click="$Router.push({name:'goods_list'})">
					<text class="tui-color__black">您的收藏夹中没有商品~</text>
				</tui-no-data>
			</view>

		</mescroll-body>


	</view>
</template>

<script>
    import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	export default{
        mixins: [MescrollMixin],
	    data(){
	        return {
	            listData:'',
				listTotal:0,
			}
		},
		onLoad(){
		    //this.getList()
		},
		methods: {
		    getList:function () {
                let params = {page:this.mescroll.num,pagesize:this.mescroll.size}
                this.$http.get('member.favorite.get_list',params).then((res)=>{
                    this.mescroll.endBySize(this.mescroll.size, res.total);
                    if(this.mescroll.num == 1) this.listData = [];
                    if(res.list) this.listData = this.listData.concat(res.list)
                    this.listTotal = res.total
                })
            },
            downCallback:function () {
                this.mescroll.resetUpScroll()
                this.getList()
            },
            upCallback() {
                this.getList()
            },
            handlerButton: function(e) {
                if(e.index==0){
                    this.$http.get('member.cart.add',{id:e.item.goodsid,total:1}).then((res)=>{
                        this.$utils.toast('加入购物车成功')
                        this.getList()
                    })
                }else if(e.index==1){
                    this.$http.post('member.favorite.remove',{ids:[e.item.id]}).then((res)=>{
                        this.getList()
                    })
                }

            },
		}
	}
</script>

<style>
	.container {
		padding-bottom: 120rpx;
	}

	.tui-edit-goods {
		width: 100%;
		border-radius: 12rpx;
		overflow: hidden;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: #666666;
		font-size: 26rpx;
	}

	.tui-goods-num {
		font-weight: bold;
		color: #e41f19;
	}

	.tui-cart-cell {
		width: 100%;
		background: #FFFFFF;
		padding: 20rpx 0;
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
		width: 180rpx;
		height: 180rpx !important;
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
		font-size: 30rpx;
		color: #121212;
	}

	.tui-goods-model {
		max-width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
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
