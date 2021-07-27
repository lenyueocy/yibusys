<template>
	<view class="container">
		<!--<view class="tui-header">商品好评度 <text>98%</text></view>-->
		<view class="tui-attr-box">
			<view class="tui-attr-item" :class="{'tui-attr-active':level=='all'}" @click="change('all')">全部 <text>{{count.all||0}}</text></view>
			<view class="tui-attr-item" :class="{'tui-attr-active':level=='good'}" @click="change('good')">好评 <text>{{count.good||0}}</text></view>
			<view class="tui-attr-item" :class="{'tui-attr-active':level=='normal'}" @click="change('normal')">中评 <text>{{count.normal||0}}</text></view>
			<view class="tui-attr-item" :class="{'tui-attr-active':level=='bad'}" @click="change('bad')">差评 <text>{{count.bad||0}}</text></view>
			<view class="tui-attr-item" :class="{'tui-attr-active':level=='pic'}" @click="change('pic')">有图 <text>{{count.pic||0}}</text></view>
		</view>
		<view class="tui-evaluate__box" v-for="(item,index) in list" :key="index">
			<view class="tui-flex__center">
				<image :src="item.headimgurl" class="tui-avatar"></image>
				<view class="tui-nickname">{{item.nickname||'**'}}</view>
			</view>
			<view class="tui-content__box">
				<view class="tui-rate__box">
					<tui-rate :current="parseInt(item.level)" :size="14"></tui-rate>
					<text>{{item.createtime}}</text>
				</view>
				<view class="tui-desc">
					{{item.content}}
				</view>
				<view class="tui-img__box" v-if="item.images && item.images.length>0">
					<block v-for="(e,i) in item.images" :key="i">
						<image @tap.stop="$utils.previewImage(i,item.images)" :class="{'tui-image':item.images.length===1}" :src="e"
						 :mode="item.images.length===1?'widthFix':'aspectFill'"></image>
					</block>
				</view>
				<view class="tui-op__box tui-flex__center">
					<view class="tui-specs"><!--双血统；公母随机--></view>
					<view class="tui-flex__center">
						<view class="tui-op-item">
							<text :class="{'tui-color-red':item.zan}">0</text>
							<tui-icon :name="item.zan?'agree-fill':'agree'" :size="34" unit="rpx" :color="item.zan?'#EB0909':'#333'"></tui-icon>
						</view>
						<!--<view class="tui-op-item" @tap="">
							<text>0</text>
							<tui-icon name="message" :size="40" unit="rpx" color="#333"></tui-icon>
						</view>-->
					</view>
				</view>
			</view>
		</view>

		<tui-divider gradual width="50%">没有更多了</tui-divider>
        <tui-loading :fixed="false" v-if="loading"></tui-loading>
	</view>
</template>

<script>
	export default {
		data() {
			return {
                loading:false,
                level:'',
                count:'',
                list:[],
			}
		},
        onLoad(){
		    this.getCount()
		    this.getList()
        },
		methods: {
		    getCount(){
                this.$http.get('goods.get_comments',{id:this.$Route.query.id}).then((res)=>{
                    this.count = res.count
                    // this.list = res.list
                })
            },
		    getList(){
		        this.loading = true
		        this.$http.get('goods.get_comment_list',{id:this.$Route.query.id,level:this.level}).then((res)=>{
                    this.list = res.list
                    this.$nextTick(()=>{
                        this.loading = false
                    })
                })
            },
            change(level){
                this.level = level
                this.getList()
            },
		}
	}
</script>

<style>
	.tui-header {
		font-size: 24rpx;
		color: #999;
		padding: 16rpx 30rpx;
	}

	.tui-header text {
		font-weight: bold;
		padding-left: 12rpx;
		color: #333;
	}

	.tui-attr-box {
		width: 100%;
		padding: 24rpx 25rpx 0;
		box-sizing: border-box;
		font-size: 0;
		background-color: #fff;
		border-radius: 24rpx;
	}

	.tui-attr-item {
		max-width: 100%;
		min-width: 128rpx;
		height: 64rpx;
		display: -webkit-inline-flex;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		background: #fcedea;
		padding: 0 26rpx;
		box-sizing: border-box;
		border-radius: 32rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		font-size: 26rpx;
		border: 1rpx solid #fcedea;
	}

	.tui-attr-active {
		color: #e41f19;
		border: 1rpx solid #e41f19;
	}

	.tui-attr-item text {
		font-weight: bold;
		padding-left: 12rpx;
	}

	.tui-evaluate__box {
		width: 100%;
		padding: 25rpx;
		box-sizing: border-box;
		background-color: #ffffff;
		box-shadow: 0 3rpx 20rpx rgba(183, 183, 183, 0.1);
		overflow: hidden;
		margin-top: 20rpx;
		border-radius: 24rpx;
	}

	.tui-flex__center {
		display: flex;
		align-items: center;
	}

	.tui-avatar {
		width: 64rpx;
		height: 64rpx;
		border-radius: 50%;
	}

	.tui-nickname {
		font-size: 28rpx;
		padding-left: 12rpx;
	}

	.tui-content__box {
		width: 100%;
		padding: 0 30rpx;
		box-sizing: border-box;
	}

	.tui-rate__box {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 24rpx;
		color: #999;
		padding: 24rpx 0;
	}

	.tui-desc {
		font-size: 28rpx;
		word-break: break-all;
		text-align: justify;
	}

	.tui-img__box {
		width: 100%;
		font-size: 0;
		padding-top: 4rpx;
	}

	.tui-img__box image {
		width: 200rpx;
		height: 200rpx;
		margin-right: 12rpx;
		margin-top: 12rpx;
	}

	.tui-image {
		width: 400rpx !important;
		height: auto;
	}

	.tui-op__box {
		width: 100%;
		padding-top: 24rpx;
		font-size: 24rpx;
		font-weight: 500;
		justify-content: space-between;
	}

	.tui-op-item {
		display: flex;
		align-items: center;
		margin-left: 40rpx;
	}

	.tui-op-item text {
		padding-right: 6rpx;
	}

	.tui-specs {
		font-size: 24rpx;
		color: #999;
		font-weight: 400;
		word-break: break-all;
	}

	.tui-color-red {
		color: #EB0909;
	}
</style>
