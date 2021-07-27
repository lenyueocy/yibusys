<template>
	<view class="container">
        <block v-for="(item,index) in goods">
            <view class="margin-top-sm">
                <tui-list-cell :hover="false">
                    <view class="tui-goods__box">
                        <image :src="item.thumb" class="tui-goods__img" mode="widthFix"></image>
                        <view class="tui-rate__box">
                            <view class="tui-rate__text">{{item.title}}</view>
                            <tui-rate :current="current" @change="rateChange($event,index)"></tui-rate>
                        </view>
                    </view>
                </tui-list-cell>
                <tui-list-cell :hover="false" padding="0">
                    <textarea class="tui-textarea" placeholder="说点什么..." maxlength="200" @input="inputContent($event,index)"></textarea>
                </tui-list-cell>
                <tui-list-cell :hover="false" >
                    <!--<view class="tui-img__title">添加图片</view>-->
                    <tui-upload :serverUrl="$store.state.uploadUrl" :limit="6" :size="10" @complete="complete($event,index)" :params="index"></tui-upload>
                </tui-list-cell>
            </view>
        </block>

        <view class="tui-check__box">
            <checkbox-group>
                <label class="tui-checkbox">
                    <checkbox color="#fff"></checkbox>
                    <text class="tui-cb__text">匿名评价</text>
                </label>
            </checkbox-group>
        </view>
		<view class="tui-btn__box">
			<tui-button @click="submit" type="danger" height="88rpx" shape="circle">提交评价</tui-button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
                current:0,
				goods: '',
                comments: [],
			}
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
                this.$http.get('order.comment',{id:this.$Route.query.id}).then((res)=>{
                    if(res.goods) {
                        this.goods = res.goods
                        res.goods.forEach((item,index)=>{
                            if(!this.comments[index]) this.comments[index] = {}
                            this.comments[index].goodsid = item.id
                        })
                    }

                })
            },
            complete(e,index){
                console.log(e)
                this.comments[index]['images'] = e.imgArr
            },
            submit(){
                this.$http.post('order.comment.submit',{orderid:this.$Route.query.id,comments:this.comments}).then((res)=>{

                })
            },
            rateChange(e,index){
                this.current = e.index
                this.comments[index]['level'] = e.index
            },
            inputContent(e,index){
                this.comments[index]['content'] = e.detail.value
            }
		}
	}
</script>

<style>
	.container {
		padding: 0rpx 20rpx;
	}

	.tui-goods__box {
		width: 100%;
		display: flex;
		align-items: center;
	}

	.tui-goods__img {
		width: 104rpx;
		height: 104rpx;
        border-radius: 12rpx;
	}

	.tui-rate__box {
		flex: 1;
		height: 100%;
		padding-left: 20rpx;
		font-size: 26rpx;
	}

	.tui-rate__text {
        color: #2e2e2e;
		margin-bottom: 16rpx;
        font-size: 22rpx;
        word-break: break-all;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
	}

	.tui-textarea {
		width: 100%;
		height: 300rpx;
		font-size: 28rpx;
		padding: 20rpx 30rpx;
		box-sizing: border-box;
		background-color: #fff;
	}

	.tui-img__title {
		padding-bottom: 24rpx;
	}

	.tui-check__box {
		padding:25rpx 30rpx;
	}

	.tui-checkbox {
		min-width: 70rpx;
		height: 45rpx;
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
		transform-origin: center 30%;
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

	.tui-cb__text {
		font-size: 28rpx;
		padding-left: 8rpx;
		color: #999;
	}

	.tui-btn__box {
		width: 100%;
		padding: 40rpx 30rpx;
		box-sizing: border-box;
	}


    /*>>>>*/
    >>>.tui-item-img{
        width: 200rpx;
        height: 200rpx;
    }
    >>>.tui-upload-add{
        width: 200rpx;
        height: 200rpx;
    }
    >>>.tui-image-item{
        width: 200rpx;
        height: 200rpx;
    }
</style>
