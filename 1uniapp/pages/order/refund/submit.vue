<template>
	<view class="container">
		<view class="tui-order-item">
			<tui-list-cell padding="20rpx 30rpx" :hover="false" :lineLeft="false">
				<view class="tui-goods-title"><view>商品信息</view></view>
			</tui-list-cell>
			<block v-for="(item, index) in goods" :key="index">
				<tui-list-cell padding="0" @click="detail">
					<view class="tui-goods-item">
						<image :src="item.thumb" class="tui-goods-img"></image>
						<view class="tui-goods-center">
							<view class="tui-goods-name">{{item.title}}</view>
							<view class="tui-goods-attr" v-if="item.optionid>0">{{item.optiontitle}}</view>
						</view>
						<view class="tui-price-right flex justify-between" style="flex-direction: column;">
							<view>￥{{item.price}}</view>
							<view class="margin-bottom-sm">x2</view>
						</view>
					</view>
				</tui-list-cell>
			</block>
		</view>
		<view class="tui-refund__form">
			<tui-list-cell :hover="false" padding="0" arrow>
				<view class="tui-line-cell">
					<view class="tui-title">
						<text class="tui-color__red">*</text>
						<text>申请类型</text>
					</view>
                    <picker mode="selector" :range="rtypeRange" @change="rtypeChange">
                        <input :value="rtypeRange[rtype]" placeholder-class="tui-phcolor" class="tui-input" type="text" placeholder="请选择申请类型" disabled/>
                    </picker>
				</view>
			</tui-list-cell>
			<tui-list-cell arrow padding="0" arrow>
				<view class="tui-line-cell">
					<view class="tui-title">
						<text class="tui-color__red">*</text>
						<text>申请原因</text>
					</view>
                    <picker mode="selector" :range="reasonRange" @change="reasonChange">
					    <input :value="reasonRange[reasonIndex]" placeholder-class="tui-phcolor" class="tui-input" type="text" placeholder="请选择退款原因" disabled/>
                    </picker>
				</view>
			</tui-list-cell>
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">
						<text class="tui-color__red">*</text>
						<text>退款金额</text>
					</view>
                    <view class="flex">
                        <view>￥</view>
					    <input v-model="price" placeholder-class="tui-phcolor" class="tui-input" type="text" placeholder="请输入退款金额" disabled="order.status==1" />
                    </view>
				</view>
			</tui-list-cell>
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">
                        <text class="tui-color__red"></text>
						<text>申请说明</text>
					</view>
					<input v-model="content" placeholder-class="tui-phcolor" class="tui-input"   type="text"  placeholder="请填写申请说明"/>
				</view>
			</tui-list-cell>
		</view>
		<view class="tui-btn__box">
			<tui-button height="88rpx" type="danger" shadow shape="circle" @click="submit">提交申请</tui-button>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
            res:'',
            order:'',
            goods:'',
            rtype:'',
            reason:'',
            price:'',
            content:'',
            reasonIndex:'',
            rtypeRange:[],
            reasonRange:["不想要了", "卖家缺货", "拍错了/订单信息错误", "其它"],
        };
	},
    onLoad(){
	    if(!this.$Route.query.id) {
	        this.$utils.toast('参数错误')
            setTimeout(()=>{this.$Router.back()},2000)
        }else{
	        this.getList()
        }
    },
	methods: {
        getList(){
            this.$http.get('order.refund',{id:this.$Route.query.id}).then((res)=>{
                this.res = res
                this.order = res.order
                this.goods = res.goods
                if(res.order.status==1){
                    this.price = res.price
                    this.rtype = 0
                    this.rtypeRange[0] = res.rtypeArr[0]
                }
            })
        },
        submit(){
            if(!this.rtype && this.rtype!==0){
                this.$utils.toast('请选择申请类型')
                return false;
            }
            if(!this.reason){
                this.$utils.toast('请选择申请原因')
                return false;
            }
            if(!this.price){
                this.$utils.toast('请输入退款金额')
                return false;
            }
            let params = {
                id:this.$Route.query.id,
                rtype:this.rtype,
                reason:this.reason,
                price:this.price,
                content:this.content,
            }

            this.$http.get('order.refund.submit',params).then((res)=>{
                this.$utils.toast('提交申请成功，审核通过后退款金额将原路返回')
                setTimeout(()=>{this.$Router.back()},2000)
            })
        },
        rtypeChange(e){
            this.rtype = e.detail.value
        },
        reasonChange(e){
            this.reasonIndex = e.detail.value
            this.reason = this.reasonRange[e.detail.value]
        },
    }
};
</script>

<style>
.tui-order-list {
	margin-top: 80rpx;
}

.tui-order-item {
	margin-top: 20rpx;
	border-radius: 10rpx;
	overflow: hidden;
}

.tui-goods-title {
	width: 100%;
	font-size: 28rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.tui-goods-item {
	width: 100%;
	padding: 20rpx 30rpx;
	box-sizing: border-box;
	display: flex;
	justify-content: space-between;
}

.tui-goods-img {
	width: 180rpx;
	height: 180rpx;
	display: block;
	flex-shrink: 0;
    border-radius: 12rpx;
}

.tui-goods-center {
	flex: 1;
	padding: 20rpx 8rpx;
	box-sizing: border-box;
}

.tui-goods-name {
	max-width: 310rpx;
	word-break: break-all;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	font-size: 26rpx;
	line-height: 32rpx;
}

.tui-goods-attr {
	font-size: 22rpx;
	color: #888888;
	line-height: 32rpx;
	padding-top: 20rpx;
	word-break: break-all;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
}

.tui-price-right {
	text-align: right;
	font-size: 24rpx;
	color: #888888;
	line-height: 30rpx;
	padding-top: 20rpx;
}

.tui-refund__form {
	margin-top: 20rpx;
}
.tui-line-cell {
	width: 100%;
	padding: 24rpx 30rpx;
	box-sizing: border-box;
	display: flex;
	align-items: center;
}

.tui-title {
	width: 180rpx;
	font-size: 28rpx;
	color: #666;
}
.tui-color__red{
	color: #EB0909;
	padding-right: 6rpx;
}

.tui-title-city-text {
	width: 180rpx;
	height: 40rpx;
	display: block;
	line-height: 46rpx;
}

.tui-input {
	width: 500rpx;
	font-size: 28rpx;
}

.tui-phcolor {
	color: #ccc;
	font-size: 28rpx;
}
.tui-btn__box{
	padding: 60rpx 30rpx;
}

</style>
