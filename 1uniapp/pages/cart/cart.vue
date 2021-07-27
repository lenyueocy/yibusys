<template>
	<view class="">

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
		},
		onShow(){
		},
		methods: {
            getList:function () {
				this.$http.get('member.cart.get_cart').then((res)=>{
					if(res.merch_list[0]['list']) this.dataList = res.merch_list[0]['list']
					this.calcHandle()
				})
            },
            getGuessLike:function () {
                this.$http.get('goods.get_list',{random:true}).then((res)=>{
                    this.guessLikeGoods = res.list
                })
                /*this.$http.get('member.cart.getGuessLikeGoods').then((res)=>{
                    this.guessLikeGoods = res.list
                })*/
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
				}).catch((err)=>{
				    if(err.data.error!=0) this.getList()
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
